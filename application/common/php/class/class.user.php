<?php
	/**
	* 
	*/
	class User {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		// Custom

		public function updatePassword($id, $password) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['User'] . " 	
						SET password = SHA1(:password)
						WHERE id = :id";

				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('password', $password, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function updateAccount($id, $email, $password, $first_name, $last_name, $birthday, $sex) {

			try 
			{
				if(empty($password)) {
					$sql = "UPDATE " . $this->_TABLES['public']['User'] . " 	
						SET email = :email,
						first_name = :first_name,
						last_name = :last_name,
						birthday = :birthday,
						sex = :sex
						WHERE id = :id";
				}
				else {
					$sql = "UPDATE " . $this->_TABLES['public']['User'] . " 	
						SET email = :email,
						password = SHA1(:password),
						first_name = :first_name,
						last_name = :last_name,
						birthday = :birthday,
						sex = :sex
						WHERE id = :id";
				}

				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('email', $email, PDO::PARAM_STR);

				if(!empty($password)) {
					$req->bindValue('password', $password, PDO::PARAM_STR);
				}

				$req->bindValue('first_name', $first_name, PDO::PARAM_STR);
				$req->bindValue('last_name', $last_name, PDO::PARAM_STR);
				$req->bindValue('birthday', $birthday, PDO::PARAM_STR);
				$req->bindValue('sex', $sex, PDO::PARAM_BOOL);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function getData($id) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['User'] . "
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
						FROM " . $this->_TABLES['public']['User'] . "
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

		public function getExistByProvider($name, $uid) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['User'] . "
						WHERE hybridauth_provider_name = :hybridauth_provider_name AND hybridauth_provider_uid = :hybridauth_provider_uid";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('hybridauth_provider_name', $name, PDO::PARAM_STR);
				$req->bindValue('hybridauth_provider_uid', $uid, PDO::PARAM_STR);
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

		public function fusionClassicAndProviderAccount($id, $email, $verified, $hybridauth_provider_name, $hybridauth_provider_uid) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['User'] . " 	
						SET email = :email,
						verified = :verified,
						hybridauth_provider_name = :hybridauth_provider_name,
						hybridauth_provider_uid = :hybridauth_provider_uid
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('email', $email, PDO::PARAM_STR);
				$req->bindValue('verified', $verified, PDO::PARAM_BOOL);
				$req->bindValue('hybridauth_provider_name', $hybridauth_provider_name, PDO::PARAM_STR);
				$req->bindValue('hybridauth_provider_uid', $hybridauth_provider_uid, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}	
		}

		// General

		public function getAllUsers() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['User'];
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

		public function deleteUser($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['User'] . "
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
		}

		public function editUser($id, $email, $password, $first_name, $last_name, $birthday, $sex, $created_at, $verification_key, $verified, $blocked, $hybridauth_provider_name, $hybridauth_provider_uid) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['User'] . " 	
						SET email = :email,
						password = SHA1(:password),
						first_name = :first_name,
						last_name = :last_name,
						birthday = :birthday,
						sex = :sex,
						created_at = :created_at,
						verification_key = SHA1(:verification_key),
						verified = :verified,
						blocked = :blocked,
						hybridauth_provider_name = :hybridauth_provider_name,
						hybridauth_provider_uid = :hybridauth_provider_uid
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('email', $email, PDO::PARAM_STR);
				$req->bindValue('password', $password, PDO::PARAM_STR);
				$req->bindValue('first_name', $first_name, PDO::PARAM_STR);
				$req->bindValue('last_name', $last_name, PDO::PARAM_STR);
				$req->bindValue('birthday', $birthday, PDO::PARAM_STR);
				$req->bindValue('sex', $sex, PDO::PARAM_BOOL);
				$req->bindValue('created_at', $created_at, PDO::PARAM_STR);
				$req->bindValue('verification_key', $verification_key, PDO::PARAM_STR);
				$req->bindValue('verified', $verified, PDO::PARAM_BOOL);
				$req->bindValue('blocked', $blocked, PDO::PARAM_BOOL);
				$req->bindValue('hybridauth_provider_name', $hybridauth_provider_name, PDO::PARAM_STR);
				$req->bindValue('hybridauth_provider_uid', $hybridauth_provider_uid, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createUser($email, $password, $first_name, $last_name, $birthday, $sex, $verification_key, $verified, $blocked, $hybridauth_provider_name, $hybridauth_provider_uid) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['User'] . " (email, password, first_name, last_name, birthday, sex, created_at, verification_key, verified, blocked, hybridauth_provider_name, hybridauth_provider_uid) 
				VALUES (:email, SHA1(:password), :first_name, :last_name, :birthday, :sex, NOW(), SHA1(:verification_key), :verified, :blocked, :hybridauth_provider_name, :hybridauth_provider_uid)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('email', $email, PDO::PARAM_STR);
				$req->bindValue('password', $password, PDO::PARAM_STR);
				$req->bindValue('first_name', $first_name, PDO::PARAM_STR);
				$req->bindValue('last_name', $last_name, PDO::PARAM_STR);
				$req->bindValue('birthday', $birthday, PDO::PARAM_STR);
				$req->bindValue('sex', $sex, PDO::PARAM_BOOL);
				$req->bindValue('verification_key', $verification_key, PDO::PARAM_STR);
				$req->bindValue('verified', $verified, PDO::PARAM_BOOL);
				$req->bindValue('blocked', $blocked, PDO::PARAM_BOOL);
				$req->bindValue('hybridauth_provider_name', $hybridauth_provider_name, PDO::PARAM_STR);
				$req->bindValue('hybridauth_provider_uid', $hybridauth_provider_uid, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}
	}
?>