<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace controllers;

use core\Controller;
use core\Core;

/**
 * Class ControllerBase
 * @package controllers
 */
class ControllerBase extends Controller
{
    /**
     * @inheritdoc
     */
    public function before()
    {
        parent::before();
        $this->vars['title'] = Core::$app->baseTitle;
        $this->vars['brand'] = Core::$app->baseTitle;
        $this->vars['menu'] = [
            'left' => [
                ['name' => 'Go To Site', 'url' => Core::$app->url->url('')],
                [
                    'name'   => 'Editor',
                    'url'    => Core::$app->url->urlToRoute('admin', 'editor'),
                    'active' => Core::$app->url->isUrl('admin', 'editor'),
                ],
            ],
            'right' => [
                ['name' => 'Logout', 'url' => Core::$app->url->urlToRoute('admin', 'index', 'logout')],
            ],
        ];
    } // end before()

    /**
     * Add suffix to page title
     *
     * @param string $suffix
     */
    public function setPageTitle($suffix)
    {
        $this->vars['title'] .= ' :: '.$suffix;
    } // end setPageTitle()
}
