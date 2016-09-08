<?php
namespace cabin;

class cabin_class extends \core\core_class {


    /**
     * Панель выбора этажа в лифте
     * @param $key
     * @throws \Exception
     */
    public function touchPanel($key){
        if(is_int($key) && $key <= configItem('floors'))
            $this->walkToFloor($key);
        else
            throw new \Exception('Touch panel is broken!');
    }

    public function getFloor(){

    }

}