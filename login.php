<?php
 
  require_once __DIR__ . "/src/helpers.php";

  checkGuest();
?>
<?php require_once __DIR__ . "/src/views/partials/head.php" ?>

    <form class="card" action="./src/actions/login.php" method="post">
      <h2>Sign In</h2>

      <?php if(hasMessage("error")): ?>
        <div class="notice error">
          <?php echo getMessage("error") ?>
        </div>
      <?php endif; ?>
      <!-- <div class="notice success">Какое-то сообщение</div> -->

      <label for="username">
        Email
        <input
          type="email"
          id="email"
          name="email"
          placeholder="alexandrkushnir02@gmail.coms"
          value="<?php echo getOldValue("email") ?>"
          <?php echo setValidationErrorAttribute("email") ?>
        />

        <?php if (hasValidationError("email")): ?>
          <small><?php echo getValidationErrorMessage("email") ?></small>
        <?php endif; ?>

      </label>

      <label for="password">
        Password
        <input
          type="password"
          id="password"
          name="password"
          placeholder="******"
        />
      </label>

      <button type="submit" id="submit">Continue</button>
    </form>

    <p>I havent't had an <a href="./register.php">account</a> yet</p>

<?php require_once __DIR__ . "/src/views/partials/footer.php" ?>