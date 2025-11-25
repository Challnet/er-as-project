<?php
require_once __DIR__ . "/../helpers.php";

// Устанавливаем часовой пояс ВКО / Казахстан
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

$dir = __DIR__ . "/../../uploads/$year/";
$metaFile = $dir . "meta.json";

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$entries = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true)
    : [];


/* -----------------------------------------------------------
   1) СОЗДАНИЕ НОВОГО ОБЪЯВЛЕНИЯ
------------------------------------------------------------*/
if (!$id) {

    // Для новой записи название обязательно
    if (!$title) {
        echo json_encode(["status" => "error", "message" => "Введите название объявления"]);
        exit;
    }

  date_default_timezone_set("Asia/Almaty");

$newEntry = [
    "id" => uniqid("entry_"),
    "title" => $title,
    "content" => $content,
    "file" => $uploadedFileName,
    "date" => date("d.m.Y H:i") // <-- правильный формат
];

    if ($fileUploaded) {
        $extension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
        $uploadedFileName = uniqid("file_", true) . "." . $extension;
        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $uploadedFileName);
        $newItem["file"] = $uploadedFileName;
    }

    $entries[] = $newItem;

    file_put_contents($metaFile, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo json_encode([
        "status" => "success",
        "message" => "Объявление успешно создано",
        "redirect" => "service.php"
    ]);
    exit;
}


/* -----------------------------------------------------------
   2) ОБНОВЛЕНИЕ (ДОБАВЛЕНИЕ СОДЕРЖИМОГО)
------------------------------------------------------------*/
foreach ($entries as &$entry) {
    if ($entry["id"] === $id) {

        // Пользователь должен добавить хотя бы что-то
        if (!$fileUploaded && !$content) {
            echo json_encode(["status" => "error", "message" => "Добавьте текст или файл"]);
            exit;
        }

        // Добавить файл
        if ($fileUploaded) {
            $extension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            $uploadedFileName = uniqid("file_", true) . "." . $extension;
            move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $uploadedFileName);

            // Перезаписываем старый файл, если был
            $entry["file"] = $uploadedFileName;
        }

        // Добавить текст
        if ($content) {
            $entry["content"] .= "\n\n" . $content;
        }

        $entry["date"] = date("d.m.Y H:i"); // обновляем дату изменения
        break;
    }
}

file_put_contents($metaFile, json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode([
    "status" => "success",
    "message" => "Содержимое успешно добавлено",
    "redirect" => "service.php"
]);
exit;
