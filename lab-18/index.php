<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Практическое задание 18</title>
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
        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 14px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            padding: 5px 0;
        }
        .menu {
            background: #333;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .menu > ul > li {
            display: inline-block;
            margin-right: 20px;
            position: relative;
        }
        .menu > ul > li > a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
        }
        .menu ul ul {
            display: none;
            position: absolute;
            background: #444;
            min-width: 150px;
            border-radius: 3px;
            top: 100%;
            left: 0;
        }
        .menu ul li:hover ul {
            display: block;
        }
        .menu ul ul li {
            display: block;
        }
        .menu ul ul li a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            display: block;
        }
        .menu ul ul li a:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <h1>Практическое задание 18</h1>

    <?php
    // ===========================================
    // ЗАДАНИЕ 1: Цикл do...while
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 1: Цикл do...while</h2>";
    
    $i = 0;
    do {
        if ($i == 0) {
            echo "$i -- это ноль.<br>";
        } elseif ($i % 2 == 0) {
            echo "$i -- чётное число.<br>";
        } else {
            echo "$i -- нечётное число.<br>";
        }
        $i++;
    } while ($i <= 10);
    
    echo "</div>";

    // ===========================================
    // ЗАДАНИЕ 2: Массив областей и городов
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 2: Области и города</h2>";
    
    $cities = [
        'Московская область' => ['Москва', 'Зеленоград', 'Клин', 'Коломна', 'Сергиев Посад'],
        'Ленинградская область' => ['Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт', 'Гатчина'],
        'Рязанская область' => ['Рязань', 'Касимов', 'Скопин', 'Сасово', 'Ряжск'],
        'Тульская область' => ['Тула', 'Новомосковск', 'Алексин', 'Щёкино', 'Донской'],
        'Калужская область' => ['Калуга', 'Обнинск', 'Людиново', 'Киров', 'Малоярославец']
    ];
    
    foreach ($cities as $region => $cityList) {
        echo "<strong>$region:</strong><br>";
        echo implode(', ', $cityList) . ".<br><br>";
    }
    
    echo "</div>";

    // ===========================================
    // ЗАДАНИЕ 3: Транслитерация
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 3: Транслитерация</h2>";
    
    function transliterate($str) {
        $translit = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            // Заглавные буквы
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Sch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
        ];
        
        return strtr($str, $translit);
    }
    
    $testString = "Привет, как дела? Ёжик съел яблоко!";
    echo "<p>Исходная строка: <strong>$testString</strong></p>";
    echo "<p>Транслитерация: <strong>" . transliterate($testString) . "</strong></p>";
    
    echo "</div>";

    // ===========================================
    // ЗАДАНИЕ 4: Динамическое меню
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 4: Динамическое меню</h2>";
    
    // Простое меню
    $menuItems = [
        'Главная' => '/',
        'О нас' => '/about',
        'Услуги' => '/services',
        'Контакты' => '/contacts',
        'Блог' => '/blog'
    ];
    
    echo "<h3>Простое меню:</h3>";
    echo "<ul style='list-style: none; padding: 0; background: #333; padding: 15px; border-radius: 5px;'>";
    foreach ($menuItems as $name => $link) {
        echo "<li style='display: inline; margin-right: 20px;'><a href='$link' style='color: white; text-decoration: none;'>$name</a></li>";
    }
    echo "</ul>";
    
    // Меню с подменю
    $menuWithSubmenu = [
        'Главная' => ['link' => '/', 'submenu' => []],
        'О нас' => ['link' => '/about', 'submenu' => []],
        'Услуги' => [
            'link' => '/services',
            'submenu' => [
                'Веб-разработка' => '/services/web',
                'Дизайн' => '/services/design',
                'SEO' => '/services/seo'
            ]
        ],
        'Блог' => [
            'link' => '/blog',
            'submenu' => [
                'Новости' => '/blog/news',
                'Статьи' => '/blog/articles',
                'Туториалы' => '/blog/tutorials'
            ]
        ],
        'Контакты' => ['link' => '/contacts', 'submenu' => []]
    ];
    
    echo "<h3>Меню с подменю:</h3>";
    echo "<div class='menu'>";
    echo "<ul>";
    foreach ($menuWithSubmenu as $name => $item) {
        echo "<li>";
        echo "<a href='{$item['link']}'>$name</a>";
        if (!empty($item['submenu'])) {
            echo "<ul>";
            foreach ($item['submenu'] as $subName => $subLink) {
                echo "<li><a href='$subLink'>$subName</a></li>";
            }
            echo "</ul>";
        }
        echo "</li>";
    }
    echo "</ul>";
    echo "</div>";
    
    echo "</div>";

    // ===========================================
    // ЗАДАНИЕ 5: Меню на движке (из практики)
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 5*: Меню на движке</h2>";
    
    // Предположим, что у нас есть "движок" с конфигом
    $config = [
        'site_name' => 'Мой сайт',
        'menu' => [
            ['title' => 'Главная', 'url' => '/', 'active' => true],
            ['title' => 'О нас', 'url' => '/about', 'active' => false],
            ['title' => 'Услуги', 'url' => '/services', 'active' => false],
            ['title' => 'Портфолио', 'url' => '/portfolio', 'active' => false],
            ['title' => 'Контакты', 'url' => '/contacts', 'active' => false]
        ]
    ];
    
    echo "<h3>Меню из конфига:</h3>";
    echo "<ul style='list-style: none; padding: 0; background: #444; padding: 15px; border-radius: 5px;'>";
    foreach ($config['menu'] as $item) {
        $active = $item['active'] ? "style='font-weight: bold; color: #ff0;'" : "";
        echo "<li style='display: inline; margin-right: 20px;'><a href='{$item['url']}' style='color: white; text-decoration: none;' $active>{$item['title']}</a></li>";
    }
    echo "</ul>";
    
    echo "</div>";

    // ===========================================
    // ЗАДАНИЕ 6: Города на букву К
    // ===========================================
    echo "<div class='task'>";
    echo "<h2>Задание 6*: Города на букву К</h2>";
    
    $cities = [
        'Московская область' => ['Москва', 'Зеленоград', 'Клин', 'Коломна', 'Сергиев Посад'],
        'Ленинградская область' => ['Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт', 'Гатчина'],
        'Рязанская область' => ['Рязань', 'Касимов', 'Скопин', 'Сасово', 'Ряжск'],
        'Тульская область' => ['Тула', 'Новомосковск', 'Алексин', 'Щёкино', 'Донской'],
        'Калужская область' => ['Калуга', 'Обнинск', 'Людиново', 'Киров', 'Малоярославец']
    ];
    
    echo "<h3>Города, начинающиеся на букву 'К':</h3>";
    foreach ($cities as $region => $cityList) {
        $kCities = array_filter($cityList, function($city) {
            return mb_substr($city, 0, 1) === 'К';
        });
        
        if (!empty($kCities)) {
            echo "<strong>$region:</strong><br>";
            echo implode(', ', $kCities) . ".<br><br>";
        }
    }
    
    echo "</div>";
    ?>
</body>
</html>