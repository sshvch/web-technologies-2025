<?php
// Задание 4*: Функция логирования запросов
function logRequest() {
    $logDir = 'logs';
    $logFile = $logDir . '/log.txt';
    
    // Создаем папку для логов, если её нет
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    
    // Формируем запись лога
    $logEntry = date('Y-m-d H:i:s') . ' | ' . 
                $_SERVER['REMOTE_ADDR'] . ' | ' . 
                $_SERVER['REQUEST_URI'] . ' | ' . 
                $_SERVER['HTTP_USER_AGENT'] . PHP_EOL;
    
    // Записываем в файл
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    
    // Задание 5*: Проверяем количество записей
    if (file_exists($logFile)) {
        $lines = file($logFile);
        $lineCount = count($lines);
        
        // Если больше 10 записей, архивируем
        if ($lineCount >= 10) {
            archiveLog($logFile, $logDir);
        }
    }
}

// Задание 5*: Функция архивации логов
function archiveLog($logFile, $logDir) {
    // Читаем первые 10 записей
    $lines = file($logFile);
    $firstTen = array_slice($lines, 0, 10);
    
    // Находим следующий номер для архива
    $archiveNumber = 0;
    while (file_exists($logDir . '/log' . $archiveNumber . '.txt')) {
        $archiveNumber++;
    }
    
    // Сохраняем архив
    $archiveFile = $logDir . '/log' . $archiveNumber . '.txt';
    file_put_contents($archiveFile, implode('', $firstTen));
    
    // Оставляем только новые записи (после 10-й)
    $newLines = array_slice($lines, 10);
    file_put_contents($logFile, implode('', $newLines));
}

// Вызываем логирование при каждом запросе
logRequest();
?>