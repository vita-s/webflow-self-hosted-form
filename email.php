<?php
include 'settings.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function json_response($code = 200, $message = null)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json; charset=utf-8');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
    );
    // ok, validation error, or failure
    header('Status: ' . $status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code < 300, // success or not?
        'message' => $message
    ));
}

// Sanitize input data
function sanitize($data) {
    $data = trim($data); // Remove whitespace
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_response(422);
    die;
}

// Get data from the FORM
$rows = [];

foreach ($_POST as $field => $value) {
    $field = sanitize($field);
    $value = sanitize($value);
    $rows[$field] = $value;
}

$message = [];
$message[] = '<table>';
$message[] = '<tbody>';
foreach ($rows as $label => $value) {
    $message[] = '<tr>';
    $message[] = "<th align=\"left\" style=\"padding: 8px;\">{$label}</th>";
    $message[] = "<td align=\"left\" style=\"padding: 8px;\">:</td>";
    $message[] = "<td align=\"left\" style=\"padding: 8px;\">{$value}</td>";
    $message[] = '</tr>';
}
$message[] = '</tbody>';
$message[] = '</table>';

$message = implode("", $message);

$subject = $email_predmet . " - " . $nazev_webu;


/* if (in_array('', [$name, $email]) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_response(422);
    die;
} */

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    //Server settings
    $mail->CharSet = "UTF-8";
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    //$mail->isSMTP();                                            //Send using SMTP
    $mail->isMail();                                            //Send not using SMTP
    //$mail->Host       = SMTP_HOST;                     //Set the SMTP server to send through
    //$mail->SMTPAuth   = SMTP_AUTH;                                   //Enable SMTP authentication
    //$mail->Username   = SMTP_USERNAME;                     //SMTP username
    //$mail->Password   = SMTP_PASSWORD;                               //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    //$mail->Port       = SMTP_PORT;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    //$mail->setFrom(SMTP_USERNAME, FROM_NAME);
    $mail->From = $email_odesilatele;
    $mail->FromName = $nazev_webu;
    $mail->addAddress($email_prijemce, $nazev_webu);     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo($email);
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = strip_tags($message);

    $mail->send();

    echo json_response(200);
} catch (Exception $e) {
    echo json_response(400, $mail->ErrorInfo);
}
die;