<?php

session_start();
if(isset($_SESSION['email']))
{
    header('Location: /index.php');
	exit;
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv=”Pragma” content=”no-cache”>
	<meta http-equiv=”Expires” content=”-1″>
	<meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CodeCafe</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link href="css/styles.css" rel="stylesheet">
	
  </head>
  
  <body>
	<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="login.php" method="post" role="form" style="display: block;">
								<p class="lead">Welcome Back!</p>
									<div class="form-group">
										<input type="text" name="email" id="useremail" tabindex="1" class="form-control" required placeholder="Email" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" required placeholder="Password">
									</div>
									
									<div class="form-group text-center">
										<input type="checkbox" tabindex="3" class="" name="remember" id="remember">
										<label for="remember"> Remember Me</label>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="forgot.php" tabindex="5" class="forgot-password">Forgot Password?</a>
												</div>
											</div>
										</div>
									</div>
								</form>
								<form id="register-form" action="create.php" method="post" role="form" style="display: none;">
								<p class="lead">Register And Get Rolling!</p>
									<div class="form-group">
										<input type="text" name="firstname" id="firstname" tabindex="1" class="form-control" placeholder="First Name" required value="">
									</div>
									<div class="form-group">
										<input type="text" name="lastname" id="lastname" tabindex="2" class="form-control" required placeholder="Last Name">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="3" class="form-control" required placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="4" class="form-control" required placeholder="Password">
									</div>
									<div class="form-group text-center">
										<div class="g-recaptcha" data-sitekey="6LdlhBQTAAAAAH7dke4mp_UidsUwpKMN5RuilM20"></div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="5" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="login.js"></script>
	<script src="register.js"></script>
	<script src="js/bootbox.min.js"></script>
	
	<script type="text/javascript">

		$(function() {

		    $('#login-form-link').click(function(e) {
				$("#register-form")[0].reset();
				$("#login-form")[0].reset();
		    	$('body').animate({ paddingTop: '100px' });
				$("#login-form").delay(100).fadeIn(100);
		 		$("#register-form").fadeOut(100);
				$('#register-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});
			$('#register-form-link').click(function(e) {
				$("#login-form")[0].reset();
				$("#register-form")[0].reset();
				$('body').animate({ paddingTop: '25px' });
				$("#register-form").delay(100).fadeIn(100);
		 		$("#login-form").fadeOut(100);
				$('#login-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});

	});

	</script>	
  </body>
</html>