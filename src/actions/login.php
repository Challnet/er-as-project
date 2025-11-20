<?php

require_once __DIR__ . "/../helpers.php";

// unset($_SESSION["attempts"]);
// unset($_SESSION["lock_time"]);

$user = null;
$email = $_POST["email"] ?? null;
$password = $_POST["password"] ?? null;

$maxAttempts = 3;
$lockoutTime = 60 * 5;

if (isset($_SESSION["lock_time"]) && time() - $_SESSION["lock_time"] < $lockoutTime) {
  $remaining = ceil(($lockoutTime - (time() - $_SESSION["lock_time"])) / 60);
  setMessage("error", "Аккаунт временно заблокирован. Попробуйте еще через $remaining минут.");
  redirect("/login.php");
  exit;
}

if (!isset($_SESSION["attempts"])) {
  $_SESSION["attempts"] = 0;
}


if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  setOldValue("email", $email);
  setValidationError("email", "Неверный формат email");
  setMessage("error", "Ошибка валидации");
  redirect("/login.php");
}


// Identification
$user = findUser($email);

if (!$user) {
  $_SESSION["attempts"]++;

  setMessage("error", "Пользователь не найден. Попытка {$_SESSION['attempts']} из $maxAttempts.");

  if ($_SESSION["attempts"] >= $maxAttempts) {
    $_SESSION['lock_time'] = time();
    setMessage("error", "Слишком много использованных попыток. Аккаунт заблокирован на 5 минут.");
  }

  redirect("/login.php");
  exit();
}


// Authentification
if (!password_verify($password, $user["password"])) {
  $_SESSION['attempts']++;

  setMessage("error", "Пароль не верный. Попытка {$_SESSION['attempts']} из $maxAttempts.");

  if ($_SESSION["attempts"] >= $maxAttempts) {
    $_SESSION['lock_time'] = time();
    setMessage("error", "Лимит попыток для входа в аккаунт исчерпан. Аккаунт заблокирован на 5 минут.");
  }

  setOldValue("email", $email);

  redirect("/login.php");
  exit();
}

unset($_SESSION["attempts"]);
unset($_SESSION["lock_time"]);

$_SESSION['user']['id'] = $user["user_id"];

redirect("/home.php");
