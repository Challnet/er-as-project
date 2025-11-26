<?php

require_once __DIR__ . "/../helpers.php";

// timezone
date_default_timezone_set("Asia/Almaty");

$year = $_POST["year"] ?? $_GET["year"] ?? null;
$id   = $_POST["id"]   ?? $_GET["id"]   ?? null;

if (!$year || !$id) {
    echo json_encode([
        "status" => "error", 
        "message" => "Неверные параметры (нет id или года)"
    ]);
    exit;
}

$dir = __DIR__ . "/../../uploads/results/$year/";
$metaFile = $dir . "meta.json";

if (!file_exists($metaFile)) {
    echo json_encode(["status" => "error", "message" => "Файл базы не найден"]);
    exit;
}

$meta = json_decode(file_get_contents($metaFile), true);

$found = false;

foreach ($meta as $index => $item) {
    if ($item["id"] === $id) {

        // если есть файл — удаляем
        if (!empty($item["file"]) && file_exists($dir . $item["file"])) {
            unlink($dir . $item["file"]);
        }

        unset($meta[$index]);
        $found = true;
        break;
    }
}

if (!$found) {
    echo json_encode(["status" => "error", "message" => "Запись не найдена"]);
    exit;
}

// Перезаписываем JSON
file_put_contents($metaFile, json_encode(array_values($meta), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode([
    "status" => "success",
    "message" => "Запись удалена"
]);
exit;
