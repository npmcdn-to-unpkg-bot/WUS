<?php
	/**
	* 
	*/
	class Article {
		
		private $bdd;
		private $_TABLES;
		private $type_item_article = 'article';

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getArticles() {

			try 
			{
				$sql = "SELECT I.*, W.website, W.logo
						FROM " . $this->_TABLES['public']['Website'] . " W
						LEFT JOIN " . $this->_TABLES['public']['Category'] . " C
						ON W.id = C.website_id
						LEFT JOIN " . $this->_TABLES['public']['Item'] . " I
						ON C.id = I.category_id
						LEFT JOIN " . $this->_TABLES['public']['TypeItem'] . " TI
						ON I.type_item_id = TI.id
						WHERE TI.type = :type
						ORDER BY date_publication DESC";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('type', $this->type_item_article, PDO::PARAM_STR);
				$req->execute();
				$articles = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($articles) {
				return $articles;
			}
			else {
				return null;
			}
		}

		public function setArticle($data) {

			$temp = json_decode($data, true);

			$type_item_id = null;
			$category_id = $temp['category_id'];
			$guid = $temp['guid'];
			$url = $temp['url'];
			$title = $temp['title'];
			$width_image = $temp['width_image'];
			$height_image = $temp['height_image'];
			$image = $temp['image'];
			$alt_image = $temp['alt_image'];
			$description = $temp['description'];
			$date_publication = $temp['date_publication'];
			$author = $temp['author'];

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['TypeItem'] . "
						WHERE type = :type";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('type', $this->type_item_article, PDO::PARAM_STR);
				$req->execute();
				$type_item = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    echo($sql);
			    echo($e->getMessage());
			    die();
			}

			if($type_item) {
				$type_item_id = $type_item->id;
			}
			else {
				$type_item_id = null;
			}

			try
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['Item'] . " 
						(type_item_id,
						category_id,
						guid,
						url,
						title,
						width_image,
						height_image,
						image,
						alt_image,
						description,
						date_publication,
						author)
						VALUES
						(:type_item_id,
						:category_id,
						:guid,
						:url,
						:title,
						:width_image,
						:height_image,
						:image,
						:alt_image,
						:description,
						:date_publication,
						:author)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('type_item_id', $type_item_id, PDO::PARAM_INT);
				$req->bindValue('category_id', $category_id, PDO::PARAM_INT);
				$req->bindValue('guid', $guid, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('title', $title, PDO::PARAM_STR);
				$req->bindValue('width_image', $width_image, PDO::PARAM_INT);
				$req->bindValue('height_image', $height_image, PDO::PARAM_INT);
				$req->bindValue('image', $image, PDO::PARAM_STR);
				$req->bindValue('alt_image', $alt_image, PDO::PARAM_STR);
				$req->bindValue('description', $description, PDO::PARAM_STR);
				$req->bindValue('date_publication', $date_publication, PDO::PARAM_STR);
				$req->bindValue('author', $author, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    echo($sql);
			    echo($e->getMessage());
			    die();
			}
		}
	}
?>