<?php

/**
 * This is the main API 
 * @author Guitouni Hamza
 * @copyright ilopro.com
 */

class API { 

    public $error;
    public $request;
    public $query;
    public $result;
    public $mysql;
    public $bdd;
    public $config;
    public $_TABLES;


    public function __construct() {
        
        $this->init();
    }

    public function init() {

        //init error handler
        $this->error   = $this->getErrorCodes();
        
        //load configuration
        $this->config  = $this->getServerConfig();
        
        //data base connect
        $this->databaseConnect();

        //load all Models and releated controllers
        //$this->loadModels();
    }

    /**
     * Create a new Database connexion
     */
    public function databaseConnect(){
        
        $this->mysql = new Mysql();

        //set sql configuration
        $this->mysql->config = $this->config->mysql;
        //data base connect
        $connected = $this->mysql->connect();
        $this->bdd = $this->mysql->connexion;

        if($connected){

            error_log('Mysql Database OK');

            $this->getStructureBdd();

            error_log('$_TABLES : ' . json_encode($this->_TABLES));

            return true;
        } else {
            $this->printError(105); // connexion error
        }

        $this->printError(106); // Missing query type

    }

    /**
     * Send and run a query to the database
     * @return mysql obj or false
     */
    public function databaseQuery(){

        //run query
        $result = $this->mysql->query($this->query);
        
        if ($result){
            $this->result = $result;
        } else {
            $this->printError(110); // Invalid query
        }
    }


     /**
     * Return object Config of the API based on subdomain
     * @return object
     */
    

    public function getServerConfig(){

        $ip_server = $_SERVER['SERVER_ADDR'];
        $domain = $_SERVER['HTTP_HOST'];

        $get_ip = gethostbyname($domain);

        if($get_ip == $ip_server) {

            try {

                return $this->loadJsonFile("application/config/server/". $ip_server .".json");
                
            } catch (Exception $e) {
                $this->printError(103); // Invalid subdomain
            }
        } else {

            if($get_ip != $domain) {
                try {

                    return $this->loadJsonFile("application/config/server/". $get_ip .".json");
                    
                } catch (Exception $e) {
                    $this->printError(103); // Invalid subdomain
                }
            } else {
                try {

                    return $this->loadJsonFile("application/config/server/". $domain .".json");
                    
                } catch (Exception $e) {
                    $this->printError(103); // Invalid subdomain
                }
            }
        }       
    }

    /**
     * Show an error code
     * @param int code
     * @param string optional (text replacement)
     */
    public function printError($code, $optional="") {
        $this->config->application->log == "false" || error_log(strip_tags($_SERVER["REMOTE_ADDR"]) ." (".$_SERVER["REQUEST_URI"].") - API ERROR (".$code.") : " . $this->error->$code->type . " - " .sprintf($this->error->$code->detail, $optional)); // log if needed
        
        header('Content-type: application/json');
        
        $error = array("success" => "false", 
                        "code" => strval($code), 
                        "type" => $this->error->$code->type, "detail" => sprintf($this->error->$code->detail, $optional)
                        );

        !empty($_GET["output_format"]) || $_GET["output_format"] = "json";
        
        echo json_encode($error, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);

        die();
    }

    /**
     * Return the list of all error codes
     * @return object
     */
    public function getErrorCodes(){
        // Try to load error codes json config
        $json = file_get_contents("application/config/error/error.json");

        if ($json !== false) { // Valid Error code config file
            return json_decode($json);
        }else{ // Invalid User Config
            die("Invalid Error Code Config file !");
        }
    }

    /**
     * Includes all declared models and controllers in /application/config/src/model/model.json
     */
    public function loadModels() {
        
        //load enabled models list
        $modelRootFolder        = $this->loadJsonFile("application/config/src/model/models.json");

        //loop all models files
        foreach ($modelRootFolder->models as $model) {
            
            //include model
            require_once $model->path.$model->name.".php";

            //include controller
            require_once $model->controllerPath.$model->controller.".php";
        }    
    }

    /**
     * Return subdomain from URL
     * @return string
     */
    public function getSubdomainFromUrl(){
        
        $httpHost = explode(".", $_SERVER['HTTP_HOST']); // Get Subdmain from URL
        return array_shift($httpHost);
    }

    public function loadJsonFile($file) {

        // Try to load json config
        $json = file_get_contents($file); 

        if ($json !== false) { // if Valid Config

            $json = json_decode($json);

            return $json;
            
        } else { // Invalid Config
            
            $this->printError(102); // Unknown user
            //exit();
        }
    }

    public function getStructureBdd(){
        $this->_TABLES = [];
        $database = 'wus';

        try
        {
            $req = $this->bdd->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema = :database AND table_type = 'BASE TABLE'");
            $req->bindValue('database', $database, PDO::PARAM_STR);
            $req->execute();
            $tables = $req->fetchAll(PDO::FETCH_OBJ);
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            error_log('Erreur : ' . $e->getMessage());
            die('Erreur : ' . $e->getMessage());
        }

        if($tables != false)
        {
            //error_log('TABLES OK');

            foreach ($tables as $key => $value) 
            {
                //error_log('DB TABLE : ' . $value->table_name . "\n");

                $prefix = strtolower(explode('_', $value->table_name)[0]);
                $table = substr($value->table_name, strlen($prefix) + 1);

                //error_log('DB PREFIX TABLE : ' . $prefix . "\n");
                //error_log('DB EXPLODE TABLE : ' . $table . "\n");

                $array_table = explode("__", $table);

                //error_log('COUNT TABLE : ' . count($array_table) . "\n");

                if(count($array_table) < 2)
                {
                    $result = '';
                    $temp = $array_table[0];

                    foreach (explode('_', $temp) as $key2 => $value2) 
                    {
                        $result .= ucfirst(strtolower($value2));
                    }

                    $this->_TABLES["$prefix"]["$result"] = $value->table_name;

                    //error_log('$_TABLES["' . $prefix . '"]["' . $result . '"] = ' . $value->table_name . "\n");
                }
                else
                {
                    $result = '';

                    foreach ($array_table as $key2 => $value2) 
                    {
                        $temp = $value2;

                        foreach (explode('_', $temp) as $key3 => $value3) 
                        {
                            $result .= ucfirst(strtolower($value3));
                        }

                        if($key2 < count($array_table) - 1) $result .= '_';
                    }

                    $this->_TABLES["$prefix"]["$result"] = $value->table_name;

                    //error_log('$_TABLES["' . $prefix . '"]["' . $result . '"] = ' . $value->table_name . "\n");
                }           
            }
        }
        else
        {
            //error_log('TABLES ERROR');
        }
    }
}

?>