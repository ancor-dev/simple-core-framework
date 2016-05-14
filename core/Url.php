<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

/**
 * This helper class for working with URL.
 * @package core
 */
class Url
{
    /**
     * Make url
     *
     * @param string $url
     * @param string $query
     *
     * @return string
     */
    public function url($url = null, $query = null)
    {
        $fullUrl = Core::$app->baseUrl;
        if (!empty($url)) {
            $fullUrl .= '/'.$url;
        }
        if (!empty($query)) {
            $fullUrl .= '?'.$query;
        }

        return $fullUrl;
    } // end url()

    /**
     * Make url to route
     *
     * @param string $url
     * @param string $controller
     * @param string $action
     * @param array  $params
     *
     * @return string
     */
    public function urlToRoute($url, $controller, $action = 'index', array $params = [])
    {
        $query = array_merge([
            'controller' => $controller,
            'action'     => $action,
        ], $params);

        $query = array_map(function ($item) {
            return urlencode($item);
        }, $query);

        return $this->url(
            $url,
            array_reduce(
                array_keys($query),
                function ($url, $name) use (&$query) {
                    $value = $query[$name];

                    if (!empty($url)) {
                        $url .= '&';
                    }

                    return $url."$name=$value";
                },
                ''
            )
        );
    } // end urlToRoute()

    /**
     * Check is current url match pattern
     *
     * @param string $url
     * @param string $controller
     * @param string $action
     *
     * @return bool
     */
    public function isUrl($url, $controller = null, $action = null)
    {
        $result = 3;

        if (!empty($url) && $url[0] != '/') {
            $url = "/$url";
        }

        // check path
        if (!empty($url) && strpos($_SERVER['REQUEST_URI'], $url) !== 0) {
            $result--;
        }

        // check controller
        if (!empty($controller) && Core::$app->currentController != $controller) {
            $result--;
        }

        // check action
        if (!empty($action) && Core::$app->currentAction != $action) {
            $result--;
        }

        return $result == 3;
    } // end isUrl()
}
