<?php

require_once 'connect.php';

session_start();

if(isset($_SESSION['hash']) &&
   !empty($_SESSION['hash']) &&
   isset($_POST['password']) &&
   !empty($_POST['password']) &&
   isset($_POST['password-again']) &&
   !empty($_POST['password-again'])
   ) {
    

    $hash = $_SESSION['hash'];
    $password = sha1(md5(htmlentities(mysqli_real_escape_string($connection, trim($_POST['password'])))));
    $password_again = sha1(md5(htmlentities(mysqli_real_escape_string($connection, trim($_POST['password-again'])))));
    
    if($password === $password_again) {
    
    $reset_password_query = "UPDATE users SET password = '$password' WHERE forgot_password_hash = '{$hash}'";
    
    $do_reset_password_query = mysqli_query($connection, $reset_password_query);
    
    if($do_reset_password_query) {
        
        
        $data = array("result" => 1, "message" => "Your Password Has Been Successfully Reset! You can now log-in.");
        
        $reset_hash_query = "UPDATE users SET forgot_password_hash = null WHERE forgot_password_hash = '{$hash}'";
        
        $do_reset_hash_query = mysqli_query($connection, $reset_hash_query);
        
        session_destroy();
        
    }
    else
    {
        $data = array("result" => -3, "message" => "Security Token Mismatch!");   
    }
    
}
else {
    $data = array("result" => -2, "message" => "Passwords Mismatch!"); 
}
}
else {
    $data = array("result" => -1, "message" => "Bad Request!");   
}




mysqli_close($connection);
/* JSON Response */
header('Content-type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);



?>