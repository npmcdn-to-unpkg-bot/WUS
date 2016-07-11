<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Mailchimp API Integration with PHP</title>
 
</head>
 
<body>	
	 
	<h1>Mailchimp API Integration with PHP </h1> 
	
	<div class="message"></div>
 
	<form  role="form" method="post" id="send">
	    
	    <button type="submit">Send Now !</button>
	    
	</form>
 
</body>
	<script   src="https://code.jquery.com/jquery-3.0.0.min.js"   integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="   crossorigin="anonymous"></script>
	<script type="text/javascript">
	
		$(document).ready(function() {
		    $('#send').submit(function() {
		        $(".message").html("<span style='color:orange;'>Sending ...</span>");

		            $.ajax({
		                url: '/application/web/send.php', 
		                type: 'POST',
		                success: function(msg) {
		                    if(msg=="success")
		                    {
		                        $(".message").html('<span style="color:green;">Sending ... Done</span>');
		                        
		                    }
		                    else
		                    {
		                      $(".message").html('Problem to send.');  
		                    }
		                }
		            });
		 
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