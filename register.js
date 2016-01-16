$(document).ready(function() {

    // process the form
    $("#register-form").submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = $("#register-form").serialize();
		

        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'create.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true
        })
            // using the done promise callback
            .done(function(data) {
			bootbox.dialog({
            message: data.message,
            title: "What's Up ?",
            buttons: {
                success: {
                    label: "Okay",
                    className: "btn-success", callback: function() {
					  if (data.message === "Email Address Already Exists!") {
						
						$("#email").val('');
    
					  }else if (data.message == $("#firstname").val()+" "+$("#lastname").val()+" has been successfully registered and a verification email has been sent to "+$("#email").val()+". Don't forget to check your JUNK or SPAM folder!") {
						var email = $("#email").val();
						var domain = email.replace(/.*@/, "");
						var address = "http://"+domain;
                        console.log(address);
                        bootbox.confirm("Do you want to go to " + domain , function(result){
						  
						  if (result === true) {
								
								$("#register-form")[0].reset();
								var redirectWindow = window.open(address, '_blank');
								redirectWindow.location;
								
							} else {
								$("#login-form")[0].reset();
								console.log("User declined dialog");
							}
						  
						})
                        
					  }
					  
						
					}
                },
            }
        });
                // log data to the console so we can see
                //console.log(data);
				
				
	
                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
		grecaptcha.reset();
    });

})
