<?php

require_once __DIR__ . "/../helpers.php";

$year = $_POST["year"] ?? $_GET["year"] ?? null;
$id   = $_POST["id"]   ?? $_GET["id"]   ?? null;

if (!$year || !$id) {
    echo json_encode(["status" => "error", "message" => "Неверные параметры"]);
    exit;
}

$dir = __DIR__ . "/../../uploads/$year/";
$metaFile = $dir . "meta.json";

$meta = file_exists($metaFile) ? json_decode(file_get_contents($metaFile), true) : [];

foreach ($meta as $index => $item) {
    if ($item["id"] == $id) {

        if (!empty($item["file"]) && file_exists($dir . $item["file"])) {
            unlink($dir . $item["file"]);
        }

        unset($meta[$index]);
        break;
    }
}

file_put_contents($metaFile, json_encode(array_values($meta), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(["status" => "success"]);
exit;

