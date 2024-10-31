<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../PHPMailer/Exception.php';
require '../../../PHPMailer/PHPMailer.php';
require '../../../PHPMailer/SMTP.php';

include_once "../../../wp-load.php";

if ($_POST['email'] != "" && $_POST['business_airport_name'] != "" && $_POST['contact_person'] != "" && $_POST['phone'] != "" && $_POST['billing_address'] != "" && $_POST['shipping_address'] != "" && $_POST['serial_number'] != "" && isset($_POST['service']) && $_POST['payment'] != "") {
  if ($_POST['username'] == "") {
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

    $Message = "Email: ".$_POST['email']."\n";
    $Message .= "Business/Airport Name: ".$_POST['business_airport_name']."\n";
    $Message .= "Contact Person: ".$_POST['contact_person']."\n";
    $Message .= "Daytime Contact Telephone Number: ".$_POST['phone']."\n\n";

    $Message .= "Billing Address\n".$_POST['billing_address']."\n\n";

    $Message .= "Shipping Address\n".$_POST['shipping_address']."\n\n";

    $Message .= "Serial Number of Unit: ".$_POST['serial_number']."\n\n";

    if (isset($_POST['service'])) {
      $service = implode(", ", $_POST['service']);
      $Message .= "Level of Service: ".$service."\n\n";
    }

    if ($_POST['description'] != "") $Message .= "Description of Problem/Error/ Malfunction\n".$_POST['description']."\n\n";

    if ($_POST['additional_info'] != "") $Message .= "Additional Information/Requests for this Unit\n".$_POST['additional_info']."\n\n";

    $Message .= "Payment Option: ";
    if ($_POST['payment'] == "po") $Message .= "Purchase Order\n";
    if ($_POST['payment'] == "cc") $Message .= "Credit Card\n";
    if ($_POST['payment'] == "po" && $_POST['po_number'] != "") $Message .= "Purchase Order Number: ".$_POST['po_number']."\n";

    $Message = stripslashes($Message);

    $mail->Body = $Message;
    $mail->send();

    $feedback = nl2br(get_post_meta($_POST['id'], 'form_success', true));
    if ($_POST['payment'] == "cc") $feedback .= "<br><br>Please call our corporate office for credit card processing.<br>1-800-525-8876";
  } // Honeypot
} else {
  $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
} // Required fields

echo $feedback;
?>