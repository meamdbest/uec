<?php
  set_include_path("../php/");
  require_once "Mail.php";

  $y = 0;

  $to = $captainEmail;
  $from = "Ultimate Easter Challenge <team@ultimateeasterchallenge.com>";
  $bcc = $from;
  $recipients = $to.", ".$bcc;
  $replyTo = "team@ultimateeasterchallenge.com";
  $subject = "Welcome to Ultimate Easter Challenge 2013!";
  
  $body = "Hooray!\r\r";
  $body .= "We've recieved your request to enter \"" . decode_input($teamName) . "\" into the Ultimate Easter Challenge!\r\r";
  $body .= "Just so you know, these are the details of the team you entered.\r\r";
  
  $body .= "Team name: " . decode_input($teamName) . "\r";
  $body .= "Team captain: " . decode_input($captainName) . "\r";
  $body .= "Team captain's email address: " . decode_input($captainEmail) . "\r";
  $body .= "Team captain's phone number: " . decode_input($captainNumber) . "\r\r";
  $body .= "Charity: " . decode_input($charity) . "\r\r";

  $body .= "Team members:\r";

  while ($y <= $memberCount){
    $body .= decode_input($memberNames[$y]) . "\r";
    $y ++;
  }

  $body .= "You'll get another email, once we've received your entry fee, confirming that you are entered into the competition.\r\r";
  $body .= "Thank you :o)\r\r";
  $body .= "The Ultimate Easter Challenge team.\r";

  $host = "mail.ultimateeasterchallenge.com";
  $port = "525";
  $username = "team@ultimateeasterchallenge.com";
  $password = "ultimat3";

  $headers = array (
    "From" => $from,
    "To" => $to,
    "Subject" => $subject,
    "Reply-To" => $replyTo,
    "Return-Path" => $replyTo,
    "Content-Type" => "text/plain; charset=iso-8859-1"
  );
  $smtp = Mail::factory(
    "smtp",
    array (
      "host" => $host,
      "port" => $port,
      "auth" => true,
      "username" => $username,
      "password" => $password
    )
  );

  $mail = $smtp->send($recipients, $headers, $body);

  if (PEAR::isError($mail)) {
    echo("<p>" . $mail->getMessage() . "</p>");
  } else {
    //echo("<p>Message successfully sent to ". $to ."!</p>");
  }
?>