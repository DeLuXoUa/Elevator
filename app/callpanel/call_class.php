<?php
namespace callpanel;

class call_class extends \core\core_class {


    /**
     * Панель вызова лифта с єтажа.
     * @param $key
     * @throws \Exception
     */
    public function callClick($key){
        if(is_int($key) && $key <= configItem('floors'))
            $this->updateFloorsStack($key);
        else
            throw new \Exception('Call panel is broken!');
    }

}