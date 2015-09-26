<?php

/**
 * Mysql connector
 * @author Guitouni Hamza
 * @copyright ilopro.com
 */

class Mysql {

    public $config;
    public $connexion;

    public function __construct(){
    }

    public function connect(){
        try {
            $this->connexion = new PDO('mysql:host='.$this->config->host.
                                        ';dbname='.$this->config->database, 
                                        $this->config->username, 
                                        $this->config->password, 
                                        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            return true;
        }
        catch(Exception $e) {
            return false;
        }
    }

    
    
    /**
     * Close Database connexion
     */
    public function close(){
        //$this->connexion->close();
    }

    

    /**
     * Send query to database
     * @param string $sql
     * @return mysql obj or false
     */
    public function query($sql){
        //to do later...
    }


}


?>