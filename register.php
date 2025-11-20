<?php
require_once __DIR__ . "/src/helpers.php";

checkGuest();
?>

<?php require_once __DIR__ . "/src/views/partials/head.php" ?>

<?php

$pageTitle = "Регистрация";
require_once __DIR__ . "/src/views/partials/hero.php"

?>

<main class="container auth-page">


  <form class="card" action="./src/actions/register.php" method="post" enctype="multipart/form-data">
    <h2 class="card__title">Регистрация</h2>

    <label class="card__label" for="name">
      <span class="card__label-name">
        Имя пользователя
      </span>
      <input
        type="text"
        id="username"
        name="username"
        placeholder="alexandr_kushnir"
        value="<?php echo getOldValue("username") ?>"
        <?php echo setValidationErrorAttribute("username") ?> />

      <?php if (hasValidationError("username")): ?>
        <small><?php echo getValidationErrorMessage("username") ?></small>
      <?php endif; ?>


    </label>

    <label class="card__label" for="email">
      <span class="card__label-name">
        Email
      </span>
      <input
        type="text"
        id="email"
        name="email"
        placeholder="alexandrkushnir02@gmail.com"
        value="<?php echo getOldValue("email") ?>"
        <?php echo setValidationErrorAttribute("email") ?> />

      <?php if (hasValidationError("email")): ?>
        <small><?php echo getValidationErrorMessage("email") ?></small>
      <?php endif; ?>

    </label>

    <label for="avatar">Изображение профиля
      <input
        type="file"
        id="avatar"
        name="avatar"
        <?php echo setValidationErrorAttribute('avatar'); ?>>
      <?php if (hasValidationError('avatar')): ?>
        <small><?php echo getValidationErrorMessage('avatar'); ?></small>
      <?php endif; ?>
    </label>


    <div class="grid">
      <label class="card__label" for="password">
        <span class="card__label-name">
          Пароль
        </span>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="******"
          <?php echo setValidationErrorAttribute("password") ?> />

        <?php if (hasValidationError("password")): ?>
          <small><?php echo getValidationErrorMessage("password") ?></small>
        <?php endif; ?>

      </label>

      <label class="card__label" for="password_confirmation">
        <span class="card__label-name">
          Подтверждение пароля
        </span>
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          placeholder="******" />
      </label>
    </div>

    <!-- <fieldset>
      <label class="card__label" for="terms">
        <input type="checkbox" id="terms" name="terms" />
        I accept all the terms
      </label>
    </fieldset> -->

    <button class="button" type="submit" id="submit">Продолжить</button>
  </form>

  <p>У меня уже есть <a href="./login.php">аккаунт</a></p>

</main>

<?php require_once __DIR__ . "/src/views/partials/footer.php" ?>