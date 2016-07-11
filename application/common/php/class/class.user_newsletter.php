<?php

	require_once(dirname(dirname(__FILE__)) . "/tools/Mailchimp.php");

	/**
	* 
	*/
	class UserNewsletter {
		
		private $bdd;
		private $_TABLES;
		private $config;

		public function __construct($bdd, $_TABLES, $config) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;

			$this->config = $config;
		}

		// Custom

		public function getData($id) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['UserNewsletter'] . "
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->execute();
				$user = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($user) {
				return $user;
			}
			else {
				return null;
			}
		}

		public function getExist($email) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['UserNewsletter'] . "
						WHERE email = :email";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('email', $email, PDO::PARAM_STR);
				$req->execute();
				$user = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($user) {
				return $user;
			}
			else {
				return null;
			}
		}

		// General

		public function getAllUsersNewsletter() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['UserNewsletter'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$users = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($users) {
				return $users;
			}
			else {
				return null;
			}
		}

		public function deleteUserNewsletter($id, $email) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['UserNewsletter'] . "
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			$Mailchimp = new Mailchimp( $this->config->mailchimp->config->api_key );
			$Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
			$subscriber = $Mailchimp_Lists->unsubscribe( $this->config->mailchimp->list->lid , array( 'email' => $email ), true, true, true );
			 
			if ( ! empty( $subscriber['complete'] ) ) {
			   error_log("Unsubscribe Mailchimp success");
			}
			else
			{
			    error_log("Unsubscribe Mailchimp fail");
			}
			 
		}

		public function editUserNewsletter($id, $email) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['UserNewsletter'] . " 	
						SET email = :email
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('email', $email, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createUserNewsletter($email) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['UserNewsletter'] . " (email) VALUES (:email)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('email', $email, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			$Mailchimp = new Mailchimp( $this->config->mailchimp->config->api_key );
			$Mailchimp_Lists = new Mailchimp_Lists( $Mailchimp );
			$subscriber = $Mailchimp_Lists->subscribe( $this->config->mailchimp->list->lid , array( 'email' => $email ) );
			 
			if ( ! empty( $subscriber['leid'] ) ) {
			   error_log("Subscribe Mailchimp success");
			}
			else
			{
			    error_log("Subscribe Mailchimp fail");
			}
		}
	}
?>