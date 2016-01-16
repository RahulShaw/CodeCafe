<?php

require 'create_db.php';

if(isset($_POST['hostname']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['database']) && !empty($_POST['hostname']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['database'])) {

		$server = trim($_POST['hostname']);
		$user = trim($_POST['username']);
		$password = trim($_POST['password']);
		$db = trim($_POST['database']);

		create_database($server, $user, $password, $db);

		$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/connect.php", "w") or die("Unable to open file!");
		$content = 
		'<?php

		    error_reporting(0);

			$connection = new mysqli("'.$server.'","'.$user.'","'.$password.'","'.$db.'");

			if($connection->connect_errno) {
		        
		        die("Sorry, we are having some problems!");
		        
		    }
		    

		?>';
		fwrite($file, $content);
		fclose($file);
	}
	else 
	{
		echo "All fields are mandatory!";
	}
?>