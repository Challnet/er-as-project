<?php
require_once __DIR__ . "/../helpers.php";

// Устанавливаем часовой пояс Казахстан (ВКО)
date_default_timezone_set('Asia/Almaty');

$year = $_POST["year"] ?? null;
$id = $_POST["id"] ?? null;
$title = trim($_POST["title"] ?? "");
$content = trim($_POST["content"] ?? "");
$fileUploaded = !empty($_FILES["file"]["name"]);

if (!$year) {
    echo json_encode(["status" => "error", "message" => "Ошибка: не указан год"]);
    exit;
}

$dir = __DIR__ . "/../../uploads/results/$year/";
$metaFile = $dir . "meta.json";

// Создаем папку если отсутствует
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$entries = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true)
    : [];

/* -----------------------------------------------------------
   1) СОЗДАНИЕ НОВОЙ ЗАПИСИ
------------------------------------------------------------*/
if (!$id) {

    if (!$title) {
        echo json_encode(["status" => "error", "message" => "Введите название записи"]);
        exit;
    }

    $uploadedFileName = null;

    if ($fileUploaded) {
        $extension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
        $uploadedFileName = uniqid("file_", true) . "." . $extension;
        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $uploadedFileName);
    }

    $newEntry = [
        "id" => uniqid("entry_"),
        "title" => $title,
        "content" => $content,
        "file" => $uploadedFileName,
        "date" => date("d.m.Y H:i") // формат Казахстана
    ];

    $entries[] = $newEntry;

    file_put_contents($metaFile, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode([
        "status" => "success",
        "message" => "Запись успешно создана",
        "redirect" => "results.php"
    ]);
    exit;
}


/* -----------------------------------------------------------
   2) ОБНОВЛЕНИЕ СУЩЕСТВУЮЩЕЙ ЗАПИСИ
------------------------------------------------------------*/
foreach ($entries as &$entry) {
    if ($entry["id"] === $id) {

        if (!$fileUploaded && !$content) {
            echo json_encode(["status" => "error", "message" => "Добавьте текст или файл"]);
            exit;
        }

        // Добавляем файл
        if ($fileUploaded) {
            $extension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            $uploadedFileName = uniqid("file_", true) . "." . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $uploadedFileName);

            $entry["file"] = $uploadedFileName;
        }

        // Добавляем текст
        if ($content) {
            $entry["content"] .= "\n\n" . $content;
        }

        // Обновляем дату
        $entry["date"] = date("d.m.Y H:i");
        break;
    }
}

file_put_contents($metaFile, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode([
    "status" => "success",
    "message" => "Изменения сохранены",
    "redirect" => "results.php"
]);
exit;
