<?php
require_once __DIR__ . "/../helpers.php";

date_default_timezone_set("Asia/Almaty");

$year = $_POST["year"] ?? null;

if (!$year) {
    echo json_encode(["status" => "error", "message" => "Год не передан"]);
    exit;
}

$dir = __DIR__ . "/../../uploads/results/$year/";
$metaFile = $dir . "meta.json";

if (!is_dir($dir)) mkdir($dir, 0777, true);

// Генерация красивого названия
$months = [
    "01" => "января", "02" => "февраля", "03" => "марта",
    "04" => "апреля", "05" => "мая", "06" => "июня",
    "07" => "июля", "08" => "августа", "09" => "сентября",
    "10" => "октября", "11" => "ноября", "12" => "декабря"
];

$title = "Результат от " . date("d") . " " . $months[date("m")] . " " . date("Y") . " г.";

$entry = [
    "id" => uniqid("result_"),
    "title" => $title,
    "content" => "",
    "file" => null,
    "date" => date("d.m.Y H:i")
];

$meta = file_exists($metaFile) ? json_decode(file_get_contents($metaFile), true) : [];

$meta[] = $entry;

file_put_contents($metaFile, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(["status" => "success"]);
exit;
