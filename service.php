<?php require_once __DIR__ . "/src/views/partials/isUserLoggedIn.php" ?>
<?php require_once __DIR__ . "/src/views/partials/head.php" ?>


<?php $pageTitle = "Закупка товаров, работ, услуг";
require_once __DIR__ . "/src/views/partials/hero.php";

$years = ["2027", "2026", "2025"];
?>

<main class="container">
    <div class="title-block">
        <h1>
            Закупки товаров, работ, услуг для проведения научных исследований,
            осуществляемых из средств грантового и программно-целевого финансирования
        </h1>
    </div>

    <?php if (!(isset($_SESSION['user']['id'])) || !($user["user_role_id"] === 3)): ?>
        <div class="auth-warning">
            Чтобы добавлять или изменять данные — вы должны
            <a href="login.php">авторизоваться</a>
            и являться администратором
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION["message"])): ?>
        <div class="alert <?= key($_SESSION['message']) ?>">
            <?= reset($_SESSION["message"]) ?>
        </div>
        <?php unset($_SESSION["message"]); ?>
    <?php endif; ?>


    <section class="years-list" data-js-years-list>
        <?php foreach ($years as $year): ?>
            <?php
            $dir = __DIR__ . "/uploads/$year/";
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

                    <!-- Кнопка добавления -->
                    <?php if ((isset($_SESSION['user']['id'])) && ($user["user_role_id"] === 3)): ?>
                        <button class="add-entry-btn" data-year="<?= $year ?>">➕ Добавить</button>
                    <?php endif; ?>

                    <ul class="entry-list">
                        <?php if (!empty($entries)): ?>
                            <?php foreach ($entries as $item): ?>

                                <li class="entry-item"
                                    data-id="<?= $item['id'] ?>"
                                    data-year="<?= $year ?>">

                                    <!-- Название кликабельно -->
                                    <a href="view.php?year=<?= $year ?>&id=<?= $item['id'] ?>" class="entry-link">
                                        <?= htmlspecialchars($item['title']) ?>
                                    </a>

                                    <?php if ((isset($_SESSION['user']['id'])) && ($user["user_role_id"] === 3)): ?>
                                        <button class="delete-btn" data-id="<?= $item['id'] ?>" data-year="<?= $year ?>">
                                            🗑
                                        </button>
                                    <?php endif; ?>
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


    <!-- === Глобальная дата последнего изменения === -->
    <?php
    date_default_timezone_set("Asia/Almaty"); // Казахстан (ВКО)

    $lastUpdate = null;

    foreach ($years as $year) {
        $metaFile = __DIR__ . "/uploads/$year/meta.json";
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
        Дата последних изменений: <span id="last-updated-date"><?= $lastUpdateFormatted ?></span>
    </p>

</main>

<?php require_once __DIR__ . "/src/views/partials/footer.php"; ?>