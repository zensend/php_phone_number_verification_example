<?php

/* secure random numbers based on /dev/urandom. mt_rand,rand are unsafe for generating random tokens */

function random_bytes($n) {
  $fp = @fopen("/dev/urandom", "rb");
  if ($fp === FALSE) {
    throw new Exception('/dev/urandom not available (open)');
  }

  $bytes = @fread($fp, $n);

  if ($bytes === FALSE) {
    throw new Exception('/dev/urandom not available (read) ' . $n);
  }

  @fclose($fp);

  return $bytes;
}

function to_number($bytes) {
  $result = 0;
  for ($i = 0; $i < strlen($bytes); $i += 1) {
    $result = $result * 256 + ord($bytes[$i]);
  }

  return $result;
}

/* return number between 0 and $n - 1 inclusive */
function random_number($n) {
  if ($n == 1) {
    return 0;
  }

  if ($n < 1) {
    throw new Exception("bad limit");
  }

  $ceiling = 2;
  $bits = 1;
  while ($ceiling < $n) {
    $ceiling = $ceiling * 2;
    $bits = $bits + 1;
  }

  $nbytes = (int)(($bits + 7) / 8);
  while (true) {
    $bytes = random_bytes($nbytes);
    $candidate = to_number($bytes);

    $candidate = $candidate % $ceiling;    

    
    if ($candidate < $n) {
      return $candidate;
    }
  }
}

/* return random number between $low (inclusive) and $high (exclusive) */
function random_number_between($low, $high) {
  return $low + random_number($high - $low);
}

?>

