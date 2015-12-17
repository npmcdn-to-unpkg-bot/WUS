<?php

$ouput = null;

if(isset($_POST["type"]) && isset($_POST["action"]))
{
	if(($_POST["type"] == "logo") && ($_POST["action"] == "set")) $output_dir = (dirname(dirname(dirname(dirname(__FILE__)))) . "/ressources/logo/");
	if(($_POST["type"] == "collaboration") && ($_POST["action"] == "set")) $output_dir = (dirname(dirname(dirname(dirname(__FILE__)))) . "/ressources/collaboration/");
	if(($_POST["type"] == "item") && ($_POST["action"] == "set")) $output_dir = (dirname(dirname(dirname(dirname(__FILE__)))) . "/ressources/item/");
}

error_log('Path 2 : ' . $output_dir);

if(isset($_FILES["myfile"]))
{
	$ret = array();

	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
		$filename = str_replace(' ', '_', trim(strtolower($_FILES["myfile"]["name"])));

 	 	$info = pathinfo($filename);
 	 	$name = $info['filename'];
		$ext  = $info['extension'];
		$name = str_replace('.', '_', $name);
		$filename = date('dmY_H_i_s_') . $name . '.' . $ext;

 	 	error_log('Output Upload : ' . $output_dir . $filename . "\n");

 	 	//create destination folder if not exists
 	 	if (!is_dir($output_dir)) {
		    mkdir($output_dir, 0777, true);
		}

 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$filename);
    	$ret[]= $filename;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$filename = str_replace(' ', '_', trim(strtolower($_FILES["myfile"]["name"])));

 	 	$info = pathinfo($filename);
 	 	$name = $info['filename'];
		$ext  = $info['extension'];
		$name = str_replace('.', '_', $name);
		$filename = date('dmY_H_i_s_') . $name . '.' . $ext;

	  	error_log('Output Upload : ' . $output_dir . $filename . "\n");

	  	//create destination folder if not exists
 	 	if (!is_dir($output_dir)) {
		    mkdir($output_dir, 0777, true);
		}
	  	
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$filename);
	  	$ret[]= $filename;
	  }
	
	}
    echo json_encode($ret);
 }
 ?>