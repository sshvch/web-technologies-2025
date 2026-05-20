<?php
// Подключаем логирование (задание 4*)
include 'logger.php';

// Функция для получения списка изображений из папки
function getImages($dir) {
    $images = [];
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            // Проверяем, что это файл изображения
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $images[] = $file;
            }
        }
    }
    return $images;
}

// Получаем список изображений
$images = getImages('images');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Фотогалерея</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }
        h1 {
            color: #333;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 30px 0;
        }
        .gallery-item {
            border: 1px solid #ddd;
            padding: 10px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .gallery-item img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            display: block;
            cursor: pointer;
        }
        .upload-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            border: 1px solid #ddd;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <h1>Фотогалерея</h1>
    
    <?php
    // Показываем сообщения о результате загрузки
    if (isset($_GET['upload']) && $_GET['upload'] == 'success'):
    ?>
        <div class="message success">Файл успешно загружен!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="message error">Ошибка: <?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    
    <!-- Задание 3: Форма загрузки -->
    <div class="upload-form">
        <h2>Загрузить новое изображение</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp" required>
            <button type="submit">Загрузить</button>
        </form>
    </div>
    
    <!-- Задания 1 и 2: Галерея -->
    <div class="gallery">
        <?php if (empty($images)): ?>
            <p>В галерее пока нет изображений. Загрузите первое!</p>
        <?php else: ?>
            <?php foreach ($images as $image): ?>
                <div class="gallery-item">
                    <a href="images/<?php echo urlencode($image); ?>" target="_blank">
                        <img src="thumbs/<?php echo urlencode($image); ?>" 
                             alt="<?php echo htmlspecialchars($image); ?>"
                             onerror="this.src='images/<?php echo urlencode($image); ?>'">
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>