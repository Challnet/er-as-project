<?php
require_once __DIR__ . "/../helpers.php";

// Папка для загрузок
$uploadDir = __DIR__ . "/../../uploads/documents/";

// Если папки нет — создаём
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Проверяем, что файл отправлен
if (!isset($_FILES["document"]) || $_FILES["document"]["error"] !== UPLOAD_ERR_OK) {
    setMessage("error", "Файл не был загружен");
    redirect("/service.php");
    exit;
}

$file = $_FILES["document"];

// Ограничения
$maxSize = 10 * 1024 * 1024; // 10 MB
$allowedExtensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png", "xls", "xlsx"];

// Размер файла
if ($file["size"] > $maxSize) {
    setMessage("error", "Файл слишком большой. Максимум 10 МБ");
    redirect("/service.php");
    exit;
}

// Определяем расширение
$extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

if (!in_array($extension, $allowedExtensions)) {
    setMessage("error", "Недопустимый формат файла");
    redirect("/service.php");
    exit;
}

// Генерируем новое безопасное имя
$newName = uniqid("file_", true) . "." . $extension;

// Полный путь
$destination = $uploadDir . $newName;

// Перемещаем файл
if (!move_uploaded_file($file["tmp_name"], $destination)) {
    setMessage("error", "Ошибка сохранения файла");
    redirect("/service.php");
    exit;
}

setMessage("success", "Файл успешно загружен");
redirect("/service.php");
