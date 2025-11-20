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
  setValidationError("username", "Username is empty");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  setValidationError("email", "Email is incorrect");
}

if (empty($password)) {
  setValidationError("password", "Password is empty");
}

if (!empty($password) && strlen($password) < 6) {
  setValidationError("password", "Password must have at least 6 characters");
}

if ($password !== $passwordConfirmation) {
  setValidationError("password", "Paswords are not matched");
}

if (!empty($avatar) && $avatar["error"] === 0) {
  $types = [
    "image/jpeg",
    "image/jpg",
    "image/png"
  ];

  if (!in_array($avatar["type"], $types)) {
    setValidationError("avatar", "Avatar image must be only jpeg, jpg or png types");
  }

  if (($avatar["size"] / 1000000) >= 1) {
    setValidationError("avatar", "Avatar image must be less than 1MB size");
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
