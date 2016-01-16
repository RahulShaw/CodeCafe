<?php

function create_database($hostname, $username, $password, $database) {

	$h = $hostname;
	$u = $username;
	$p = $password;
	$d = $database;

	$conn = new mysqli($h, $u, $p, $d);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "CREATE TABLE users (
			id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(255) NOT NULL,
			lastname VARCHAR(255) NOT NULL,
			email VARCHAR(255) NOT NULL,
			password VARCHAR(255) NOT NULL,
			hash VARCHAR(255) NOT NULL,
			forgot_password_hash VARCHAR(255) NOT NULL,
			status ENUM('1', '0') NOT NULL
			);";

	if ($conn->multi_query($sql) === TRUE) {
    echo "Database Created Successfully! Please Delete The \"install\" Directory For Safety.";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	$conn->close();
}


?>