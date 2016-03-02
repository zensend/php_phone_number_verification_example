<html>
  <head>
    <title>Verify Phone Number</title>
    <style type="text/css">
      .error {
        color: red;
      }
    </style>
  </head>


  <body>

    <p>Please enter the code sent to you to verify your phone number.</p>
    <form method="POST" action="/token_verify.php">
      <input type="text" name="token">
      <input type="submit" value="Verify">
    </form>

    <?php
      if ($error == "invalid_token") {
    ?>
      <div class="error">Invalid Token</div>
    <?php
      } else if ($error == "max_attempts") {
    ?>
      <div class="error">Max attempts reached. <a href="/number_verify.php">Resend Token</a></div>
    <?php
      } else if ($error == "resend_token") {
    ?>
      <div class="error">No token sent. <a href="/number_verify.php">Resend Token</a></div>
    <?php
      }
    ?>
  </body>

</html>