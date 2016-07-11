<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mailchimp API Integration with PHP</title>
 
</head>
 
<body>	
	 
	<h1>Mailchimp API Integration with PHP </h1> 
	
	<div class="message"></div>
 
	<form  role="form" method="post" id="subscribe">
	    
	    Email :<input type="email"  id="email" name="email" placeholder="Write your email" > <br>
	    <button type="submit">Subscribe Now !</button>
	    
	</form>
 
</body>
	<script   src="https://code.jquery.com/jquery-3.0.0.min.js"   integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="   crossorigin="anonymous"></script>
	<script type="text/javascript">
	
		$(document).ready(function() {
		    $('#subscribe').submit(function() {
		        if (!valid_email_address($("#email").val()))
		        {
		            $(".message").html('Please make sure you enter a valid email address.');
		        }
		        else
		        {
		            $(".message").html("<span style='color:orange;'>Almost done, please check your email address to confirmation.</span>");

		            $.ajax({
		                url: '/application/web/check.php', 
		                data: $('#subscribe').serialize(),
		                type: 'POST',
		                success: function(msg) {
		                    if(msg=="success")
		                    {
		                        $("#email").val("");
		                        $(".message").html('<span style="color:green;">You have successfully subscribed to our mailing list.</span>');
		                        
		                    }
		                    else
		                    {
		                      $(".message").html('Please make sure you enter a valid email address.');  
		                    }
		                }
		            });
		        }
		 
		        return false;
		    });
		});
 
		function valid_email_address(email)
		{
		    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
		    return pattern.test(email);
		}
	</script>
</html>