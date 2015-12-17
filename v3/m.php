<?php
class g_recaptcha {
    private $g_url = "https://www.google.com/recaptcha/api/siteverify";
    private $g_key = "6LdNtM4SAAAAAPlnkIWtAKXpcHemuPB3W6jTTMs8";
    
    public function verify_captcha($response) {
        $url = $this->g_url . "?secret=" . $this->g_key . "&response=" . $response;
 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, TRUE); 
        $curlData = curl_exec($curl);
 
        curl_close($curl);
 
        $res = json_decode($curlData, TRUE);
        if($res['success'] == 'true') 
            return TRUE;
        else
            return FALSE;
    }
}

if($_POST){
    $response = $_POST['g-captcha-response'];
    if(!empty($response)) {
        $captcha = new g_recaptcha();
        $verified = $captcha->verify_captcha($response);
        if($verified) {
            
        } else {
            
        }
    }
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
    
    if (empty($_POST['g-recaptcha-response']))
        $errors['g-recaptcha-response'] = 'recaptcha must be set.';

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
          <h5>Goog</h5>
            <div>" . $_POST['g-recaptcha-response'] . " : " . $_POST['response'] . " : " . $_POST['remoteip'] . "</div>
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


        // show a message of success and provide a true success variable
        $data['success'] = true;
        $data['message'] = 'Message Sent!';
    }

    // return all our data to an AJAX call
    echo json_encode($data);    
    // file_put_contents("outputfile.txt", var_dump($_POST);


    
} else {
	echo "hello no POST world\n\n";
	var_dump($_GET);
}
?>