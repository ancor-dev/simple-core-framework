<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace models;

use core\AbstractORM;

/**
 * Page ORM model. This model describe one page.
 * @package models
 */
class PageORM extends AbstractORM
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string page description meta tag
     */
    public $description;
    /**
     * @var string page keywords meta tag
     */
    public $keywords;

    /**
     * @inheritdoc
     */
    public static function attributes()
    {
        return [
            'name',
            'title',
            'description',
            'keywords',
        ];
    } // end attributes()

    /**
     * @inheritdoc
     */
    public static function table()
    {
        return 'page';
    } // end table()

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // field name
            function () {

                if (strlen($this->name) < 3) {
                    $this->addError('name', 'Name is too short.');
                } else {
                    if ($this->id ?
                            static::findOneByMap(['name' => $this->name], ['id' => $this->id])
                        :
                            static::findOneByMap(['name' => $this->name])
                    ) {
                        $this->addError('name', 'Name is not unique');
                    }
                }
            },
            // field title
            function () {
                if (strlen($this->title) < 3) {
                    $this->addError('title', 'Title is too short.');
                }
            },
            // field description
            function () {
                if (strlen($this->description) > 255) {
                    $this->addError('description', 'Title is too long.');
                }
            },
            // field keywords
            function () {
                if (strlen($this->keywords) > 255) {
                    $this->addError('keywords', 'Keywords is too long.');
                }
            },
        ];
    } // end rules()

    /**
     * Get one field from the page, find page by name
     *
     * @param string $name  page name
     * @param string $field name of the field that need to be extracted
     *
     * @return string field
     */
    public function fieldByPageName($name, $field)
    {
        $page = static::findOneByMap(['name' => $name]);
        if (!$page) {
            return null;
        }

        return isset($page->$field) ? $page->$field : null;
    } // end fieldByPageName()
}
