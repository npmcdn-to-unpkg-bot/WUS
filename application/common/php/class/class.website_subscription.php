<?php
	/**
	* 
	*/
	class WebsiteSubscription {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		// Custom

		public function getAllWebsiteSubscriptionsByUser($user_id) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['WebsiteSubscription'] . " WHERE user_id = :user_id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('user_id', $user_id, PDO::PARAM_INT);
				$req->execute();
				$website_subscriptions = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($website_subscriptions) {
				return $website_subscriptions;
			}
			else {
				return null;
			}
		}

		public function deleteWebsiteSubscriptionByUserAndWebsite($user_id, $website_id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['WebsiteSubscription'] . "
						WHERE user_id = :user_id AND website_id = :website_id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('user_id', $user_id, PDO::PARAM_INT);
				$req->bindValue('website_id', $website_id, PDO::PARAM_INT);
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

		public function getAllWebsiteSubscriptions() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['WebsiteSubscription'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$website_subscriptions = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($website_subscriptions) {
				return $website_subscriptions;
			}
			else {
				return null;
			}
		}

		public function deleteWebsiteSubscription($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['WebsiteSubscription'] . "
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

		public function editWebsiteSubscription($id, $user_id, $website_id) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['WebsiteSubscription'] . " 	
						SET user_id = :user_id, website_id = :website_id
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('user_id', $user_id, PDO::PARAM_INT);
				$req->bindValue('website_id', $website_id, PDO::PARAM_INT);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createWebsiteSubscription($user_id, $website_id) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['WebsiteSubscription'] . " (user_id, website_id) VALUES (:user_id, :website_id)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('user_id', $user_id, PDO::PARAM_INT);
				$req->bindValue('website_id', $website_id, PDO::PARAM_INT);
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