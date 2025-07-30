<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../PHPMailer/Exception.php';
require '../../../PHPMailer/PHPMailer.php';
require '../../../PHPMailer/SMTP.php';

include_once "../../../wp-load.php";

if ($_POST['email'] != "" && $_POST['business_airport_name'] != "" && $_POST['contact_person'] != "" && $_POST['phone'] != "" && $_POST['billing_address'] != ""&& $_POST['billing_city'] != ""&& $_POST['billing_state'] != ""&& $_POST['billing_zip'] != "" && $_POST['shipping_address'] != "" && $_POST['payment'] != "" && $_POST['returnshipping'] != "") {
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

    $subject = get_post_meta($_POST['id'], 'form_subject', true);
    if ($_POST['business_airport_name'] != "") $subject .= " [".$_POST['business_airport_name']."]";

    $mail->Subject = $subject;

    $mail->addBCC('foresitegroupllc@gmail.com');

    $Message = "Email: ".$_POST['email']."\n";
    $Message .= "Name: ".$_POST['business_airport_name']."\n";
    $Message .= "Contact: ".$_POST['contact_person']."\n";
    $Message .= "Telephone: ".$_POST['phone']."\n\n";

    $Message .= "Billing Address: ".$_POST['billing_address']."\n";
    $Message .= "Billing City: ".$_POST['billing_city']."\n";
    $Message .= "Billing State: ".$_POST['billing_state']."\n";
    $Message .= "Billing Zip: ".$_POST['billing_zip']."\n\n";
    
    $po_number = "";
    $Message .= "Payment: ";
    if ($_POST['payment'] != "") $Message .= $_POST['payment']."\n";
    if ($_POST['payment'] == "Purchase Order" && $_POST['po_number'] != "") {
      $Message .= "PO: ".$_POST['po_number']."\n";
      $po_number = $_POST['po_number'];
    }
    if ($_POST['payment'] == "Contact Name" && $_POST['po_name'] != "") {
      $Message .= "Payment Contact Name: ".$_POST['po_name']."\n";
      $po_number = $_POST['po_name'];
    }
    $Message .= "\n";

    $Message .= "Shipping Address: ".$_POST['shipping_address']."\n";
    if ($_POST['shipping_address_2'] != "") $Message .= "Shipping Address 2: ".$_POST['shipping_address_2']."\n";
    $Message .= "Shipping City: ".$_POST['shipping_city']."\n";
    $Message .= "Shipping State: ".$_POST['shipping_state']."\n";
    $Message .= "Shipping Zip: ".$_POST['shipping_zip']."\n\n";

    $Message .= "Shipping Method: ";
    if ($_POST['returnshipping'] != "") $Message .= $_POST['returnshipping']."\n";
    if ($_POST['returnshipping'] == "Customer UPS Account Number" && $_POST['rs_customer_ups'] != "") $Message .= "Customer UPS Account Number: ".$_POST['rs_customer_ups']."\n";

    $Message .= "\n";

    $units_additional = "\n";

    for($i = 0; $i < $_POST['units']; $i++) {
      $num = $i;
      $num++;

      $Message .= "Unit ".$num.": ";
      if ($_POST['serial_number'.$i] != "") $Message .= $_POST['serial_number'.$i]." ";

      $service = "";
      if (isset($_POST['service'.$i])) {
        $service = implode(", ", $_POST['service'.$i]);
        $Message .= "Service: ".$service;
      }

      $Message .= "\n";

      if ($_POST['description'.$i] != "") $units_additional .= "Unit ".$num." Description of Problem/Error/Malfunction: ".$_POST['description'.$i]."\n";
      if ($_POST['additional_info'.$i] != "") $units_additional .= "Unit ".$num." Additional Information/Requests: ".$_POST['additional_info'.$i]."\n";
    }

    $Message .= $units_additional."\n\n";

    $Message = stripslashes($Message);
    // echo "<pre>".$Message."</pre>";

    $mail->Body = $Message;
    
    // Create CSV attachment
    ob_start();
    $fp = fopen('php://output', 'w');

    fputcsv($fp, array(
      "Date Submitted",
      "Serial Number",
      "Business/Airport Name",
      "Contact Person",
      "Telephone",
      "Email",
      "Address Line 1",
      "Address Line 2",
      "City",
      "State",
      "Zip",
      "Requested Service",
      "Description of Problem/Error/Malfunction",
      "Additional Information/Requests",
      "Return Shipping",
      "Customer Account Number"
    ));

    $csvdate = date('n/j/y H:i', time());

    for($i = 0; $i < $_POST['units']; $i++) {
      $csvservice = "";
      if (isset($_POST['service'.$i])) $csvservice = implode(", ", $_POST['service'.$i]);

      fputcsv($fp, array(
        $csvdate,
        $_POST['serial_number'.$i],
        $_POST['business_airport_name'],
        $_POST['contact_person'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['shipping_address'],
        $_POST['shipping_address_2'],
        $_POST['shipping_city'],
        $_POST['shipping_state'],
        $_POST['shipping_zip'],
        $csvservice,
        $_POST['description'.$i],
        $_POST['additional_info'.$i],
        $_POST['returnshipping'],
        $_POST['rs_customer_ups']
      ));
    }

    fclose($fp);
    $csv_string = ob_get_contents();
    ob_end_clean();

    $mail->addStringAttachment($csv_string,"bowmonk_calibration_".date("Y-m-d_H-i",time()).".csv");
    
    $mail->send();

    // User confirmation mail
    $mail->clearAttachments();
    $mail->clearAllRecipients();
    $mail->addAddress($_POST['email']);

    $ToUser = "** THIS IS AN AUTOMATED MESSAGE. PLEASE DO NOT REPLY. **\n\n";
    $ToUser .= strip_tags(get_post_meta($_POST['id'], 'form_success', true));
    if ($_POST['payment'] == "Credit Card") $ToUser .= "\n\nPlease call our corporate office for credit card processing.\n1-800-525-8876";
    $ToUser .= "\n\nINFORMATION SUBMITTED\n";
    $ToUser .= $Message;

    $mail->Body = $ToUser;
    $mail->send();

    // Add info to local database
    global $wpdb;

    for($i = 0; $i < $_POST['units']; $i++) {
      $dbservice = "";
      if (isset($_POST['service'.$i])) $dbservice = implode(", ", $_POST['service'.$i]);

      $wpdb->insert('bowmonk_calibration',
        array(
          'email' => $_POST['email'],
          'business_airport_name' => $_POST['business_airport_name'],
          'contact_person' => $_POST['contact_person'],
          'phone' => $_POST['phone'],
          'billing_address' => $_POST['billing_address'],
          'billing_city' => $_POST['billing_city'],
          'billing_state' => $_POST['billing_state'],
          'billing_zip' => $_POST['billing_zip'],
          'shipping_address' => $_POST['shipping_address'],
          'shipping_address_2' => $_POST['shipping_address_2'],
          'shipping_city' => $_POST['shipping_city'],
          'shipping_state' => $_POST['shipping_state'],
          'shipping_zip' => $_POST['shipping_zip'],
          'serial_number' => $_POST['serial_number'.$i],
          'service' => $dbservice,
          'description' => $_POST['description'.$i],
          'additional_info' => $_POST['additional_info'.$i],
          'payment' => $_POST['payment'],
          'po_number' => $po_number,
          'returnshipping' => $_POST['returnshipping'],
          'rs_customer_ups' => $_POST['rs_customer_ups'],
          'date_submitted' => time()
        )
      );
    }

    $feedback = nl2br(get_post_meta($_POST['id'], 'form_success', true));
    if ($_POST['payment'] == "Credit Card") $feedback .= "<br><br>Please call our corporate office for credit card processing.<br>1-800-525-8876";
  // } else {
  //   $feedback = "Your message has triggered the spam filter and was not sent. If this an error, please contact us at 1-800-525-8876.";
  //} // Honeypot
} else {
  $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
} // Required fields

echo $feedback;
?>