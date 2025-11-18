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
    setMessage("error", "Account temporarily locked. Try again in $remaining minutes.");
    redirect("/");
    exit;
}

if (!isset($_SESSION["attempts"])) {
  $_SESSION["attempts"] = 0;
}


if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  setOldValue("email", $email);
  setValidationError("email", "Incorrect email format");
  setMessage("error", "Validation error");
  redirect("/");
}


// Identification
$user = findUser($email);

if (!$user) {
  $_SESSION["attempts"]++;

  setMessage("error", "User not found. Attempt #{$_SESSION['attempts']} of $maxAttempts.");

  if ($_SESSION["attempts"] >= $maxAttempts) {
    $_SESSION['lock_time'] = time();
    setMessage("error", "Too many failed attempts. Account locked for 5 minutes.");
  }
  
  redirect("/");
  exit();
}


// Authentification
if (!password_verify($password, $user["password"])) {
  $_SESSION['attempts']++;

  setMessage("error", "Password is incorrect");
  
  if ($_SESSION["attempts"] >= $maxAttempts) {
    $_SESSION['lock_time'] = time();
    setMessage("error", "Too many failed attempts. Account locked for 5 minutes.");
  }

  redirect("/");
  exit();
}

unset($_SESSION["attempts"]);
unset($_SESSION["lock_time"]);


// $_SESSION["user"]["id"] = $user["user_id"];
// 2fa Authentification
require_once __DIR__ . "/../mailer.php";

// После успешной проверки пароля
$code = random_int(100000, 999999);
$_SESSION["2fa_code"] = $code;
$_SESSION["2fa_user"] = $user["user_id"];
$_SESSION["2fa_expires"] = time() + 300;

if (!send2FACode($user["email"], $code)) {
    setMessage("error", "Unable to send verification email. Try again later.");
    redirect("/");
}

redirect("/verify-2fa.php");


// redirect("/home.php");