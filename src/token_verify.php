<?php
require 'config.inc';

function check_token($token) {
  if (!isset($_SESSION["msisdn_verification"])) {
    return "resend_token";
  }

  $details = $_SESSION["msisdn_verification"];
  if (round(microtime(true) * 1000) > $details["created_at"] + EXPIRATION_TIME) {
    return "resend_token";
  }


  if ($details["attempts"] >= MAX_VERIFY_ATTEMPTS) {
    return "max_attempts";
  }

  if (hash_equals($token, $details["token"])) { 
    $_SESSION["verified_msisdn"] = $details["msisdn"];
    unset($_SESSION["msisdn_verification"]);
    return TRUE;
  }

  $details["attempts"] = $details["attempts"] + 1;
  $_SESSION["msisdn_verification"] = $details;
  if ($details["attempts"] >= MAX_VERIFY_ATTEMPTS) {
    return "max_attempts";
  } else {
    return "invalid_token";
  }

}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $error = '';
  include("token_verify_form.inc");
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  require 'vendor/autoload.php'; 
  $token = $_POST["token"];

  session_start();
  $error = check_token($token);
  if ($error === TRUE) {
    header("Location: /success.php");
    exit();
  }
  include("token_verify_form.inc");
  
} else {
  http_response_code(405);
}

?>
