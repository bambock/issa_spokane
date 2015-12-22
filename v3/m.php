<?php
header('Content-Type: application/json');
session_start();
class g_recaptcha {
    private $g_url = "https://www.google.com/recaptcha/api/siteverify";
    private $g_key = "6LdNtM4SAAAAAHm-M0QuR_2UZPHjDCtQemB4fAaA";
    
    public function verify_captcha($response) {
        
        $url = $this->g_url . "?secret=" . $this->g_key . "&response=" . $response;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
        $curlData = curl_exec($curl);
 
        curl_close($curl);
 
        $res = json_decode($curlData, TRUE);
        if($res['success'] == 'true') 
            return TRUE;
        else
            return FALSE;
    }
}

function loggr($k, $v) {
    error_log("debug: [$k] - $v".PHP_EOL, 3, "./my-errors.log");
}

if(isset($_POST)) {
    $errors = array();      // array to hold validation errors
    $data = array();        // array to pass back data 
    $response = $_POST['g-recaptcha-response'];
    if(!empty($response)) {
        $captcha = new g_recaptcha();
        $verified = $captcha->verify_captcha($response);
        if($verified) {
            // if any of these variables don't exist, add an error to our $errors array
            if (empty($_POST['name']))
                $errors['name'] = 'Name is required.';
        
            if (empty($_POST['email']))
                $errors['email'] = 'Email is required.';
        
            if (empty($_POST['subject']))
                $errors['subject'] = 'Subject is required.';
                
            if (empty($_POST['message']))
                $errors['email'] = 'Message is required.';
            
            // if there are any errors in our errors array, return a success boolean of false
            if (!empty($errors)) {
                $data['success'] = false;
                $data['message'] = "Form validation errors.";
                $data['errors']  = $errors;
            } else {
                $to = 'bambock@gmail.com';
                $subject = "Website Inquiry: " . $_POST['subject'];
                $message = "
                    <html>
                    <head>
                      <title>ISSA Inquiry</title>
                    </head>
                    <body>
                    <style>
                        .base {font: 80% tahoma; color: #000; padding:10px;}
                        .issa {font: bold 100% tahoma;}
                        .header {font-weight: bold; color: #999;}
                        h4.issa {font: bold 100% tahoma;}
                        td {padding: 5px;}
                        td.right { text-align: right; }
                    </style>
                    <h4 class=\"issa\">The following message has been posted:</h4>
                    <div class=\"base\">
                        <table>
                            <tr>
                              <td class=\"header right\">Name:</td>
                              <td>" . $_POST['name'] . "</td>
                            </tr>
                            <tr>
                              <td class=\"header right\">Email:</td>
                              <td>" . $_POST['email'] . "</td>
                            </tr>
                            <tr>
                              <td class=\"header right\">Subject:</td>
                              <td>" . $_POST['subject'] . "</td>
                            </tr>
                            <tr>
                              <td colspan=\"2\" class=\"header\">Message:</td>
                            </tr>
                            <tr><td colspan=\"2\">" . $_POST['message'] . "</td></tr>
                        </table>
                    </body>
                    </html>
                ";
                
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'To: ISSA Board Members<bambock@gmail.com>' . "\r\n";
                $headers .= 'From: ISSA Web Form <webops@issaspokane.org>' . "\r\n";
                $headers .= 'Bcc: bambock@gmail.com' . "\r\n";
                
                # mail($to, $subject, $message, $headers);   
                
                // show a message of success and provide a true success variable
                $data['success'] = true;
                $data['message'] = 'Message Sent!';
            }
        
        } else {
            $data['success'] = false;
            $data['message'] = 'Captcha verification failed.';
        }
    } else {
        $data['success'] = false;
        $data['message'] = 'No captcha provided.';
    }
    echo json_encode($data);    

} else {
	json_encode($_GET);
}
?>