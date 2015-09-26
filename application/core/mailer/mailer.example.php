<?php

include("mailer/class.mailer.php");

$mailer = new Mailer();

$mailer->debug = true;

$mailer->to = "gregoire.sevin-allouet@ilopro.com";
$mailer->toName = "hamzawi";

// $mailer->cci("quentin.belot@ilopro.com") ;
// $mailer->cci("gregoire.sevin@yahoo.fr") ;


$mailer->content = "dernier test :)";

// $mailer->attach("tuto.pdf");

$mailer->confirmTo("hamza.guitouni@gmail.com");

//enable HTML containt
$mailer->isHTML();

$mailer->send();


?>