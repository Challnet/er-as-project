<?php
require_once __DIR__ . "/src/helpers.php";
require_once __DIR__ . "/src/views/partials/head.php";

date_default_timezone_set("Asia/Almaty");

$year = $_GET["year"] ?? null;
$id = $_GET["id"] ?? null;

if (!$year || !$id) {
    die("Ошибка: запись не найдена.");
}

$dir = __DIR__ . "/uploads/results/$year/";
$metaFile = $dir . "meta.json";

$entries = file_exists($metaFile)
    ? json_decode(file_get_contents($metaFile), true)
    : [];

$entry = null;

foreach ($entries as $item) {
    if ($item["id"] === $id) {
        $entry = $item;
        break;
    }
}

if (!$entry) {
    die("Запись не найдена.");
}

?>

<main class="container">

    <h1><?= htmlspecialchars($entry["title"]) ?></h1>

    <!-- Вывод текста -->
    <?php if (!empty($entry["content"])): ?>
        <p><?= nl2br(htmlspecialchars($entry["content"])) ?></p>
    <?php endif; ?>

    <!-- Файл -->
    <?php if (!empty($entry["file"])): ?>
        <p>
            <a href="uploads/results/<?= $year ?>/<?= $entry["file"] ?>" target="_blank">📎 Открыть прикрепленный файл</a>
        </p>
    <?php endif; ?>

    <!-- Дата -->
    <p style="margin-top:20px;color:#777;">
        Последнее изменение: <?= $entry["date"] ?>
    </p>

    <hr>

    <!-- Управление -->
    <a href="results.php" class="back-btn">⬅ Вернуться</a>

    <button id="open-modal-btn" class="add-content-btn">➕ Добавить содержимое</button>


    <!-- ===== МОДАЛЬНОЕ ОКНО ===== -->
    <div id="content-modal" class="modal hidden">
        <div class="modal-window">

            <button class="modal-close">✖</button>
            <h3>Добавление текста или файла</h3>

            <form id="result-form" action="src/actions/save-result.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="year" value="<?= $year ?>">
                <input type="hidden" name="id" value="<?= $id ?>">

                <label>Текст:</label>
                <textarea name="content" rows="6"></textarea>

                <label>Файл (опционально):</label>
                <input type="file" name="file">

                <button type="submit" class="save-btn">💾 Сохранить</button>
            </form>
        </div>
    </div>

</main>

<?php require_once __DIR__ . "/src/views/partials/footer.php"; ?>
