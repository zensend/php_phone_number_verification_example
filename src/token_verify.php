<?php
require 'config.inc';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $error = '';
  include("token_verify_form.inc");
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
  require 'vendor/autoload.php'; 
  $token = $_POST["token"];

  session_start();


  if (isset($_SESSION["token"])) {
    if ($_SESSION["attempts"] < MAX_VERIFY_ATTEMPTS) {

      if (hash_equals($token, $_SESSION["token"])) {
        $_SESSION["verified_msisdn"] = $_SESSION["msisdn_to_verify"];
        unset($_SESSION["msisdn"]);
        unset($_SESSION["token"]);
        unset($_SESSION["attempts"]);
        header("Location: /success.php");
      } else {
        $_SESSION["attempts"] = $_SESSION["attempts"] + 1;
        if ($_SESSION["attempts"] >= MAX_VERIFY_ATTEMPTS) {
          $error = "max_attempts";
        } else {
          $error = "invalid_token";
        }
      }
    } else {
      $error = "max_attempts";
    }
  } else {
    $error = "resend_token";
  }

  include("token_verify_form.inc");
  
} else {
  http_response_code(405);
}

?>