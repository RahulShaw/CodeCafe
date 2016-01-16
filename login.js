$(document).ready(function() {

    // process the form
    $("#login-form").submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var formData = $("#login-form").serialize();
		

        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'login.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true
        })
            .done(function(data) {

                // log data to the console so we can see
				if(data != null ){
				  bootbox.alert(data.message);
				  console.log(data); 
				}else {
				  window.location = "/";
				}
                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });

});
