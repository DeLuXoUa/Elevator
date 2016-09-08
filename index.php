<?php
define('ROOT',realpath(dirname(__FILE__). DIRECTORY_SEPARATOR));
define('APP', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app'));
define('TMP', realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tmp'));
include_once APP.'/config/helper.php';
spl_autoload_register(function ($class) {
        $file = APP.DIRECTORY_SEPARATOR.strtolower(str_replace('\\','/',$class)).'.php';
        if (file_exists($file)){
            require_once ($file);
        }
});

try{

    \cabin\cabin_class::instance()->touchPanel(5);

    \cabin\cabin_class::instance()->run();
}catch (Exception $e){
    echo $e->getMessage();
}
