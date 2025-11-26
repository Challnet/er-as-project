<?php
require_once __DIR__ . "/src/helpers.php";

$year = $_GET["year"] ?? null;
$id = $_GET["id"] ?? null;

if (!$year || !$id) {
    die("Ошибка: запись не найдена.");
}

$dir = __DIR__ . "/uploads/$year/";
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

<?php require_once __DIR__ . "/src/views/partials/head.php"; ?>

<main class="container">
    <h1><?= htmlspecialchars($entry["title"]) ?></h1>

    <?php if (!empty($entry["content"])): ?>
        <p><?= nl2br(htmlspecialchars($entry["content"])) ?></p>
    <?php endif; ?>

    <?php if (!empty($entry["file"])): ?>
        <p><a href="uploads/<?= $year ?>/<?= $entry["file"] ?>" target="_blank"> Открыть файл</a></p>
    <?php endif; ?>

    <p style="margin-top:20px;color:#777;">
        Дата последних изменений: <?= $entry["date"] ?>
    </p>

    <hr>

    <a href="service.php" class="back-btn">⬅ Вернуться</a>

    <button id="open-modal-btn" class="add-content-btn">
        ➕ Добавить
    </button>


    <!-- ==== MODAL ==== -->
    <div id="content-modal" class="modal hidden">
        <div class="modal-window">

            <button class="modal-close">✖</button>
            <h3>Добавить файл или текст</h3>

            <form action="src/actions/save-entry.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="year" value="<?= $year ?>">
                <input type="hidden" name="id" value="<?= $id ?>">

                <label>Текст (необязательно):</label>
                <textarea name="content" rows="6"></textarea>

                <label>Файл (необязательно):</label>
                <input type="file" name="file">

                <button type="submit" class="save-btn">Сохранить</button>
            </form>
        </div>
    </div>


</main>

<?php require_once __DIR__ . "/src/views/partials/footer.php"; ?>