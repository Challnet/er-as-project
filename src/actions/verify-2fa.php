<?php
require_once __DIR__ . "/../helpers.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputCode = $_POST["code"] ?? "";

    if (!isset($_SESSION["2fa_code"]) || time() > $_SESSION["2fa_expires"]) {
        setValidationError("code", "Verification code expired. Please login again.");
        redirect("/");
        exit;
    }

    if ($inputCode != $_SESSION["2fa_code"]) {
        setValidationError("code", "Incorrect verification code.");
        redirect("/verify-2fa.php");
        exit;
    }

    $_SESSION["user"]["id"] = $_SESSION["2fa_user"];

    unset($_SESSION["2fa_code"], $_SESSION["2fa_expires"], $_SESSION["2fa_user"]);

    redirect("/home.php");
    exit;
} 
?>