<?php
require_once __DIR__ . "/../helpers.php";

$year = $_POST["year"] ?? null;
$id = $_POST["id"] ?? null;
$title = trim($_POST["title"] ?? "");

$dir = __DIR__ . "/../../uploads/$year/";
$metaFile = $dir . "meta.json";

$meta = file_exists($metaFile) ? json_decode(file_get_contents($metaFile), true) : [];

foreach ($meta as &$item) {
    if ($item["id"] === $id) {

        $item["title"] = $title;

        if (!empty($_FILES["file"]["name"])) {
            $filename = time() . "_" . basename($_FILES["file"]["name"]);
            move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $filename);
            $item["file"] = $filename;
        }
        break;
    }
}

file_put_contents($metaFile, json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

setMessage("success", "Запись обновлена");
redirect("service.php");
exit;
