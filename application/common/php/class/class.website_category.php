<?php
	/**
	* 
	*/
	class WebsiteCategory {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getWebsiteCategories($website_id) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['WebsiteCategory'] . "
						WHERE website_id = :website_id
						ORDER BY category ASC";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('website_id', $website_id, PDO::PARAM_INT);
				$req->execute();
				$categories = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($categories) {
				return $categories;
			}
			else {
				return null;
			}
		}

		public function getAllWebsiteCategories() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['WebsiteCategory'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$categories = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($categories) {
				return $categories;
			}
			else {
				return null;
			}
		}

		public function deleteWebsiteCategory($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['WebsiteCategory'] . "
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

		public function editWebsiteCategory($id, $category_id, $website_id, $category, $url, $use_url, $url_pagination, $use_pagination) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['WebsiteCategory'] . " 	
						SET category_id = :category_id,
							website_id = :website_id, 
							category = :category,
							url = :url,
							use_url = :use_url,
							url_pagination = :url_pagination,
							use_pagination = :use_pagination
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('category_id', intval($category_id), PDO::PARAM_INT);
				$req->bindValue('website_id', intval($website_id), PDO::PARAM_INT);
				$req->bindValue('category', $category, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('use_url', $use_url, PDO::PARAM_BOOL);
				$req->bindValue('url_pagination', $url_pagination, PDO::PARAM_STR);
				$req->bindValue('use_pagination', $use_pagination, PDO::PARAM_BOOL);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createWebsiteCategory($category_id, $website_id, $category, $url, $use_url, $url_pagination, $use_pagination) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['WebsiteCategory'] . " (category_id, website_id, category, url, use_url, url_pagination, use_pagination) VALUES (:category_id, :website_id, :category, :url, :use_url, :url_pagination, :use_pagination)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('category_id', $category_id, PDO::PARAM_INT);
				$req->bindValue('website_id', $website_id, PDO::PARAM_INT);
				$req->bindValue('category', $category, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('use_url', $use_url, PDO::PARAM_BOOL);
				$req->bindValue('url_pagination', $url_pagination, PDO::PARAM_STR);
				$req->bindValue('use_pagination', $use_pagination, PDO::PARAM_BOOL);
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