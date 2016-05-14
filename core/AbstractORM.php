<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

use PDO;

/**
 * Simple ORM base model.
 * Supports only primary key name `id` and single column primary key.
 *
 * @package core
 */
abstract class AbstractORM extends AbstractModel
{
    /**
     * @var mixed primary key
     */
    public $id;

    /**
     * The constructor
     *
     * @param mixed[] $default use to set model attributes during creation
     */
    public function __construct(array $default = [])
    {
        foreach (static::attributes() as $attr) {
            if (isset($default[$attr])) {
                $this->$attr = $default[$attr];
            }
        }
    } // end __construct()

    /**
     * Save changes to database
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        return empty($this->id) ? $this->insert() : $this->update();
    } // end save()

    /**
     * Update exists record
     *
     * @param bool     $validate   skip validation
     * @param string[] $attributes attributes to update. By default will use all attributes.
     *
     * @return bool
     */
    public function update($validate = true, array $attributes = null)
    {
        if ($validate && !$this->validate()) {
            return false;
        }
        if (!$this->id) {
            return false;
        }

        if (!$attributes) {
            $attributes = static::attributes();
        }
        $table = static::table();

        $columns = implode(
            ', ',
            array_map(
                function ($attr) {
                    return "`$attr` = :$attr";
                },
                $attributes
            )
        );

        $sql = "UPDATE `$table` SET $columns WHERE `id` = :id";

        $stmt = Core::$app->db->prepare($sql);
        $stmt->bindValue('id', $this->id);
        foreach ($attributes as $attr) {
            $stmt->bindValue(":$attr", $this->$attr);
        }

        return $stmt->execute();
    }

    /**
     * Insert new record
     *
     * @param bool     $validate   skip validation
     * @param string[] $attributes attributes to use. By default will use all attributes.
     *
     * @return bool
     */
    public function insert($validate = false, array $attributes = null)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        if (!$attributes) {
            $attributes = static::attributes();
        }

        $columns = static::getColumns($attributes);
        $table = static::table();

        $values = implode(
            ', ',
            array_map(
                function ($attr) {
                    return ":$attr";
                },
                $attributes
            )
        );

        $sql = "INSERT INTO `$table` ($columns) VALUES ($values)";

        $stmt = Core::$app->db->prepare($sql);
        foreach ($attributes as $attr) {
            $stmt->bindValue(":$attr", $this->$attr);
        }

        if (!$stmt->execute()) {
            return false;
        }

        $this->id = Core::$app->db->lastInsertId();

        return true;
    }

    /**
     * Delete the record
     * @return bool
     */
    public function delete()
    {
        if (!$this->id) {
            return false;
        }

        $table = static::table();
        $sql = "DELETE FROM `$table` WHERE `id` = :id";
        $stmt = Core::$app->db->prepare($sql);
        $stmt->bindValue('id', $this->id);

        if ($stmt->execute()) {
            $this->reset();

            return true;
        }

        return false;
    } // end delete()

    /**
     * Reset all model fields
     */
    public function reset()
    {
        $this->id = null;
        foreach (static::attributes() as $attr) {
            $this->$attr = null;
        }
    } // end reset()

    /**
     * Check if is this model new(didn't save to database)
     * @return bool
     */
    public function isNew()
    {
        return $this->id === null;
    } // end isNew()

    /**
     * Fields to fetch from database
     * This method must be override
     * @return string[]
     */
    public static function attributes()
    {
        return [];
    } // end attributes()

    /**
     * Table name
     * @return string
     */
    public static function table()
    {
        return null;
    } // end table()

    /**
     * Wrap columns in '`' char and concat to string
     *
     * @param array $attributes will use instead default attributes list
     *
     * @return string one column
     */
    public static function getColumns(array $attributes = [])
    {
        if (!$attributes) {
            $attributes = array_merge(static::attributes(), ['id']);
        }

        foreach ($attributes as &$attr) {
            $attr = "`$attr`";
        }

        $attributes = implode(', ', $attributes);

        return $attributes;
    } // end getColumns()

    /**
     * Find one record by primary key
     *
     * @param mixed $pk primary key value
     *
     * @return self|null
     */
    public static function findOneByPk($pk)
    {
        $columns = static::getColumns();
        $table = static::table();

        $sql = "
            SELECT $columns
            FROM `$table`
            WHERE `id` = :id
        ";

        $stmt = Core::$app->db->prepare($sql);
        $stmt->bindValue(':id', $pk);

        return static::findOneByStmt($stmt);
    } // end findOneByPk()

    /**
     * Find one record by assoc array
     *
     * @param mixed[] $condMap    assoc array condition that will be converted to `where` condition
     * @param mixed[] $notCondMap negative assoc array condition
     *
     * @return \core\AbstractORM|null
     */
    public static function findOneByMap(array $condMap, array $notCondMap = [])
    {
        $columns = static::getColumns();
        $table = static::table();

        $conditions = implode(
            ' AND ',
            array_merge(
                array_map(
                    function ($field) use ($condMap) {
                        $value = $condMap[$field];

                        return "`$field` = ".Core::$app->db->quote($value);
                    },
                    array_keys($condMap)
                ),
                array_map(
                    function ($field) use ($notCondMap) {
                        $value = $notCondMap[$field];

                        return "`$field` != ".Core::$app->db->quote($value);
                    },
                    array_keys($notCondMap)
                )
            )
        );

        $sql = "
            SELECT $columns
            FROM `$table`
            WHERE $conditions
        ";

        $stmt = Core::$app->db->prepare($sql);

        return static::findOneByStmt($stmt);
    } // end findOneByMap()

    /**
     * Get one record by sql
     *
     * @param \PDOStatement $stmt
     *
     * @return self|null
     */
    private static function findOneByStmt(\PDOStatement $stmt)
    {
        $attributes = array_merge(static::attributes(), ['id']);

        if (!$stmt->execute()) {
            return null;
        }

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$result) {
            return null;
        }

        $model = new static();
        foreach ($attributes as $name) {
            $model->$name = $result->$name;
        }

        return $model;
    } // end findOneByStmt()

    /**
     * Find all record
     * @return static[]
     */
    public static function findAll()
    {
        $table = static::table();
        $columns = static::getColumns();
        $attributes = array_merge(static::attributes(), ['id']);

        $sql = "
            SELECT $columns
            FROM `$table`
        ";

        $stmt = Core::$app->db->prepare($sql);
        if (!$stmt->execute()) {
            return [];
        }
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        $models = [];

        foreach ($result as $row) {
            $model = new static();
            foreach ($attributes as $name) {
                $model->$name = $row->$name;
            }
            $models[] = $model;
        }

        return $models;
    }
}
