<?php

  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];

      switch($action) {

          case 'logout' : 
          {
            logout(); 
            break; 
          }                  
      }
  }

  function logout()
  {
    session_start();
    unset($_SESSION['wus']['admin']);
  }
?>