<?php

class Logout extends Controller{

	function __construct(){
		parent::__construct();
	}

	public function index(){
		if($_SESSION['logg_in']){
			$_SESSION['logg_in'] = false;
		}
		header("Location:" . URL);
	}

}