<?php
  require_once __DIR__ . "/src/helpers.php";

  checkGuest();
?>
<?php require_once __DIR__ . "/src/views/partials/head.php" ?>

    <form class="card" action="./src/actions/register.php" method="post" enctype="multipart/form-data">
      <h2>Sign Up</h2>

      <label for="name">
        Username
        <input
          type="text"
          id="username"
          name="username"
          placeholder="alexandr_kushnir"
          value="<?php echo getOldValue("username") ?>"
          <?php echo setValidationErrorAttribute("username") ?>
        />

        <?php if (hasValidationError("username")): ?>
          <small><?php echo getValidationErrorMessage("username") ?></small>
        <?php endif; ?>


      </label>

      <label for="email">
        E-mail
        <input
          type="text"
          id="email"
          name="email"
          placeholder="alexandrkushnir02@gmail.com"
          value="<?php echo getOldValue("email") ?>"
          <?php echo setValidationErrorAttribute("email") ?>
        />

        <?php if (hasValidationError("email")): ?>
          <small><?php echo getValidationErrorMessage("email") ?></small>
        <?php endif; ?>
        
      </label>

      <label for="avatar">
        Desired user avatar
        <input 
          type="file" 
          id="avatar" 
          name="avatar"
          <?php echo setValidationErrorAttribute("avatar") ?>
        />

        <?php if (hasValidationError("avatar")): ?>
          <small><?php echo getValidationErrorMessage("avatar") ?></small>
        <?php endif; ?>

      </label>

      <div class="grid">
        <label for="password">
          Password
          <input
            type="password"
            id="password"
            name="password"
            placeholder="******"
            <?php echo setValidationErrorAttribute("password") ?>
          />

        <?php if (hasValidationError("password")): ?>
          <small><?php echo getValidationErrorMessage("password") ?></small>
        <?php endif; ?>

        </label>

        <label for="password_confirmation">
          Password confirmation
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="******"
          />
        </label>
      </div>

      <fieldset>
        <label for="terms">
          <input type="checkbox" id="terms" name="terms" />
          I accept all the terms
        </label>
      </fieldset>

      <button type="submit" id="submit" disabled>Continue</button>
    </form>

    <p>I've already had an <a href="index.php">account</a></p>

<?php require_once __DIR__ . "/src/views/partials/footer.php" ?>
