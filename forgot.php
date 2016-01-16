<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
							<div class="col-xs-6" id="heading">
								<a href="#" class="active" id="login-form-link">Forgotten Your Password ?</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="password-help-form" action="forgot-password.php" method="get" role="form" style="display: block;">
								<p class="lead">We Will Fix It For You!</p>
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" required placeholder="Enter Your Registered Email Address" value="">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="reset-submit" id="reset-submit" tabindex="2" class="form-control btn btn-login" value="Reset My Password!">
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<!--<a href="index.php" tabindex="5" class="forgot-password">Wanna Log In ?</a>-->
												</div>
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
	<script src="js/bootbox.min.js"></script>
	
	
	<script type="text/javascript">
	  
	  $("#reset-submit").click(function(event) {
		
		event.preventDefault();
		
		if ($("#username").val() != "") {
		  $.get("forgot-password.php?email="+$("#username").val(), function (data){
			bootbox.dialog({
            message: data.message,
            title: "What's Up ?",
            buttons: {
                success: {
                    label: "Okay",
                    className: "btn-success", callback: function() {
					  if (data.message == "Non-Existant Email Address! Perhaps You Need To Register For An Account." || data.message === "Invalid Email Address! yourname@example.com is an example of the correct format.") {
						
						$("#username").val("");
					
					  }else if (data.message == "Link To Reset Your Password Has Been Successfully Sent To "+$("#username").val()) {
						
						var email = $("#username").val();
						var domain = email.replace(/.*@/, "");
						var address = "http://"+domain;
						bootbox.confirm("Do you want to go to " + domain , function(result){
						  
						  if (result === true) {
								
								$("#password-help-form")[0].reset();
								var redirectWindow = window.open(address, '_blank');
								redirectWindow.location;
								
							} else {
								$("#password-help-form")[0].reset();
								console.log("User declined dialog");
							}
						  
						})
						
						
					  }
					  
						
					}
                },
            }
        });
			console.log(data);
		  });
		}else {
		  bootbox.alert("Please enter your email address!");
		}
		
	  });

	</script>
  </body>
</html>