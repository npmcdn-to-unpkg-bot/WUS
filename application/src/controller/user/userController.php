<?php

/**
 * Login Controller
 * @author Guitouni Hamza
 * @copyright ilopro.com
 */

Class UserController extends Controller {

	public $user;

	public function __construct($user){

        //calls super class functions
        $this->init();
        $this->user     = $user; 
    }

    
    /**
     * login user
     */
    public function login () {

        //bd query
        $this->query = "SELECT
                            user.* 
                        FROM user
                        WHERE
                            TRIM(user.email) = \"". $this->user->email ."\"
                        					AND 
                        	TRIM(user.password) = \"". $this->user->password ."\"
                        	";
        //run query and get the result
        $this->databaseQuery();

        mysqli_num_rows($this->result) || $this->printError(201); // wrog email or password

        $data =  $this->result->fetch_assoc();

        //map the returned result to make an object user
        $this->user = $this->mapObject($this->user, $data);

        return;
    }



	
}
?>