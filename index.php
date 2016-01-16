<?php

$filename = 'connect.php';

if (file_exists($filename)) {
	require_once 'connect.php';
	require 'password-check.php';
	session_start();
	if((!isset($_SESSION['email'])) && !isset($_SESSION['okayToken']))
	{
	    header('Location: /credentials.php');
		exit;
	}

	if((time() - $_SESSION['loginTime']) > 1800) {
		header('Location: /logout.php');
		exit;
	}

	$email = $_SESSION['email'];
	$token = $_SESSION['okayToken'];

	if(checkToken($email, $token) == false)
	{
		header('Location: /logout.php');
		exit;
	}
}else {
	header('Location: install');
		exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv=”Pragma” content=”no-cache”>
	<meta http-equiv=”Expires” content=”-1″>
	<meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
	<title>Home | CodeCafe</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/styles.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
</head>
<body>

	 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">{ CodeCafe }</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
          </ul>
		  <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Logged in as <?php echo $_SESSION['email']; ?></a></li>
				<li><a href="logout.php">Log Out</a></li>
            </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
<div class="container">


	<div class="jumbotron">
		<h1 class="text-center"> Welcome </h1>
	</div>


	
</div> <!--Container-->




	
</body>
</html>