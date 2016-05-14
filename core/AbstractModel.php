<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

/**
 * Base model class for working with database
 * @package core
 */
abstract class AbstractModel
{
    /**
     * @var bool
     */
    private $validated = false;
    /**
     * @var bool
     */
    private $valid = false;
    /**
     * @var string[] errors
     * @example
     * [
     *    'fieldName1' => [
     *        'message 1',
     *        'message 2',
     *        ...
     *    ],
     *    ...
     * ]
     */
    private $errors = [];


    /**
     * Validate data and save errors
     *
     * @param bool $force revalidate after validated
     *
     * @return bool
     */
    public function validate($force = false)
    {
        if (!$this->validated || $force) {
            $this->errors = [];

            foreach ($this->rules() as $rule) {
                $rule();
            }
            $this->validated = true;
            $this->valid = !count($this->errors);
        }

        return $this->valid;
    } // end validate()

    /**
     * Load attributes from array to the model
     *
     * @param mixed[]  $data   data that will be loaded
     * @param string[] $fields field names for data loading
     */
    public function load(array $data, array $fields)
    {
        foreach ($fields as $field) {
            if (property_exists(static::class, $field)) {
                $this->$field = $data[$field];
            }
        }
    } // end load()

    /**
     * return array of validators.
     * One validator - is anonymous function.
     * @return \Closure[]
     * @example
     * function() {
     *     if ( ... ) {
     *         $this->addError('field1', 'Not valid email...')
     *     }
     * }
     */
    public function rules()
    {
        return [];
    }

    /**
     * Get list of errors
     * @return string[] one error for every field
     */
    public function getErrors()
    {
        $errors = array_map(
            function ($fieldErrors) {
                return count($fieldErrors) >= 1 ? $fieldErrors[0] : null;
            },
            $this->errors
        );

        $errors = array_filter(
            $errors,
            function ($err) {
                return $err;
            }
        );

        return $errors;
    } // end getErrors()

    /**
     * Add validation message for the field
     *
     * @param string $field   field name
     * @param string $message field message
     */
    public function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        $this->errors[$field][] = $message;
    } // end addError()

    /**
     * Get one error for the field
     *
     * @param string $field
     *
     * @return string|null if exists - string, else - null
     */
    public function getError($field)
    {
        if (empty($this->errors[$field])) {
            return null;
        }

        return $this->errors[$field][0];
    } // end getError()

}
