<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

/**
 * Class Session
 * @package core
 */
class Session
{
    /**
     * @var Flash flash messages
     */
    public $flash;

    /**
     * Start session
     */
    public function __construct()
    {
        session_start();
        $this->flash = new Flash();
    } // end __construct()

    /**
     * Save value to storage
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    } // end set()

    /**
     * Get value from session
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($name, $default)
    {
        return Core::$app->pick($_SESSION, $name, $default);
    } // end get()
}
