<?php
/**
* this class loads the configuration and the php file of a page
*/
class Page {

	public $config;

	public function __construct($page){
		global $api;

		//load page configuration
		$this->config = $api->loadJsonFile('application/config/pages/web/'.$page.'.json');
		
		//load page html content
		require_once 'application/web/'.$page.'.php';
	}

	/**
	* load all JS files needed to run this page
	*/
	public function loadJS() {

		foreach ($this->config->js as $key => $value) {
			echo "<script src=\"$value\"></script>";
		}
	}

	/**
	* load all CSS files needed to run this page
	*/
	public function loadCSS() {

		foreach ($this->config->css as $key => $value) {
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$value\">";
		}
	}
}
?>