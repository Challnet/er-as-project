<?php
require_once __DIR__ . "/src/helpers.php";

$year = $_GET["year"] ?? null;
$id = $_GET["id"] ?? null;

if (!$year || !$id) {
    die("Ошибка: нет данных");
}

$dir = __DIR__ . "/uploads/$year/";
$metaFile = $dir . "meta.json";

$meta = file_exists($metaFile) ? json_decode(file_get_contents($metaFile), true) : [];

$entry = null;
foreach ($meta as $index => $item) {
    if ($item["id"] === $id) {
        $entry = $item;
        break;
    }
}

if (!$entry) {
    die("Запись не найдена");
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Редактировать запись</title>
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>

    <div class="container">

        <h2>Редактирование записи</h2>

        <form action="src/actions/update-entry.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="year" value="<?= $year ?>">
            <input type="hidden" name="id" value="<?= $id ?>">

            <label>Название:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($entry['title']) ?>" required>

            <p>Текущий файл: <?= $entry['file'] ? $entry['file'] : "Нет файла" ?></p>

            <label>Заменить файл (необязательно):</label>
            <input type="file" name="file">

            <button type="submit">💾 Сохранить изменения</button>
        </form>

        <br>
        <a href="service.php">⬅ Назад</a>

    </div>
</body>

</html>