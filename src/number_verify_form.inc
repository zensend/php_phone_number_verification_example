<html>
  <head>
    <title>Verify Phone Number</title>
    <link rel="stylesheet" href="css/intlTelInput.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/intlTelInput.min.js"></script>

    <style type="text/css">
      #number_error { 
        display: none;
        color: red;
      }

      #generic_error {
        color: red;
      }


    </style>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#msisdn").intlTelInput({"utilsScript":"js/utils.js"});

        $("#verify_form").on("submit", function(e) {
          if (!$("#msisdn").intlTelInput("isValidNumber")) {
            e.preventDefault();
            $("#number_error").show();
            return;
          }

          $("#number_error").hide();
          $("#generic_error").hide();

          var number = $("#msisdn").intlTelInput("getNumber");

          $("#msisdn").val(number);
        });


      });
    </script>
  </head>
  <body>

    <p>Please enter your phone number and we will send you a token to verify it</p>
    <form method="POST" action="/number_verify.php" id="verify_form">
      <input id="msisdn" type="text" name="msisdn" />
      <input type="submit" value="Send Token"/>
      <div id="number_error" style="<?php echo $error == "number" ? 'display:block' : '';?>">Invalid Number</div>
      <?php 
        if ($error == "generic") {
      ?>
      <div id="generic_error">
      There was an error sending your token
      </div>
      <?php
        }
      ?>
    </form>


  </body>
</html>
