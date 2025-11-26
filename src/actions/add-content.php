<?php
require_once __DIR__ . "/../helpers.php";

$year = $_POST["year"] ?? null;
$id = $_POST["id"] ?? null;
$content = trim($_POST["content"] ?? "");

if (!$year || !$id) {
    setMessage("error", "Ошибка: не хватает данных");
    redirect("view.php?year=$year&id=$id");
    exit;
}

$dir = __DIR__ . "/../../uploads/$year/";
$metaFile = $dir . "meta.json";

$entries = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true)
    : [];

$fileName = null;

if (!empty($_FILES["file"]["name"])) {
    $file = $_FILES["file"];
    $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $fileName = uniqid("attach_") . "." . $extension;
    move_uploaded_file($file["tmp_name"], $dir . $fileName);
}

foreach ($entries as &$entry) {
    if ($entry["id"] === $id) {

        if (!isset($entry["children"])) $entry["children"] = [];

        $entry["children"][] = [
            "content" => $content,
            "file" => $fileName,
            "date" => date("d.m.Y H:i")
        ];
    }
}

file_put_contents($metaFile, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

setMessage("success", "Материал добавлен.");
redirect("view.php?year=$year&id=$id");
exit;
