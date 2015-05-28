<?php

class Bootstrap{
	function __construct(){
		$url = isset($_GET['url'])? rtrim($_GET['url'],"/"): null;
	

		//echo $url;
		$url= explode("/",$url);
		//print_r($url);
		
		if(empty($url[0])){
			require "controllers/index.php";
			$controller = new Index();
			$controller->index();
			return false;
		}else{
			$file = "controllers/". $url[0]. ".php";
			if(file_exists($file)){
				require $file;
				$controller = new $url[0];
			}else{
				require "controllers/error.php";
				$controller = new Error();
				
			}
		}
		
		if(isset($url[1])){ 
			if(isset($url[2])){
				$controller->{$url[1]}($url[2]); //$controller->dosomething()
			}else{
				$controller->{$url[1]}();
			}
		} else {
			$controller->index();
		}
	}
}