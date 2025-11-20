<?php

require_once __DIR__ . "/../helpers.php";

$avatarPath = null;

// unset($_SESSION["validation"]);

$username = $_POST["username"]  ?? null;
$email = $_POST["email"]  ?? null;
$password = $_POST["password"]  ?? null;
$passwordConfirmation = $_POST["password_confirmation"]  ?? null;
$avatar = $_FILES["avatar"]  ?? null;

//Validation
if (empty($username)) {
  setValidationError("username", "Пустое поле");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  setValidationError("email", "Не верный формат email");
}

if (empty($password)) {
  setValidationError("password", "Пароль пустой");
}

if (!empty($password) && strlen($password) < 6) {
  setValidationError("password", "Пароль > 6 символов");
}

if ($password !== $passwordConfirmation) {
  setValidationError("password", "Пароли не совпадают");
}

if (!empty($avatar) && $avatar["error"] === 0) {
  $types = [
    "image/jpeg",
    "image/jpg",
    "image/png"
  ];

  if (!in_array($avatar["type"], $types)) {
    setValidationError("avatar", "Аватарка должна быть jpeg, jpg или png форматов");
  }

  if (($avatar["size"] / 1000000) >= 1) {
    setValidationError("avatar", "Аватарка должна весить не более 1MB");
  }
}

if (!empty($_SESSION["validation"])) {
  setOldValue("username", $username);
  setOldValue("email", $email);

  // echo "<pre>";
  //   print_r($avatar);
  // echo "</pre>";


  if (!empty($_SESSION["validation"])) {
    echo "<pre>";
    print_r($_SESSION["validation"]);
    echo "</pre>";
  }

  redirect("/register.php");
}

// Avatar image uploading
if (!empty($avatar) && $avatar["error"] === 0) {
  $avatarPath = uploadFile($avatar, "avatar");
}

// PDO
$pdo = getPDO();

$query = "INSERT INTO users (username, email, avatar, password) VALUES (:username, :email, :avatar, :password)";
$params = [
  "username" => $username,
  "email" => $email,
  "avatar" => $avatarPath,
  "password" => password_hash($password, PASSWORD_DEFAULT)
];

$stmt = $pdo->prepare($query);

try {
  $stmt->execute($params);
} catch (Exception $error) {
  die("DB error: " . $error->getMessage());
}

// Redirect to Sign In page
redirect("/login.php");
