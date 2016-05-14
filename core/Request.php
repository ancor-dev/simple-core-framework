<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

/**
 * Helper class form working with request
 * @package core
 */
class Request
{
    /**
     * If is request method POST
     * @return bool
     */
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    } // end isPost()

    /**
     * If is request method GET
     * @return bool
     */
    public function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    } // end isGet()

    /**
     * Get one or all query params
     *
     * @param string $name    parameter name
     * @param mixed  $default default value if parameter doesn't exist
     *
     * @return mixed|array one or all QUERY parameters
     */
    public function query($name = null, $default = null)
    {
        if ($name === null) {
            return $_GET;
        }

        return isset($_GET[$name]) ? $_GET[$name] : $default;
    } // end query()

    /**
     * Get one or all params from request body
     *
     * @param string $name    parameter name
     * @param mixed  $default default value if parameter doesn't exist
     *
     * @return mixed|array one or all BODY parameters
     */
    public function body($name = null, $default = null)
    {
        if ($name === null) {
            return $_POST;
        }

        return isset($_POST[$name]) ? $_POST[$name] : $default;
    } // end body()
}
