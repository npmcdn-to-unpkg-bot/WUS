<?php

	/**
	* 
	*/
	class Verification {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getVerification($key) {

			$message = "";

			try
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['User'] . " WHERE verification_key = SHA1(:key)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('key', $key, PDO::PARAM_STR);
				$req->execute();
				$account = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($account) {

				// Vérifier si le compte n'est pas déjà activé
				// Si oui, message déjà activé
				// Sinon activation, puis message d'activation
				if($account->verified == true) {
					$message = "Ce compte est déjà actif.";
				} else {

					try
					{
						$sql = "UPDATE " . $this->_TABLES['public']['User'] . " 	
						SET verified = :verified
						WHERE id = :id";
						$req = $this->bdd->prepare($sql);
						$req->bindValue('verified', true, PDO::PARAM_BOOL);
						$req->bindValue('id', $account->id, PDO::PARAM_INT);
						$req->execute();
					}
					catch (PDOException $e)
					{
					    error_log($sql);
					    error_log($e->getMessage());
					    die();
					}

					$message = "Votre compte à bien été activé. Merci de votre patience et bonne navigation.";
				}
			}
			else {
				$message = "Le lien d'activation semble incorrect. Merci de contacter le support.";
			}

			return $message;
		}
	}
?>