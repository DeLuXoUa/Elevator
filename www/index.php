<?php
define('ROOT', dirname(getcwd()));
define('APP', ROOT . DIRECTORY_SEPARATOR  . 'app');
define('TMP', ROOT . DIRECTORY_SEPARATOR . 'tmp');
include_once APP.'/config/helper.php';
spl_autoload_register(function ($class) {
        $file = APP.DIRECTORY_SEPARATOR.strtolower(str_replace('\\','/',$class)).'.php';
        if (file_exists($file)){
            require_once ($file);
        }
});

try{

//    \cabin\cabin_class::instance()->touchPanel(3);

    \cabin\cabin_class::instance()->run();
}catch (Exception $e){
    echo $e->getMessage();
}
