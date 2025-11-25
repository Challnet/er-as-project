<?php
require_once __DIR__ . "/src/views/partials/head.php";
require_once __DIR__ . "/src/helpers.php";

$pageTitle = "Результаты НИР";
require_once __DIR__ . "/src/views/partials/hero.php";

$years = ["2027", "2026", "2025"];
?>

<main class="container">
    <div class="title-block">
        <h1>Результаты научно-исследовательских работ</h1>
    </div>

    <?php if (isset($_SESSION["message"])): ?>
        <div class="alert <?= key($_SESSION['message']) ?>">
            <?= reset($_SESSION["message"]) ?>
        </div>
        <?php unset($_SESSION["message"]); ?>
    <?php endif; ?>

    <section class="years-list" data-js-years-list>
        <?php foreach ($years as $year): ?>

            <?php
            $dir = __DIR__ . "/uploads/results/$year/";
            $metaFile = $dir . "meta.json";

            $entries = file_exists($metaFile)
                ? json_decode(file_get_contents($metaFile), true)
                : [];
            ?>

            <div class="year-item" data-js-year-item>
                <button class="year-button" data-js-year-button>
                    <span><?= $year ?></span>
                    <i class="arrow" data-js-arrow></i>
                </button>

                <div class="year-content" data-js-year-content>

                    <!-- кнопка создания записи -->
                    <button class="add-result-btn" data-year="<?= $year ?>">➕ Добавить</button>

                    <ul class="entry-list">

                        <?php if (!empty($entries)): ?>
                            <?php foreach ($entries as $item): ?>
                                
                                <li class="entry-item"
                                    data-id="<?= $item['id'] ?>"
                                    data-year="<?= $year ?>"
                                >
                                    <!-- ссылка на просмотр -->
                                    <a class="entry-link" href="view-result.php?year=<?= $year ?>&id=<?= $item['id'] ?>">
                                        <?= htmlspecialchars($item['title']) ?>
                                    </a>

                                    <!-- кнопки -->
                                    <a class="edit-btn" href="edit-result.php?year=<?= $year ?>&id=<?= $item['id'] ?>">✏</a>

                                    <button class="delete-btn" data-id="<?= $item['id'] ?>" data-year="<?= $year ?>" data-type="results">🗑</button>
                                </li>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <li style="opacity:0.6;">Нет записей</li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>

        <?php endforeach; ?>
    </section>


    <!-- Глобальная дата последнего изменения -->
    <?php
    date_default_timezone_set("Asia/Almaty");

    $lastUpdate = null;

    foreach ($years as $year) {
        $metaFile = __DIR__ . "/uploads/results/$year/meta.json";
        if (!file_exists($metaFile)) continue;

        $entries = json_decode(file_get_contents($metaFile), true);

        foreach ($entries as $entry) {
            if (!empty($entry["date"])) {
                $timestamp = DateTime::createFromFormat("d.m.Y H:i", $entry["date"])->getTimestamp();
                if (!$lastUpdate || $timestamp > $lastUpdate) {
                    $lastUpdate = $timestamp;
                }
            }
        }
    }

    $lastUpdateFormatted = $lastUpdate
        ? date("d.m.Y H:i", $lastUpdate)
        : "Изменений пока нет";
    ?>

    <p id="last-updated-global" style="margin-top:20px; font-size:0.9em; color:#555;">
        Дата последних изменений: <strong><?= $lastUpdateFormatted ?></strong>
    </p>

</main>

<?php require_once __DIR__ . "/src/views/partials/footer.php"; ?>
