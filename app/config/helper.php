<?php

function configItem($param) {

    return parse_ini_file(APP.'/config/config.ini')[$param];

}