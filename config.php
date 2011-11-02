<?php
define('DEBUG', true);

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'test');

define('HOST',  $_SERVER["HTTP_HOST"]);
define('URL',  'http://' . HOST . '');
define('WWW_ROOT',  dirname(__FILE__));

define('TMP', WWW_ROOT . '/tmp/');
define('VIEWS', WWW_ROOT . '/views/');
define('MODELS', WWW_ROOT . '/models/');
define('CORE', WWW_ROOT . '/core/');


?>