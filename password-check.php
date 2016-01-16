<?php

function checkToken($email, $token) {
  
	  require 'connect.php';
	  $email_address = $email;
	  $the_token = $token;
	  $check_token_query = "SELECT password FROM users WHERE email = '{$email_address}'";
	  $do_query = mysqli_query($connection, $check_token_query);
	  $password_row = $do_query->fetch_assoc();
	  $password_token = sha1($password_row['password']);
	  if($the_token === $password_token) {
		  return true;
	  }
	  else {
		  return false;
	  }
            
}   
                      
?>