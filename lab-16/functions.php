<?php
function getFormattedTime() {
    $hours = date('G');
    $minutes = date('i');
    
    if ($hours % 10 == 1 && $hours % 100 != 11) {
        $hourWord = 'час';
    } elseif ($hours % 10 >= 2 && $hours % 10 <= 4 && ($hours % 100 < 10 || $hours % 100 >= 20)) {
        $hourWord = 'часа';
    } else {
        $hourWord = 'часов';
    }
    
    $minInt = intval($minutes);
    if ($minInt % 10 == 1 && $minInt % 100 != 11) {
        $minuteWord = 'минута';
    } elseif ($minInt % 10 >= 2 && $minInt % 10 <= 4 && ($minInt % 100 < 10 || $minInt % 100 >= 20)) {
        $minuteWord = 'минуты';
    } else {
        $minuteWord = 'минут';
    }
    
    return "$hours $hourWord $minutes $minuteWord";
}
?>