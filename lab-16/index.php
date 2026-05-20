<?php
// Переменные в начале страницы
$pageTitle = "Мой первый сайт на PHP";
$pageHeading = "Добро пожаловать!";
$currentYear = date("Y");

// Функция для времени
function getFormattedTime() {
    $hours = date('G');
    $minutes = date('i');
    
    // Часы
    if ($hours % 10 == 1 && $hours % 100 != 11) {
        $hourWord = 'час';
    } elseif ($hours % 10 >= 2 && $hours % 10 <= 4 && ($hours % 100 < 10 || $hours % 100 >= 20)) {
        $hourWord = 'часа';
    } else {
        $hourWord = 'часов';
    }
    
    // Минуты
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

$currentTime = getFormattedTime();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.5;
        }
        h1 {
            color: #333;
        }
        .time-block {
            background: #f5f5f5;
            padding: 15px;
            border-left: 4px solid #666;
            margin: 20px 0;
        }
        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 30px 0 20px;
        }
        .footer {
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h1><?php echo $pageHeading; ?></h1>
    
    <div class="time-block">
        <strong>Текущее время:</strong> <?php echo $currentTime; ?>
    </div>
    
    <hr>
    
    <div class="footer">
        &copy; <?php echo $currentYear; ?>
    </div>
</body>
</html>