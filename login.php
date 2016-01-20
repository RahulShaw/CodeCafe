<?php

require_once 'connect.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        
        if(
           isset($_POST['email']) &&
           isset($_POST['password']) &&
           !empty($_POST['email']) &&
           !empty($_POST['password']))
        {
            
                // Get post data
                
                    $email = htmlentities(mysqli_real_escape_string($connection, trim($_POST['email'])));
                    $password = sha1(md5(htmlentities(mysqli_real_escape_string($connection, trim($_POST['password'])))));
                    //$status = 1; // Here we set by default status In-active.
                
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                    $email_query = "SELECT * FROM users WHERE email = '{$email}'";
                    $check_email = mysqli_query($connection, $email_query);
                    
                    if($check_email) {
                        
                        $email_count = mysqli_num_rows($check_email);
                        
                        if($email_count == 1) {
                            
                            $email_row = $check_email->fetch_assoc();
                            $email_address = $email_row['email'];
                            $activation_status = $email_row['status'];

                            if($activation_status == 1) {
                            
                                $password_query = "SELECT password FROM `users` WHERE email = '{$email_address}'";
                                $check_password_query = mysqli_query($connection, $password_query);
                                
                                $password_row = $check_password_query->fetch_assoc();
                                $password_from_database = $password_row['password'];
                                
                                if($password === $password_from_database) {
                                    
                                    $_SESSION['email'] = $email;
    								$_SESSION['okayToken'] = sha1($password_from_database);
                                    $_SESSION['loginTime'] = time();
                                    //header('Location: index.php');
                                    //$data = array("result" => 1, "message" => "Credintials Validated! You Will Be Redirected!");
                                    
                                }
                                else {
                                    $data = array("result" => -7, "message" => "Wrong Password!");
                                }
                            }
                            else
                            {
                                $data = array("result" => -8, "message" => "Account Has Not Been Activated!");
                            }
                            
                        }
                        else {
                                $data = array("result" => -6, "message" => "Email Address Is Not Registered!");
                        }
                    }
                    else {
                        $data = array("result" => -5, "message" => "Email Address Could Not Be Validated! Try again later.");
                    }
                        
                }
                else {
                    $data = array("result" => -4, "message" => "Invalid Email Address! yourname@example.com is an example of the correct format.");
                }
        }
        else {
                $data = array("result" => -3, "message" => "All Fields Are Mandatory!");
            }
        }
    else {
        $data = array("result" => -1, "message" => "Incorrect Request Method!");
    }
 
 
                       

mysqli_close($connection);
/* JSON Response */
header('Content-type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);



?>