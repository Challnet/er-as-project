<?php
require_once __DIR__ . "/src/helpers.php";

checkAuth();

$user = findCurrentUser();
?>

<?php require_once __DIR__ . "/src/views/partials/head.php" ?>

<?php

$pageTitle = "Личный кабинет";
require_once __DIR__ . "/src/views/partials/hero.php"

?>

<main class="container home-page">

  <div class="card home">
    <img
      class="avatar"
      src="<?php echo "./" . $user["avatar"] ?>"
      alt="<?php echo $user["username"] ?>" />
    <span class="home__greeting">
      Добро пожаловать,
      <span class="home__greeting-username">
        <?php echo $user["username"] ?>
      </span>
      !
    </span>

    <!-- <?php if ($user["user_role_id"] === 3): ?>
      <button role="button">Administrate</button>
    <?php endif; ?> -->

    <form class="home__form" action="./src/actions/logout.php" method="post">
      <button class="button" role="button">Выйти из аккаунта</button>
    </form>
  </div>

  <?php
  if (!empty($_SESSION["validation"])) {
    echo "<pre>";
    print_r($_SESSION["validation"]);
    echo "</pre>";
  }
  ?>

</main>

<?php require_once __DIR__ . "/src/views/partials/footer.php" ?>