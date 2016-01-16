<?php

require_once 'connect.php';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    
            if(isset($_GET['email']) && !empty($_GET['email'])) {
                
                $email = htmlentities(mysqli_real_escape_string($connection, trim($_GET['email'])));
                
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    
                    $find_email_address_query = "SELECT * from users WHERE email = '{$email}'";
                    $do_find_email_address_query = mysqli_query($connection, $find_email_address_query);
                    
                    if($do_find_email_address_query) {
                        
                        
                        $count_email = mysqli_num_rows($do_find_email_address_query);
                        
                        if($count_email > 0) {
                            
                            $hash = bin2hex(openssl_random_pseudo_bytes(78));
                            
                            $forgot_password_hash_query = "UPDATE users SET forgot_password_hash = '{$hash}'
                            WHERE email = '{$email}'";
                            
                            $do_forgot_password_hash_query = mysqli_query($connection, $forgot_password_hash_query);
                            
                            if($do_forgot_password_hash_query) {
                                
                                $data = array("result" => 1, "message" => "Link To Reset Your Password Has Been Successfully Sent To $email");       
                                sendEmail($email, $hash);
                                
                                
                            }
                            else {
                                $data = array("result" => -5, "message" => "Error Encountered! Try Again Later.");
                            }
                            
                            
                        }
                        else {
                            $data = array("result" => -4, "message" => "Non-Existant Email Address! Perhaps You Need To Register For An Account.");
                        }
                        
                    }
                    else {
                        $data = array("result" => -3, "message" => "Encountered A Problem Resetting Your Password! Please Try Again Later.");
                    }
                    
                }
                else {
                    $data = array("result" => -2, "message" => "Invalid Email Address! yourname@example.com is an example of the correct format.");
                }
                
                
            }
            else {
                $data = array("result" => -1, "message" => "No Email Address Provided!");
            }
    }else {
        $data = array("result" => 0, "message" => "Incorrect Request Method!");   
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
            'secret' => '6Lf8CRITAAAAACe0qPldOfZEKijPJl9mKxPiHGiB',
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
    $subject = "Reset Your Password | www.codecafe.cf";
    $message = '
    
        Did you just forget your password ?
        No worries! It is just too easy to get a new one.
        Please click this link to reset your password.
        http://www.codecafe.cf/reset-password.php?hash='.$hash.'
         
        '; // Our message above including the link
                             
        $headers = 'From:noreply@codecafe.cf' . "\r\n";
        $header.= "MIME-Version: 1.0\r\n"; 
        $header.= "Content-Type: text/plain; charset=utf-8\r\n"; 
        $header.= "X-Priority: 1\r\n"; // Set from headers
        mail($to, $subject, $message, $headers); // Send our email
        
   
}  




mysqli_close($connection);
/* JSON Response */
header('Content-type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);


?>