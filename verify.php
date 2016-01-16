<?php

include 'connect.php';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if(isset($_GET['key']) && !empty($_GET['key'])) {
        
        
        $hash = htmlentities(mysqli_real_escape_string($connection, trim($_GET['key'])));
        
        $search_query = "SELECT hash, status FROM users WHERE hash = '{$hash}' AND
                   status = '0'";
                   
        $do_search_query = mysqli_query($connection, $search_query);
        
        if($do_search_query) {
            
            $count_rows = mysqli_num_rows($do_search_query);
            
            if($count_rows > 0) {
                
                $activation_query = "UPDATE users SET status='1' WHERE hash = '{$hash}'";
                
                $do_activation_query = mysqli_query($connection, $activation_query);
                
                if($do_activation_query) {
                    
                    $data = array("result" => 1, "message" => "Account Activated Successfully! You can now log-in.");
                    $reset_hash_query = "UPDATE users SET hash = null WHERE hash = '{$hash}'";
                    $execute_reset_hash_query = mysqli_query($connection, $reset_hash_query);
                    
                }
                else {
                    $data = array("result" => -4, "message" => "Unable To Activate Account At This Moment!
                                  Try Again Later.");
                }
                
                
            }
            else {
                $data = array("result" => -3, "message" => "Invalid URL or The Account Has Already Been Activated!");
            }
            
                   
        }
        else {
            $data = array("result" => -2, "message" => "Something Went Wrong! Try Again Later.");
        }
         
    }
    else {
        $data = array("result" => -1, "message" => "Certain Verification Parameters Are Missing!");
    }    
}   
else {
    $data = array("result" => 0, "message" => "Incorrect Request Method!");   
}

mysqli_close($connection);
/* JSON Response */
header('Content-type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);








?>