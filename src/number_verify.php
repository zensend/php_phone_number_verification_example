<?php
require 'config.inc';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $error = "";
  include("number_verify_form.inc");
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

  require "rand.inc";
  require 'vendor/autoload.php';

  $msisdn = $_POST["msisdn"];
  $token = strval(random_int(100000, 999999));

  $client = new ZenSend\Client(API_KEY);

  $request = new ZenSend\SmsRequest();
  $request->body = "Please enter " . $token . " to verify your mobile number";
  $request->originator = "VERIFY";
  $request->numbers = [$_POST["msisdn"]];

  try {
    $result = $client->send_sms($request);

  } catch (ZenSend\ZenSendException $e) {
    if ($e->parameter == "NUMBERS") {
      $error = "number";
    } else {
      $error = "generic";
    }

    include("number_verify_form.inc");
    return;
  } catch (ZenSend\NetworkException $e) {
    $error = "generic";
    include("choose_number_form.inc");
    return;
  }
  
  session_start();

  $_SESSION["msisdn_to_verify"] = $msisdn;
  $_SESSION["token"] = $token;
  $_SESSION["attempts"] = 0;

  header("Location: /token_verify.php");
  exit();
} else {
  http_response_code(405);
  exit();
}

?>
