<?php
$api_key = "e5d1d4797a2c82813cc7cf1b1ca8e6b3-us13";
$list_id = "5148a8524e";
 
require('MailChimp.php');
$Mailchimp = new Mailchimp( $api_key );
$Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );

$merge_vars = array('FNAME' => 'Zelel', 'LNAME' => 'Quentin');

$subscriber = $Mailchimp_Lists->subscribe( $list_id, array( 'email' => htmlentities($_POST['email']) ), $merge_vars, 'html', true, true, true, false );
 
if ( ! empty( $subscriber['leid'] ) ) {
   echo "success";
}
else
{
    echo "fail";
}
 
?>