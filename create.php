<?php

require_once 'connect.php';


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    if(captchaResponse($_POST['g-recaptcha-response']) == true) {
        
            if(isset($_POST['firstname']) &&
               isset($_POST['lastname']) &&
               isset($_POST['email']) &&
               isset($_POST['password'])
               && !empty($_POST['firstname']) &&
               !empty($_POST['lastname']) &&
               !empty($_POST['email']) &&
               !empty($_POST['password'])) {
            
                // Get post data
                $firstName = htmlentities(mysqli_real_escape_string($connection, trim($_POST['firstname'])));
                $lastName = htmlentities(mysqli_real_escape_string($connection, trim($_POST['lastname'])));
                $email = htmlentities(mysqli_real_escape_string($connection, trim($_POST['email'])));
                $password = sha1(md5(htmlentities(mysqli_real_escape_string($connection, trim($_POST['password'])))));
                $status = 0; // Here we set by default status In-active.
            
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
                $email_query = "SELECT * FROM users WHERE email = '{$email}'";
                $check_email = mysqli_query($connection, $email_query);
                
                if($check_email) {
                    
                    $email_count = mysqli_num_rows($check_email);
                    
                    if($email_count <= 0) {
                        
                        
                        $hash = bin2hex(openssl_random_pseudo_bytes(78));
                        // Save data into database       
                        $query = "INSERT INTO users (firstname,lastname,email,password,hash,status) VALUES ('{$firstName}',
                                    '{$lastName}','{$email}','{$password}','{$hash}','{$status}')";
                
                        $insert = mysqli_query($connection, $query);
            
                            if($insert){
                                $data = array("result" => 1, "message" => "$firstName $lastName has been successfully registered and a verification email has been sent to $email. Don't forget to check your JUNK or SPAM folder!");
                                
                                sendEmail($email, $hash);
                                
                                } else {
                                    $data = array("result" => 0, "message" => $connection->error);
                                }
                    
                            }
                            else {
                                    $data = array("result" => -6, "message" => "Email Address Already Exists!");
                            }
                    }
                    else {
                        $data = array("result" => -5, "message" => "Email Address Could Not Be Added! Try again later.");
                    }
                    
                }
                else {
                    $data = array("result" => -4, "message" => "Invalid Email Address! yourname@domain.com is an example
                                  of the correct format.");
                }
            }
            else {
                    $data = array("result" => -3, "message" => "All Fields Are Mandatory!");
                }
        } 
        else {
            $data = array("result" => -2, "message" => "Captcha Verification Failed!");
            }
    }
else {
    $data = array("result" => -1, "message" => "Incorrect Request Method!");
}
 
function captchaResponse ($captcha) {
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify",
        CURLOPT_POST => 1,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POSTFIELDS => [
            'secret' => '6LdlhBQTAAAAAB1eFSGx-H9J8uEMWBTfEC51zIR6',
            'response' => $captcha,
        ],     
    ]);
    
    $response = json_decode(curl_exec($curl));
    
    
    if($response->success){
        return true;
    }
    else {
        return false;
    }
    
}

function sendEmail ($recipient, $hash) {
    
  
    
    $to = $recipient;
    $subject = "Signup | Verification";
    $message = '
    
        Thanks for signing up!
        Please click this link to activate your account:
        http://www.codecafe.cf/verify/'.$hash.'
         
        '; // Our message above including the link
                             
        $headers = 'From:noreply@codecafe.cf' . "\r\n"; // Set from headers
        mail($to, $subject, $message, $headers); // Send our email
   
}  
                       

mysqli_close($connection);
/* JSON Response */
header('Content-type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);



?>