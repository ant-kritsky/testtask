<?php

$locales = [
    'ru' => 'ru_RU',
    'en' => 'en_US',
];

$db_conf = [
    "dsn" => "mysql:dbname=testtask;host=localhost",
    "user" => "root",
    "password" => "",
];

define('ROOT_DIR', dirname(__FILE__) . "/");
define('LOCALE_DIR', ROOT_DIR . "locale/");
define('UPLOAD_DIR', ROOT_DIR . "uploads/");
define('CLASSES_DIR', ROOT_DIR . "classes/");
define('MODEL_DIR', CLASSES_DIR . "model/");
define('TEMPLATE_DIR', ROOT_DIR . "templates/");
define('CONTROLLERS_DIR', CLASSES_DIR . "controllers/");

require_once(CLASSES_DIR . "/Core.class.php");

spl_autoload_register(__NAMESPACE__ . "Core::__autoload");