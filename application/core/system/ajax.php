<?php
//we call this class at the beginning of any file called with Ajax
//this file include bdd connecion and adds security checks



class Ajax {

	public $ajaxConfig;
	public $env;
	public $config;
	public $connection;
	public $rootPath = "../../../../";
	//public $rootPath = dirname();

	public function __construct() {
        
        //load configuration
        $this->ajaxConfig = $this->getServerConfig();
        $this->env = $this->getServerConfig()->rss;
        $this->config  = $this->getServerConfig()->mysql;
        $this->connect();
        // $this->isAjax();
    }

	public function isAjax() {
		//to do ...
	}

	public function connect() {

		try {
			$this->connection = new PDO( 'mysql:host='.$this->config->host.
	                                    ';dbname='.$this->config->database, 
	                                    $this->config->username, 
	                                    $this->config->password, 
	                                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
	                                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	    }
	    catch(Exception $e) {
	    	error_log($e->getMessage());
	    	echo $e->getMessage();
		    

	    }
	}

	public function getServerConfig() {

		$ip_server = $_SERVER['SERVER_ADDR'];
        $domain = $_SERVER['HTTP_HOST'];

        $get_ip = gethostbyname($domain);

        if($get_ip == $ip_server) {

        	try {

				//$file = $this->rootPath."application/config/server/". $ip .".json";
				$file = dirname(dirname(dirname(dirname(__FILE__)))) . "/application/config/server/". $ip_server .".json";
				error_log("Filename : " . $file);

				$json = file_get_contents($file); 

				return (json_decode($json));
				
			} catch (Exception $e) {
				return "sub-domaine configuration error in Ajax.php file";
			}
        } else {

            if($get_ip != $domain) {
                try {

					//$file = $this->rootPath."application/config/server/". $ip .".json";
					$file = dirname(dirname(dirname(dirname(__FILE__)))) . "/application/config/server/". $get_ip .".json";
					error_log("Filename : " . $file);

					$json = file_get_contents($file); 

					return (json_decode($json));
					
				} catch (Exception $e) {
					return "sub-domaine configuration error in Ajax.php file";
				}
            } else {
                try {

					//$file = $this->rootPath."application/config/server/". $ip .".json";
					$file = dirname(dirname(dirname(dirname(__FILE__)))) . "/application/config/server/". $domain .".json";
					error_log("Filename : " . $file);

					$json = file_get_contents($file); 

					return (json_decode($json));
					
				} catch (Exception $e) {
					return "sub-domaine configuration error in Ajax.php file";
				}
            }
        }
    }

	public function getSubdomainFromUrl(){
        
        $httpHost = explode(".", $_SERVER['HTTP_HOST']); // Get Subdmain from URL
        return array_shift($httpHost);
    }

}

require_once 'template.php';
// require_once 'class.error.handler.php';

$ajax 	= new Ajax();
$config = $ajax->ajaxConfig;
$bdd 	= $ajax->connection;

$_TABLES = [];
$database = $ajax->config->database;

try
{
	$req = $bdd->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema = :database AND table_type = 'BASE TABLE'");
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

			$_TABLES["$prefix"]["$result"] = $value->table_name;

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

			$_TABLES["$prefix"]["$result"] = $value->table_name;

			//error_log('$_TABLES["' . $prefix . '"]["' . $result . '"] = ' . $value->table_name . "\n");
		}			
	}
}
else
{
	//error_log('TABLES ERROR');
}

?>