<?php

require_once 'connect.php';

session_start();

$type_json = true;

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    
    if(isset($_GET['hash']) && !empty($_GET['hash'])) {
    
        $hash = htmlentities(mysqli_real_escape_string($connection, trim($_GET['hash'])));
        
        $search_query = "SELECT hash, status FROM users WHERE forgot_password_hash = '{$hash}' AND status = '1'";
                   
        $do_search_query = mysqli_query($connection, $search_query);
        
        if($do_search_query) {
            
            $count_rows = mysqli_num_rows($do_search_query);
            
            if($count_rows > 0) {
                
                $_SESSION['hash'] = $hash;
                
                $type_json = false;
                
                //echo "<form method='post' action='do-reset.php'><input type='password' name='password'><br><input type='submit' value='Reset My Password'></form>";
                showForm();
                
            }
            else {
                $data = array("result" => -3, "message" => "Invalid URL or Perhaps The Password Has Already Been Reset Using This Link!");
            }
            
                   
        }
        else {
            $data = array("result" => -2, "message" => "Something Went Wrong! Try Again Later.");
        }
    }
    else
    {
        $data = array("result" => -1, "message" => "Certain Request Parameters Are Missing!");
    }

}
else {
    $data = array("result" => 0, "message" => "Incorrect Request Method!");   
}


mysqli_close($connection);
/* JSON Response */

if($type_json) {
    header('Content-type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
}

function showForm() {
    
    echo "<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
	<meta http-equiv=\”Pragma\” content=\”no-cache\”>
	<meta http-equiv=\”Expires\” content=\”-1\″>
	<meta http-equiv=\”CACHE-CONTROL\” content=\”NO-CACHE\”>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CodeCafe</title>

    <!-- Bootstrap -->
    <link href=\"css/bootstrap.css\" rel=\"stylesheet\">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
      <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->
	<link href=\"css/styles.css\" rel=\"stylesheet\">
	
  </head>
  
  <body>
	<div class=\"container\">
    	<div class=\"row\">
			<div class=\"col-md-6 col-md-offset-3\">
				<div class=\"panel panel-login\">
					<div class=\"panel-heading\">
						<div class=\"row\">
							<div class=\"col-xs-6\" id=\"heading\">
								<a href=\"#\" class=\"active\" id=\"login-form-link\">What's Your New Password ?</a>
							</div>
						</div>
						<hr>
					</div>
					<div class=\"panel-body\">
						<div class=\"row\">
							<div class=\"col-lg-12\">
								<form id=\"password-help-form\" action=\"do-reset.php\" method=\"post\" role=\"form\" style=\"display: block;\">
								<p class=\"lead\">We Will Reset Your Password!</p>
									<div class=\"form-group\">
										<input type=\"password\" name=\"password\" id=\"password\" tabindex=\"1\" class=\"form-control\" required placeholder=\"New Password\" value=\"\">
									</div>
                                    <div class=\"form-group\">
										<input type=\"password\" name=\"password-again\" id=\"password-again\" tabindex=\"1\" class=\"form-control\" required placeholder=\"Re-Enter Password\" value=\"\">
									</div>
									<div class=\"form-group\">
										<div class=\"row\">
											<div class=\"col-sm-6 col-sm-offset-3\">
												<input type=\"submit\" name=\"reset-submit\" id=\"reset-submit\" tabindex=\"2\" class=\"form-control btn btn-login\" value=\"Reset My Password!\">
											</div>
										</div>
									</div>
									<div class=\"form-group\">
										<div class=\"row\">
											<div class=\"col-lg-12\">
												<div class=\"text-center\">
													<!--<a href=\"#\" tabindex=\"5\" class=\"forgot-password\">Forgot Password?</a>-->
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
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
	<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src=\"js/bootstrap.min.js\"></script>
  </body>
</html>";
    
    
}
?>

