
<?php require_once __DIR__ . "/src/views/partials/isUserLoggedIn.php"?>

<?php require_once __DIR__ . "/src/views/partials/head.php"?>

<? $pageTitle = "Результаты НИР";
require_once __DIR__ . "/src/views/partials/hero.php";

$years = ["2027", "2026", "2025"];
?>

<main class="container results-page">
    <div class="title-block">
        <h1>Результаты научно-исследовательских работ</h1>
    </div>

    <?php if (isset($_SESSION["message"])): ?>
        <div class="results-alert <?= key($_SESSION['message']) ?>">
            <?= reset($_SESSION["message"]) ?>
        </div>
        <?php unset($_SESSION["message"]); ?>
    <?php endif; ?>

       <?php if (!isset($_SESSION['user'])): ?>
        <div class="auth-warning">
            Чтобы добавлять или изменять данные — вы должны 
            <a href="login.php">авторизоваться</a>.
        </div>
    <?php endif; ?>

    <section class="results-years-list" data-js-years-list>
        <?php foreach ($years as $year): ?>

            <?php
            $dir = __DIR__ . "/uploads/results/$year/";
            $metaFile = $dir . "meta.json";

            $entries = file_exists($metaFile)
                ? json_decode(file_get_contents($metaFile), true)
                : [];
            ?>

            <div class="results-year-item" data-js-year-item>
                <button class="results-year-button" data-js-year-button>
                    <span><?= $year ?></span>
                    <i class="arrow" data-js-arrow></i>
                </button>

                <div class="results-year-content" data-js-year-content>

                    <!-- кнопка создания записи -->
                    <button class="results-add-btn add-result-btn" data-year="<?= $year ?>">➕ Добавить</button>

                    <ul class="results-entry-list">

                        <?php if (!empty($entries)): ?>
                            <?php foreach ($entries as $item): ?>
                                
                                <li class="results-entry-item"
                                    data-id="<?= $item['id'] ?>"
                                    data-year="<?= $year ?>"
                                >
                                    <a class="results-entry-link" href="view-result.php?year=<?= $year ?>&id=<?= $item['id'] ?>">
                                        <?= htmlspecialchars($item['title']) ?>
                                    </a>

                                    <button class="results-delete-btn delete-result-btn" 
                                            data-id="<?= $item['id'] ?>" 
                                            data-year="<?= $year ?>">
                                        🗑
                                    </button>
                                </li>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="results-empty">Нет записей</li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>

        <?php endforeach; ?>
    </section>

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

    <p class="results-last-update">
        Дата последних изменений: <strong><?= $lastUpdateFormatted ?></strong>
    </p>

    
</main>

<?php require_once __DIR__ . "/src/views/partials/footer.php"; ?>
