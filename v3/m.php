<?php
if($_POST){
$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate the variables ======================================================
    // if any of these variables don't exist, add an error to our $errors array

    if (empty($_POST['name']))
        $errors['name'] = 'Name is required.';

    if (empty($_POST['message']))
        $errors['email'] = 'Email is required.';

    if (empty($_POST['subject']))
        $errors['subject'] = 'Superhero alias is required.';

// return a response ===========================================================

    // if there are any errors in our errors array, return a success boolean of false
    if ( ! empty($errors)) {

        // if there are items in our errors array, return those errors
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {

        // if there are no errors process our form, then return a message

        // DO ALL YOUR FORM PROCESSING HERE
        // THIS CAN BE WHATEVER YOU WANT TO DO (LOGIN, SAVE, UPDATE, WHATEVER)

        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Success!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);    
    // file_put_contents("outputfile.txt", var_dump($_POST);
    
/*	$to      = 'bambock@gmail.com';
	$subject = $_POST['subject'];
	$message = $_POST['name'] . "\r\n" . $_POST['message'];
	$headers = $_POST['email'] . "\r\n" .
    	'Reply-To:' . $_POST['email'] . "\r\n" .
    	'X-Mailer: PHP/' . phpversion();
    	// multiple recipients
*/

// recipient
$to = 'bambock@gmail.com';

// subject
$subject = "Website Inquiry: " . $_POST['subject'];

// message

$message = "
<html>
<head>
  <title>ISSA Inquiry</title>
</head>
<body>
  <p>We received this message:</p>
  <h5>Name</h5>
  <div>" . $_POST['name']. "</div>
  <h5>Email</h5>
    <div>" . $_POST['email']. "</div>
  <h5>Message</h5>
    <div>" . $_POST['message']. "</div>
</body>
</html>
";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: ISSA Board Members<bambock@stcu.org>' . "\r\n";
$headers .= 'From: ISSA Web Form <info@issaspokane.org>' . "\r\n";
$headers .= 'Bcc: bambock@gmail.com' . "\r\n";

mail($to, $subject, $message, $headers);   
    
} else {
	echo "hello no POST world\n\n";
	var_dump($_GET);
}
?>