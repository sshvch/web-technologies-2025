<?php
// Функция для ресайза изображения
function resizeImage($source, $destination, $maxWidth = 200, $maxHeight = 150) {
    list($width, $height, $type) = getimagesize($source);
    
    // Создаем исходное изображение в зависимости от типа
    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($source);
            break;
        case IMAGETYPE_GIF:
            $src = imagecreatefromgif($source);
            break;
        case IMAGETYPE_WEBP:
            $src = imagecreatefromwebp($source);
            break;
        default:
            return false;
    }
    
    // Вычисляем новые размеры с сохранением пропорций
    $ratio = min($maxWidth / $width, $maxHeight / $height);
    $newWidth = round($width * $ratio);
    $newHeight = round($height * $ratio);
    
    // Создаем новое изображение
    $dst = imagecreatetruecolor($newWidth, $newHeight);
    
    // Сохраняем прозрачность для PNG
    if ($type == IMAGETYPE_PNG) {
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
        imagefilledrectangle($dst, 0, 0, $newWidth, $newHeight, $transparent);
    }
    
    // Ресайз
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
    // Сохраняем результат
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($dst, $destination, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($dst, $destination, 9);
            break;
        case IMAGETYPE_GIF:
            imagegif($dst, $destination);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($dst, $destination, 90);
            break;
    }
    
    // Очищаем память
    imagedestroy($src);
    imagedestroy($dst);
    
    return true;
}

// Проверяем, был ли загружен файл
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $errors = [];
    
    // Задание 3: Проверка на тип файла
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5 МБ
    
    if (!in_array($file['type'], $allowedTypes)) {
        $errors[] = 'Недопустимый тип файла. Разрешены: JPG, PNG, GIF, WEBP';
    }
    
    // Задание 3: Проверка на размер файла
    if ($file['size'] > $maxSize) {
        $errors[] = 'Файл слишком большой. Максимальный размер: 5 МБ';
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Ошибка при загрузке файла';
    }
    
    // Если ошибок нет, обрабатываем файл
    if (empty($errors)) {
        // Генерируем уникальное имя файла
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . date('Ymd_His') . '.' . $ext;
        
        // Пути для сохранения
        $originalPath = 'images/' . $filename;
        $thumbPath = 'thumbs/' . $filename;
        
        // Перемещаем оригинал
        if (move_uploaded_file($file['tmp_name'], $originalPath)) {
            // Создаем миниатюру
            if (resizeImage($originalPath, $thumbPath)) {
                // Перенаправляем обратно с сообщением об успехе
                header('Location: index.php?upload=success');
                exit;
            } else {
                $errors[] = 'Не удалось создать миниатюру';
                // Удаляем оригинал, если не удалось создать миниатюру
                unlink($originalPath);
            }
        } else {
            $errors[] = 'Не удалось сохранить файл';
        }
    }
    
    // Если были ошибки, перенаправляем с сообщением об ошибке
    if (!empty($errors)) {
        $errorMsg = urlencode(implode(', ', $errors));
        header('Location: index.php?error=' . $errorMsg);
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>