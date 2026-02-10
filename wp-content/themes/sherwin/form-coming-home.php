<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../PHPMailer/Exception.php';
require '../../../PHPMailer/PHPMailer.php';
require '../../../PHPMailer/SMTP.php';

include_once "../../../wp-load.php";

if ($_POST['email'] != "" && $_POST['name'] != "") {
  // if ($_POST['username'] == "") {
    $mail = new PHPMailer();

    $mail->SMTPAuth = true;
    $mail->Username = get_theme_mod('fg_smtp_user');
    $mail->Password = get_theme_mod('fg_smtp_pass');
    $mail->Host = get_theme_mod('fg_smtp_host');
    $mail->Port = get_theme_mod('fg_smtp_port');

    $mail->setFrom(get_theme_mod('fg_smtp_user'), get_post_meta($_POST['id'], 'form_from_name', true));
    $mail->addReplyTo($_POST['email']);

    $emails = explode(PHP_EOL, get_post_meta($_POST['id'], 'form_send_to', true));
    foreach ($emails as $email) {
      $mail->addAddress($email);
    }

    $mail->Subject = get_post_meta($_POST['id'], 'form_subject', true);

    $mail->addBCC('foresitegroupllc@gmail.com');

    $Message = "";
    
    $Message .= "Name: ".$_POST['name']."\n";
    if ($_POST['company'] != "") $Message .= "Company/Organization: ".$_POST['company']."\n";
    $Message .= "Email: ".$_POST['email']."\n";
    if ($_POST['phone'] != "") $Message .= "Phone: ".$_POST['phone']."\n";

    $Message .= "\n";

    $Message .= "I work for/with: ".$_POST['workfor']."\n";

    if ($_POST['additional'] != "") $Message .= "\nAdditional Requests:\n".$_POST['additional']."\n";
    
    $Message = stripslashes($Message);
    // echo "<pre>".$Message."</pre>";

    $mail->Body = $Message;
    
    $mail->send();

    $wpdb->insert('coming_home',
      array(
        'name' => $_POST['name'],
        'company' => $_POST['company'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'additional' => $_POST['additional'],
        'date_submitted' => time()
      )
    );

    $feedback = nl2br(get_post_meta($_POST['id'], 'form_success', true));
  // } else {
  //   $feedback = "Your message has triggered the spam filter and was not sent. If this an error, please contact us at 1-800-525-8876.";
  //} // Honeypot
} else {
  $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
} // Required fields

echo $feedback;
?>