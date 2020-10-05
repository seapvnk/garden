<?php

// Directories
define('ROOT_PATH', str_replace('/config', '', __DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('CORE_PATH', SRC_PATH . '/core');
define('MODEL_PATH', SRC_PATH . '/model');
define('CONTROLLER_PATH', SRC_PATH . '/controller');


// Classes
require_once CORE_PATH . '/Database.php';
require_once CORE_PATH . '/Loader.php';
require_once CORE_PATH . '/Session.php';

require_once CORE_PATH . '/Model.php';
require_once CORE_PATH . '/View.php';

if (isset($GARDEN_SCOPE)) {
    parse_str(implode('&', array_slice($argv, 1)), $_GET);
}