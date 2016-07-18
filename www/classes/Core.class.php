<?php

/**
 * Класс ядра
 * @author Anton Kritsky <admin@delca.ru>
 */
class Core
{
    protected $_db = null;
    protected $_auth = null;

    protected static $_instance;

    public static $locale;
    public static $lang;

    public static $controllerName;
    public static $actionName;


    public  $controllerSuffix =  'Controller';
    public  $actionSuffix = 'Action';

    /**
     * приватный конструктор для ограничения реализации getInstance ()
     */
    private function __construct()
    {

    }

    /**
     * Возвращает объект ядра
     * @return Core
     */
    public static function getInstance()
    {
        global $db_conf;
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->_db = new PDO($db_conf['dsn'], $db_conf['user'], $db_conf['password']);
            self::$_instance->_auth = new Auth();
        }
        return self::$_instance;
    }

    /**
     * Выполнение текущего экшена, нужного контроллера
     */
    public function run()
    {
        $this->route();

        $this->init_locale();

        $controller = new $this->controllerName;
        return $controller->{$this->actionName}();
    }


    /**
     * Маршрутизация адреса
     *
     * Разбивает текущий УРЛ на /$locale/$controller/$action
     */
    public function route()
    {
        global $locales;
        $requestUrl = $_SERVER['REQUEST_URI'];
        $requestString = $requestUrl;

        $urlParams = explode('/', $requestString);

        array_shift($urlParams);

        $path = array_shift($urlParams);

        // Если начало маршрута является префиксом локали
        if(array_key_exists($path, $locales)){
            // устанавливеам язык
            $_SESSION['lang'] = $path;
            $path = array_shift($urlParams);
        }

        $controllerName = ucfirst($path);
        if (!$controllerName) $controllerName = "Index";
        $controllerName .= $this->controllerSuffix;

        $actionName = strtolower(array_shift($urlParams));
        // Если экшн не указан
        if (!$actionName) {
            // И есть контроллер для первого параметра в адресе
            if(class_exists($controllerName)){
                $actionName = "index";
            }
            // Иначе первый параметр является экшеном для index контроллера
            else{
                $actionName = strtolower(str_replace($this->controllerSuffix, '', $controllerName));
                $controllerName = "Index".$this->controllerSuffix;
            }
        }
        $actionName .= $this->actionSuffix;

        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
    }

    /**
     * Инициализация локализации
     */
    private function init_locale()
    {
        global $locales;

        if  (!isset($_SESSION['lang'])) {
            self::$lang = 'ru';
        } else self::$lang = $_SESSION['lang'];

        self::$locale = $locales[self::$lang];

        if (!defined('LC_MESSAGES')) define('LC_MESSAGES', 5);

        $domain = 'message';

        putenv('LC_ALL=' . self::$locale);

        setlocale(LC_MESSAGES, self::$locale);

        if (!setlocale(LC_ALL, self::$locale)) {
            setlocale(LC_ALL, '');
        }

        bindtextdomain($domain, LOCALE_DIR);
        bind_textdomain_codeset($domain, 'UTF-8');
        textdomain($domain);

    }

    /**
     * Возвращает объект PDO
     * @return  PDO
     */
    public function getDb()
    {
        return self::$_instance->_db;
    }


    /**
     * Возвращает объект авторизации
     * @return Auth
     */
    public function getAuth()
    {
        return self::$_instance->_auth;
    }

    /**
     * Заглушка для синглтона
     */
    private function __clone()
    {

    }

}