<?php

require_once __DIR__ . "/src/helpers.php";

checkGuest();
?>

<?php require_once __DIR__ . "/src/views/partials/head.php" ?>

<?php

$pageTitle = "Авторизация";
require_once __DIR__ . "/src/views/partials/hero.php"

?>

<main class="container auth-page">

  <form class="card" action="./src/actions/login.php" method="post">
    <h2 class="card__title">Вход в систему</h2>

    <?php if (hasMessage("error")): ?>
      <div class="notice error">
        <?php echo getMessage("error") ?>
      </div>
    <?php endif; ?>
    <!-- <div class="notice success">Какое-то сообщение</div> -->

    <label class="card__label" for="email">
      <span class="card__label-name">
        Email
      </span>
      <input
        class="card__input"
        type="email"
        id="email"
        name="email"
        placeholder="example@gmail.com"
        value="<?php echo getOldValue("email") ?>"
        <?php echo setValidationErrorAttribute("email") ?> />

      <?php if (hasValidationError("email")): ?>
        <small><?php echo getValidationErrorMessage("email") ?></small>
      <?php endif; ?>

    </label>

    <label class="card__label" for="password">
      <span class="card__label-name">
        Пароль
      </span>
      <input
        class="card__input"
        type="password"
        id="password"
        name="password"
        placeholder="******" />
    </label>

    <button class="button" type="submit" id="submit">Continue</button>
  </form>

  <p>У меня еще нет <a href="./register.php">аккаунта</a></p>

</main>

<?php require_once __DIR__ . "/src/views/partials/footer.php" ?>