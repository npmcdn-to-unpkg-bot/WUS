<?php

	require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
  require(dirname(dirname(__FILE__)) . '/php/class/login.class.php');

  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];

      switch($action) {

          case 'login' : 
          { 
            $login = $_POST['login'];
            $pass = $_POST['pass'];

            echo login($login, $pass); 
            break; 
          }                  
      }
  }

  function login($login, $pass)
  {
    global $bdd;
    global $_TABLES;

    $content = "";

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
        if(isset($login) && !empty($login) && isset($pass) && !empty($pass)) {
          $objLogin = new Login($bdd, $_TABLES);
          $loggued = $objLogin->getLogin($login, $pass);
          return $loggued;
        }
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }
  }
?>