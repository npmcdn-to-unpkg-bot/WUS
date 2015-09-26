<?php
//this class used to load html template and paterns

class Template {

	public $file;

	public function __construct($file) {
	    
	    $this->file = $file;
	}


	public function getView($data) {
		
		//get data html content
		$content = file_get_contents($this->file);

		if(is_array($data)) {

			foreach ($data as $key => $value) {
				//fill view with data
				$content = str_replace( "%%".$key."%%",$value, $content);
			}
		}
		else {
			$content = "wrong param: array needed in Template::getView()"; 
		}

		return $content;
	}

}
?>