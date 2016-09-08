<?php

namespace core;


abstract class core_class extends \library\main_class
{

    private $_in_floor;
    private $_direction; // 1-up 0-down
    private $_floors_stack = [];
    private $_run = 0;

    public function run()
    {
        if (!$this->_run) {

            $this->_run = 1;

            set_time_limit(0);



            header('Content-Encoding: none;');
            ini_set('output_buffering', 'off');
            ini_set('zlib.output_compression', false);
            ini_set('implicit_flush', true);
            ob_implicit_flush(true);

            $i=0;
            while (true){
                if(!$this->_run)
                    $this->stop();
                if($this->_direction)

                echo 'read: ' . $i++.' _ ';
                print_r($this->read('_floors_stack'));
                echo '<br>' . str_repeat(' ', 4096) . PHP_EOL;
                flush();
                sleep(configItem('lift_speed')*configItem('floor_height'));
            }

            $this->_run = 0;
        }
    }

    public function stop()
    {
        $this->_floors_stack = [];
        $this->write('_floors_stack');
        return;
    }

    private function motor()
    {

    }

    protected function walkToFloor($floor)
    {
        $this->addToFloorsStack($floor);
    }

    protected function addToFloorsStack($floor)
    {
        if (!in_array($floor, $this->_floors_stack))
            array_push($this->_floors_stack, $floor);
        sort($this->_floors_stack, SORT_NUMERIC);
        $this->write('_floors_stack');
    }

    protected function changeDirection($direction)
    {

        if ($this->read('_in_floor') > $this->read('_floors_stack')[0])
            $this->changeDirection(1);
        elseif ($this->read('_in_floor') < end($this->read('_floors_stack')))
            $this->changeDirection(0);
        else{
            $this->_run = 0;
            return;
        }

        if ($direction == 'up' || $direction = 1)
            $this->_direction = 1;
        else
            $this->_direction = 0;

    }

    protected function removeFloorFromStack($floor)
    {
        unset($this->_floors_stack[$floor]);
    }

    protected function read($param)
    {
        $this->{$param} = json_decode(file_get_contents(TMP . DIRECTORY_SEPARATOR . configItem($param)));
        return $this->{$param};
    }

    protected function write($param)
    {
        file_put_contents(TMP . DIRECTORY_SEPARATOR . configItem($param), json_encode($this->{$param}));
    }

}