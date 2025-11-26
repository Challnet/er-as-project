<?php

$uploadDir = __DIR__ . "/uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$year = $_POST["year"] ?? null;

if (!$year) {
    die("Год не указан");
}

$yearDir = $uploadDir . $year . "/";

if (!is_dir($yearDir)) {
    mkdir($yearDir, 0777, true);
}

// Загружаем файлы
if (!empty($_FILES["uploaded_files"])) {

    foreach ($_FILES["uploaded_files"]["name"] as $index => $name) {

        $tmp = $_FILES["uploaded_files"]["tmp_name"][$index];
        $fileName = basename($name);
        $targetFile = $yearDir . $fileName;

        if (move_uploaded_file($tmp, $targetFile)) {

            // Сохраняем дату загрузки в JSON
            $metaFile = $yearDir . "meta.json";
            $meta = [];

            if (file_exists($metaFile)) {
                $meta = json_decode(file_get_contents($metaFile), true);
            }

            $meta[$fileName] = [
                "uploaded_at" => date("d.m.Y H:i"),
            ];

            file_put_contents($metaFile, json_encode($meta, JSON_PRETTY_PRINT));

            echo "Файл $fileName загружен<br>";
        }
    }
}

echo "<br><a href='/'>Вернуться назад</a>";
