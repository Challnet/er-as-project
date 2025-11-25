<?php
require_once __DIR__ . "/src/config.php";
require_once __DIR__ . "/src/helpers.php";

$year = $_GET["year"] ?? null;

if (!$year) {
  die("Ошибка: Год не указан");
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <title>Добавить запись — <?= htmlspecialchars($year) ?></title>
  <link rel="stylesheet" href="styles/main.css">
</head>

<body>

  <div class="container add-page">

    <h2>Добавить запись для <?= htmlspecialchars($year) ?> года</h2>

    <?php if (isset($_SESSION["message"])): ?>
      <div class="alert <?= key($_SESSION['message']) ?>">
        <?= reset($_SESSION["message"]) ?>
      </div>
      <?php unset($_SESSION["message"]); ?>
    <?php endif; ?>

    <form action="src/actions/save-entry.php" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="year" value="<?= $year ?>">

      <!-- Заголовок -->
      <label>Название:</label>
      <input type="text" name="title" required>

      <!-- Текстовое описание -->
      <label>Текст (опционально):</label>
      <textarea name="content" rows="6" placeholder="Введите текст объявления..."></textarea>

      <!-- Файл -->
      <label>Файл (необязательно):</label>
      <input type="file" name="file">

      <button type="submit">Сохранить</button>
    </form>

    <br>
    <a href="service.php">Назад</a>

  </div>
</body>

</html>
