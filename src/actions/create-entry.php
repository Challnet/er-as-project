<?php
require_once __DIR__ . "/../helpers.php";

// Казахстан (ВКО)
date_default_timezone_set("Asia/Almaty");

$year = $_POST["year"] ?? null;

if (!$year) {
    echo json_encode(["status" => "error", "message" => "Год не передан"]);
    exit;
}

$dir = __DIR__ . "/../../uploads/$year/";
$metaFile = $dir . "meta.json";

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

// ====== Генерация названия ======

$months = [
    "01" => "января", "02" => "февраля", "03" => "марта",
    "04" => "апреля", "05" => "мая", "06" => "июня",
    "07" => "июля", "08" => "августа", "09" => "сентября",
    "10" => "октября", "11" => "ноября", "12" => "декабря"
];

$day = date("d");
$month = $months[date("m")];
$yearText = date("Y");

$title = "Объявление $day $month $yearText г.";

// ====== Создание записи ======

$entry = [
    "id" => uniqid("entry_"),
    "title" => $title,
    "content" => "",
    "file" => null,
    "date" => date("d.m.Y H:i") // <-- теперь совпадает со стилем во всех файлах
];

$meta = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true)
    : [];

$meta[] = $entry;

file_put_contents($metaFile, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode([
    "status" => "success",
    "entry" => $entry
]);

exit;
