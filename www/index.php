<?php
define('ROOT', dirname(getcwd()));
define('APP', ROOT . DIRECTORY_SEPARATOR . 'app');
define('TMP', ROOT . DIRECTORY_SEPARATOR . 'tmp');
define('WWW', ROOT . DIRECTORY_SEPARATOR . 'www');
include_once APP . '/config/helper.php';
spl_autoload_register(function ($class) {
    $file = APP . DIRECTORY_SEPARATOR . strtolower(str_replace('\\', '/', $class)) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});


if (configItem('gui')) {
    if (count($_POST)) {
        \cabin\ajax_class::instance()->parsePost($_POST);
    } else {
        include_once(WWW . '/gui.php');
    }

} else {
    try {
        \cabin\cabin_class::instance()->touchPanel(3);
        \cabin\cabin_class::instance()->run();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


