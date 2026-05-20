<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Задание по PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
            background: #f5f5f5;
        }
        .task {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-top: 0;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .result {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            font-size: 1.1em;
        }
        .note {
            color: #666;
            font-style: italic;
        }
        hr {
            border: 0;
            border-top: 2px solid #eee;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <h1>Практическое задание по PHP</h1>

    <?php
    // ЗАДАНИЕ 1: Условные операторы
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 1: Условные операторы</h2>";
    
    // Объявляем переменные с произвольными значениями
    $a = 10;
    $b = -5;
    
    echo "<p>Исходные значения: \$a = $a, \$b = $b</p>";
    
    // Выполняем проверки
    if ($a >= 0 && $b >= 0) {
        // Оба положительные (ноль считаем положительным)
        $result = $a - $b;
        echo "<p class='result'>Оба числа положительные: $a - $b = $result</p>";
    } elseif ($a < 0 && $b < 0) {
        // Оба отрицательные
        $result = $a * $b;
        echo "<p class='result'>Оба числа отрицательные: $a * $b = $result</p>";
    } else {
        // Разных знаков
        $result = $a + $b;
        echo "<p class='result'>Числа разных знаков: $a + $b = $result</p>";
    }
    
    echo "</div>";


    // ЗАДАНИЕ 2: Оператор switch
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 2: Вывод чисел от a до 15</h2>";
    
    $a = 8; // значение в промежутке [0..15]
    echo "<p>Стартовое значение: \$a = $a</p>";
    
    echo "<p class='result'>Числа от $a до 15: ";
    switch ($a) {
        case 0: echo "0 ";
        case 1: echo "1 ";
        case 2: echo "2 ";
        case 3: echo "3 ";
        case 4: echo "4 ";
        case 5: echo "5 ";
        case 6: echo "6 ";
        case 7: echo "7 ";
        case 8: echo "8 ";
        case 9: echo "9 ";
        case 10: echo "10 ";
        case 11: echo "11 ";
        case 12: echo "12 ";
        case 13: echo "13 ";
        case 14: echo "14 ";
        case 15: echo "15";
    }
    echo "</p>";
    echo "<p class='note'><i>Использован fall-through в switch</i></p>";
    echo "</div>";


    // ЗАДАНИЕ 3: Арифметические операции 
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 3: Функции с return</h2>";
    
    // Функции для арифметических операций
    function add($x, $y) {
        return $x + $y;
    }
    
    function subtract($x, $y) {
        return $x - $y;
    }
    
    function multiply($x, $y) {
        return $x * $y;
    }
    
    function divide($x, $y) {
        if ($y == 0) {
            return "Ошибка: деление на ноль!";
        }
        return $x / $y;
    }
    
    // Проверяем функции
    $num1 = 15;
    $num2 = 5;
    
    echo "<p>Тестируем функции с числами $num1 и $num2:</p>";
    echo "<ul>";
    echo "<li>Сложение: $num1 + $num2 = " . add($num1, $num2) . "</li>";
    echo "<li>Вычитание: $num1 - $num2 = " . subtract($num1, $num2) . "</li>";
    echo "<li>Умножение: $num1 * $num2 = " . multiply($num1, $num2) . "</li>";
    echo "<li>Деление: $num1 / $num2 = " . divide($num1, $num2) . "</li>";
    echo "</ul>";
    echo "</div>";


    // ЗАДАНИЕ 4: Общая функция mathOperation
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 4: mathOperation</h2>";
    
    function mathOperation($arg1, $arg2, $operation) {
        switch ($operation) {
            case 'сложение':
            case '+':
                return add($arg1, $arg2);
            case 'вычитание':
            case '-':
                return subtract($arg1, $arg2);
            case 'умножение':
            case '*':
                return multiply($arg1, $arg2);
            case 'деление':
            case '/':
                return divide($arg1, $arg2);
            default:
                return "Неизвестная операция";
        }
    }
    
    // Тестируем функцию
    $x = 20;
    $y = 4;
    
    echo "<p>Тестируем mathOperation с числами $x и $y:</p>";
    echo "<ul>";
    echo "<li>Сложение: " . mathOperation($x, $y, 'сложение') . "</li>";
    echo "<li>Вычитание: " . mathOperation($x, $y, '-') . "</li>";
    echo "<li>Умножение: " . mathOperation($x, $y, '*') . "</li>";
    echo "<li>Деление: " . mathOperation($x, $y, '/') . "</li>";
    echo "<li>Неизвестная операция: " . mathOperation($x, $y, 'степень') . "</li>";
    echo "</ul>";
    echo "</div>";

    // ЗАДАНИЕ 5: Текущий год 3 способами
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 5*: Текущий год тремя способами</h2>";
    
    echo "<p>Способ 1 (date('Y')): " . date('Y') . "</p>";
    echo "<p>Способ 2 (strftime): " . strftime('%Y') . "</p>";
    echo "<p>Способ 3 (getdate + массив): " . getdate()['year'] . "</p>";
    echo "</div>";

    // ЗАДАНИЕ 6: Рекурсивное возведение в степень
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 6*: Рекурсивное возведение в степень</h2>";
    
    function power($val, $pow) {
        if ($pow ==0) {
            return 1;
        }
        if ($pow <0) {
            return 1 / power($val, -$pow);
        }
        return $val* power($val, $pow - 1);
    }
    
    // Тестируем функцию
    echo "<p>2 в степени 3 = " . power(2, 3) . "</p>";
    echo "<p>5 в степени 0 = " . power(5, 0) . "</p>";
    echo "<p>3 в степени 4 = " . power(3, 4) . "</p>";
    echo "<p>2 в степени -2 = " . power(2, -2) . "</p>";
    echo "</div>";


    //  проверка всех вариантов для задания 1
    echo "<div class='task'>";
    echo "<h2>Проверка всех вариантов для задания 1</h2>";
    
    $testCases = [
        [10, 5],   // оба положительные
        [-8, -3],  // оба отрицательные
        [7, -2],   // разных знаков
        [0, 5],    // ноль и положительное
        [-4, 0]    // отрицательное и ноль
    ];
    
    foreach ($testCases as $index => $values) {
        $a = $values[0];
        $b = $values[1];
        
        echo "<p><strong>Тест " . ($index + 1) . ":</strong> a = $a, b = $b → ";
        
        if ($a >= 0 && $b >= 0) {
            echo "разность: " . ($a - $b);
        } elseif ($a < 0 && $b < 0) {
            echo "произведение: " . ($a * $b);
        } else {
            echo "сумма: " . ($a + $b);
        }
        echo "</p>";
    }
    echo "</div>";
    ?>
</body>
</html>