<?php
$user = $_POST['satu'].' '.$_POST['dua'];
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
// Alias the League Google OAuth2 provider class
use League\OAuth2\Client\Provider\Google;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

// use PHPMailer\PHPMailer\PHPMailer;

require "vendor/autoload.php";
require "config_api.php"; //load configuration API GMAIL

$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption mechanism to use - STARTTLS or SMTPS
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Set AuthType to use XOAUTH2
$mail->AuthType = 'XOAUTH2';

//Fill in authentication details here
//Either the gmail account owner, or the user that gave consent
$email = 'yuda7246@gmail.com';
$clientId = '619289407425-v3tsd074m831jonbo55h6fu8kvief180.apps.googleusercontent.com';
$clientSecret = 'nROBo90pu4DMz45nmTZQH0T_';

//Obtained by configuring and running get_oauth_token.php
//after setting up an app in Google Developer Console.
$refreshToken = '1//0gMmJNLLyPJkKCgYIARAAGBASNwF-L9IraYwMRR3uDzZcTiAshEtyspq_qDyfSCCnNNYU--gxLIqrbpMrYiC3XS7fMZwoHCyVBpw';

//Create a new OAuth2 provider instance
$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);

//Pass the OAuth provider instance to PHPMailer
$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $email,
        ]
    )
);

//Set who the message is to be sent from
//For gmail, this generally needs to be the same as the user you logged in as
$mail->setFrom($email, $user);

//Set who the message is to be sent to
$mail->addAddress($_POST['email'], ' ');

//Set the subject line
$mail->Subject = 'KUSUMA YUDA MUBAROK';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->CharSet = PHPMailer::CHARSET_UTF8;
// $mail->msgHTML($_POST['satu'], __DIR__).
// $mail->msgHTML($_POST['dua'], __DIR__).
// $mail->msgHTML($_POST['email'], __DIR__).
$mail->msgHTML($_POST['textarea'], __DIR__);
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
// if (!$mail->send()) {
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     echo 'Message sent!';
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Document</title>
    <style>
    body{
        background-color: rgb(214, 252, 252);
      }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-6">
            <?php
            if (!$mail->send()) : ?>
            <div class="alert alert-success text-light bg-dark" role="allert">
                <?php echo 'Mailer Error: ' . $mail->ErrorInfo; ?>
                    <?php echo "you failed to send data" ?>
            
                <?php else :?>
                <!-- echo 'Message sent!'; -->
                <div class="alert alert-success text-light bg-dark" role="allert">
                    <?php echo "Data has been sent" ?>
                </div>
                <?php endif ?>
                <div class="col-3">
        </div>
                <button><a href="send.html" class="text-dark">Back</a></button>
        </div>
        </div>
    </div>
</div>
    
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>