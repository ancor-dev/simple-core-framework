<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace core;

use core\models\MigrationManager;

/**
 * Class Lib
 */
class Core
{
    public $viewsDir;
    public $pubDir;
    public $cmsDir;
    public $baseUrl;
    public $baseTitle;
    /**
     * @var string path to migration dir
     */
    public $migrationsDir;
    /**
     * @var string[]
     * @example: `['file' => ..., 'username' => ..., 'password' => ...]`
     */
    public $dbOptions;

    public $currentAction;
    public $currentController;

    /**
     * @var Url
     */
    public $url;
    /**
     * @var Request
     */
    public $request;
    /**
     * @var \PDO Database connection
     */
    public $db;
    /**
     * @var MigrationManager
     */
    public $migration;
    /**
     * @var Session
     */
    public $session;

    /**
     * @var Core single tone instance
     */
    public static $app;
    /**
     * @inheritdoc
     */
    private function __construct()
    {
    } // end __construct()

    /**
     * Make instance
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$app) {
            static::$app = new static();
        }

        return static::$app;
    } // end getInstance()


    /**
     * Init environment.
     * This method will call after configuration loaded
     */
    public function init()
    {
        $this->baseUrl = '//'.$_SERVER['HTTP_HOST'];
        $this->url = new Url();
        $this->request = new Request();
        $this->db = Db::getConnection();
        $this->migration = new MigrationManager();
        $this->session = new Session();
    } // end init()

    /**
     * Set configuration
     *
     * @param array $config
     */
    public function config(array $config)
    {
        $keys = ['viewsDir', 'pubDir', 'cmsDir', 'baseTitle', 'db', 'migrationsDir'];

        foreach ($keys as $name) {
            $this->$name = static::pick($config, $name);
        }

        $this->init();
    } // end config()

    /**
     * Main request handler
     */
    public function handle()
    {
        $this->currentController = $controller = static::pick($_GET, 'controller', 'index');
        $this->currentAction     = $action     = static::pick($_GET, 'action', 'index');

        $ctrlFullName = 'controllers\\'.ucfirst($controller).'Controller';
        $actionFullName = "{$action}Action";

        if (!class_exists($ctrlFullName)) {
            $this->httpError(404, 'Page not found');
        }

        /** @var Controller $ctrl */
        $ctrl = new $ctrlFullName($controller, $action);
        if (!method_exists($ctrl, $actionFullName)) {
            $this->httpError(404, 'Page not found');
        }

        $ctrl->before();
        $page = $ctrl->$actionFullName();
        echo $ctrl->after($page);
    } // end handle()

    /**
     * Render the template and return as string
     *
     * @param string $tplName template name(or path/name)
     * @param array  $vars
     *
     * @return string
     * @throws \Exception
     */
    public function render($tplName, $vars = [])
    {
        extract($vars);

        $filePath = $this->viewsDir."/$tplName.php";
        if (!file_exists($filePath)) {
            throw new \Exception('Template not found. File path:'.$filePath);
        }

        ob_start();
        include($filePath);
        $data = ob_get_clean();

        return $data;
    } // end render()

    /**
     * Pick element from array
     *
     * @param array  $arr     an array
     * @param string $name    key name in the array
     * @param mixed  $default default value if the key is not exists
     *
     * @return mixed
     */
    public static function pick(array $arr, $name, $default = null)
    {
        return isset($arr[$name]) ? $arr[$name] : $default;
    } // end pick()

    /**
     * Send an error and status code
     *
     * @param string $code
     * @param string $message
     * @param string $title
     *
     * @throws \Exception
     */
    public function httpError($code, $message, $title = null)
    {
        http_response_code($code);

        if (!$title) {
            $title = $message;
        }

        $template = "error/$code";
        if (!file_exists(static::$app->viewsDir.'/'.$template)) {
            $template = 'error/default';
        }

        echo static::$app->render($template, [
            'code'    => $code,
            'message' => $message,
            'title'   => $this->baseTitle.' :: '.$title,
        ]);

        die;
    } // end httpError()

    /**
     * Redirect to url
     *
     * @param string $url  full url
     * @param int    $code
     */
    public function redirect($url, $code = 301)
    {
        http_response_code($code);
        header('Location: '.$url);
        die;
    } // end redirect()
}
