<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset='utf-8'>
    <title>Elevator</title>
</head>
<link type="text/css" href="/css/my.css" rel="stylesheet" media="all" />
<body>

<span class="setting" data-position="outside" style="display: none"></span>

<div class="outside" >
    <div class="_doors outside_doors">
        <img class="outside_left _left" src="/img/door_left_ex.jpg">
        <img class="outside_right _right" src="/img/door_right_ex.jpg">
    </div>
    <div class="call_panel">
        <div class="called out_called"></div>
    </div>
    <span class="ex_floor" data-floor="1">1</span>
    <div class="display">
        <span class="display_text">--</span>
    </div>
    <img src="/img/elevator_ex.jpg">
</div>
<div class="inside" style="display: none;">
    <div class="_doors inside_doors" >
        <img class="inside_left _left" src="/img/door_left_in.jpg">
        <img class="inside_right _right" src="/img/door_right_in.jpg">
    </div>
    <div class="touch_panel" >
        <div class="called _in_call in_called_1" data-floor="1"></div>
        <div class="called _in_call in_called_2" data-floor="2"></div>
        <div class="called _in_call in_called_3" data-floor="3"></div>
        <div class="called _in_call in_called_4" data-floor="4"></div>
        <div class="called _in_call in_called_5" data-floor="5"></div>
        <div class="called _in_call in_called_6" data-floor="6"></div>
        <div class="called _in_call in_called_7" data-floor="7"></div>
        <div class="called _in_call in_called_8" data-floor="8"></div>
        <div class="called _in_call in_called_9" data-floor="9"></div>
        <div class="called _in_call in_called_10" data-floor="10"></div>
        <div class="called _in_call in_called_11" data-floor="11"></div>
        <div class="called _in_call in_called_12" data-floor="12"></div>
        <div class="called _in_call in_called_14" data-floor="14"></div>
        <div class="called _in_call in_called_call" data-floor="-"></div>
    </div>
    <img src="/img/elevator_in.jpg">
    <div class="arrows">
        <div class="arrow_up"></div>
        <div class="arrow_down"></div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/user.js"></script>
<audio id="ply" controls style="opacity: 0;">
    <source src="/sound/zastral.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
</body>
</html>