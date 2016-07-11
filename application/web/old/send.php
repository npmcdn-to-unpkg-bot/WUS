<?php
$api_key = "e5d1d4797a2c82813cc7cf1b1ca8e6b3-us13";
$campaign_id = "275941";
 
require('MailChimp.php');
$Mailchimp = new Mailchimp( $api_key );
$Mailchimp_Campaigns = new Mailchimp_Campaigns( $Mailchimp );

$subscriber = $Mailchimp_Campaigns->send( $campaign_id );
 
if ( ! empty( $subscriber['leid'] ) ) {
   echo "success";
}
else
{
    echo "fail";
}
 
?>