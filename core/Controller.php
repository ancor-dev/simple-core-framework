<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

/**
 * Class Controller
 * @package core
 */
class Controller
{
    /**
     * @var string layout template name
     */
    public $layout = 'layout';
    /**
     * @var array variables for layout template
     */
    public $vars = [];

    /**
     * The method will call before action call
     */
    public function before()
    {
        $vars['title']   = 'CMS';
        $vars['brand']   = 'CMS';
        $vars['content'] = '';
    } // end before()

    /**
     * The method will call after action call
     *
     * @param string $page full html page
     *
     * @return string
     */
    public function after($page)
    {
        return $page;
    } // end after()

    /**
     * Render an action template. And wrap it into layout template.
     *
     * @param string  $name action template path and name
     * @param mixed[] $vars variables for the template
     *
     * @return string
     */
    public function render($name, $vars)
    {
        $actionTpl = Core::$app->render($name, $vars);

        if ($this->layout === false) {
            return $actionTpl;
        }

        return Core::$app->render(
            'layout',
            array_merge(
                $this->vars,
                [
                    'content' => $actionTpl,
                ]
            )
        );
    } // end render()
}
