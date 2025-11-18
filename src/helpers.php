<?php

session_start();

require_once __DIR__ .  "/config.php";

function redirect(string $path) {
  header(header: "Location: " . BASE_URL . $path);
  die();
}

function setValidationError(string $fieldName, string $errorMessage) {
  $_SESSION["validation"][$fieldName] = $errorMessage;
}

function hasValidationError(string $fieldName): bool {
  return isset($_SESSION["validation"][$fieldName]);
}

function setValidationErrorAttribute(string $fieldName) {
  return isset($_SESSION["validation"][$fieldName]) ? "aria-invalid='true'" : "";
}

function getValidationErrorMessage(string $fieldName): string {
  $message =  $_SESSION["validation"][$fieldName] ?? "";
  unset($_SESSION["validation"][$fieldName]);
  return $message;
}

function setOldValue(string $key, mixed $value): void {
  $_SESSION["old"][$key] = $value;
}

function getOldValue(string $key) {
  $value = $_SESSION["old"][$key] ?? "";
  unset($_SESSION["old"][$key]);
  return $value;
}

function uploadFile(array $file, string $prefix): string {
  $uploadPath = __DIR__ . "/../uploads";

  if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0777, true);
  }

  $extention = pathinfo($file["name"], PATHINFO_EXTENSION);
  $fileName = $prefix . "_" . time() . ".$extention";

  if (!move_uploaded_file($file["tmp_name"], "$uploadPath/$fileName")) {
    die("Error during file uploading");
  }

  return "uploads/$fileName";
}

function setMessage(string $key, string $message): void {
  $_SESSION["message"][$key] = $message;
}

function hasMessage(string $key): bool {
  return isset($_SESSION["message"][$key]);
}

function getMessage(string $key): string {
  $message = $_SESSION["message"][$key] ?? "";
  unset($_SESSION["message"][$key]);
  return $message;
}

function getPDO(): PDO {
  try {
    return new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8;dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
  } catch(PDOException $error) {
    die("Connection error: " . $error->getMessage());
  }
}

function findUser(string $email): array|bool {
  $pdo = getPDO();

  $query = "SELECT * FROM users WHERE `email` = :email";
  $params = [
    "email" => $email
  ];

  $stmt = $pdo->prepare($query);
  $stmt->execute($params);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findCurrentUser(): array|bool {
  $pdo = getPDO();

  if (!isset($_SESSION["user"])) {
    return false;
  }

  $userId = $_SESSION["user"]["id"] ?? null;

  $query = "SELECT * FROM users WHERE `user_id` = :user_id";
  $params = [
    "user_id" => $userId
  ];

  $stmt = $pdo->prepare($query);
  $stmt->execute($params);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function logout() {
  unset($_SESSION["user"]["id"]);
  redirect("/");
}

function checkAuth() {
  if (!isset($_SESSION["user"]["id"])) {
    redirect("/");
  }
}

function checkGuest() {
  if (isset($_SESSION["user"]["id"])) {
    redirect("/home.php");
  }
}

// function send2FACode(string $email, int $code): void {
//   $subject = "Your 2FA Code";
//   $message = "Your verification code is: $code (valid for 5 minutes)";
//   $headers = "From: no-reply@auth-system.local";

//   mail($email, $subject, $message, $headers);
// }