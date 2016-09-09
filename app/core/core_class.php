<?php

namespace core;


abstract class core_class extends \library\main_class
{

    private $_in_floor;
    private $_direction; // 1-up 0-down
    private $_floors_stack = [];
    private $_run = 0;


    /**
     * Main method. Calculate floors. Without gui.
     */
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

            $i = 0;
            $this->chooseDirection(true, true);
            while (true) {
                $this->checkDirection();

                if (!$this->_run){
                    $this->stop();
                    break;
                }

                if ($this->_direction)
                    $this->_in_floor++;
                else
                    $this->_in_floor--;


//                echo 'read: ' . $i++ . ' _ ';
                echo 'Elevetor in ' . $this->_in_floor . ' floor' . "\r";

                if (in_array($this->_in_floor, $this->_floors_stack)) {
                    $this->removeFloorFromStack($this->_in_floor);
                    echo '<br>Doors open<br>' . str_repeat(' ', 4096) . PHP_EOL;
                    sleep(5);
                    echo '<br>Doors close<br>' . str_repeat(' ', 4096) . PHP_EOL;
                }

                echo '<br>' . str_repeat(' ', 4096) . PHP_EOL;
                flush();
                $this->write('_in_floor');
                sleep(configItem('lift_speed') * configItem('floor_height'));
            }
            $this->_run = 0;
        }
    }


    /**
     * Method for check correct direction.
     */
    private function checkDirection(){
        if ($this->_in_floor >= configItem('floors') ||
            $this->_in_floor <= 1 ||
            $this->_in_floor >= end($this->_floors_stack) ||
            $this->_in_floor <= reset($this->_floors_stack)
        ) {
            $this->chooseDirection(true,true);
        }
    }

    /**
     * Button stop. Stop elevator.
     */
    public function stop()
    {
        $this->_run = 0;
        $this->_floors_stack = [];
        $this->write('_floors_stack');
        return;
    }

    /**
     * Method to calculate elevator direction.
     * @param bool $updateFromFile
     * @param bool $change
     * @return int|null|void
     */

    protected function chooseDirection($updateFromFile = false, $change = false)
    {
        $direction = NULL;
        if ($updateFromFile) {
            $this->read('_in_floor');
            $this->read('_floors_stack');
        }

        if ($this->_in_floor < end($this->_floors_stack) && $this->_in_floor <= configItem('floors'))
            $direction = 1;
        elseif (count($this->_floors_stack) && $this->_in_floor > reset($this->_floors_stack) && $this->_in_floor >= 1)
            $direction = 0;
        else {
            $this->_run = 0;
            return;
        }

        if ($change) {
            $this->changeDirection($direction);
        } else {
            return $direction;
        }
    }

    /**
     * Method will change elevator direction (Up or down).
     * @param $direction
     */

    protected function changeDirection($direction)
    {
        if ($direction == 1)
            $this->_direction = 1;
        else
            $this->_direction = 0;
    }

    /**
     * Remove floor from stack.
     * @param $floor
     */

    private function removeFloorFromStack($floor)
    {
        $key = array_search($floor,$this->_floors_stack);
        unset($this->_floors_stack[$key]);
        $this->write('_floors_stack');
    }

    /**
     * Update floors stack.
     * @param $addFloor
     */

    protected function updateFloorsStack($addFloor)
    {
        $floorsStack = $this->read('_floors_stack');
        if (!in_array($addFloor, $floorsStack)) {
            $this->_floors_stack[] = $addFloor;
            sort($this->_floors_stack, SORT_NUMERIC);
            $this->write('_floors_stack');
        }
    }

    /**
     * Read params from file.
     * @param $param
     * @return mixed
     */

    private function read($param)
    {
        $this->{$param} = json_decode(file_get_contents(TMP . DIRECTORY_SEPARATOR . configItem($param)));
        return $this->{$param};
    }

    /**
     * Write to file.
     * @param $param string
     */
    private function write($param)
    {
        $value = $this->{$param};

        if(is_array($this->{$param}))
            $value = array_values($this->{$param});

        file_put_contents(TMP . DIRECTORY_SEPARATOR . configItem($param), json_encode($value));
    }

}