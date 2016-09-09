<?php

namespace library;

class main_class
{

    /**
     * @var array
     */
    private static $_instances = [];

    /**
     * @return \cabin\cabin_class
     * @return \core\core_class
     */
    public static function instance()
    {
        $callClass = get_called_class();

        if (!class_exists($callClass)) {
            throw new \Exception('Undefined class');
        }

        if (!isset(self::$_instances[$callClass]))
            self::$_instances[$callClass] = new $callClass();
        return self::$_instances[$callClass];
    }


    /**
     * Disable clone new & serialize
     */
    final private function __clone()
    {
    }

    private function __construct()
    {
    }

    final function __sleep()
    {
    }

}