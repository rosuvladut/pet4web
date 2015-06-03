<?php

class Logout extends Controller{

	function __construct(){
		parent::__construct();
	}

	public function index(){
		if($_SESSION['logg_in']){
			$_SESSION['logg_in'] = false;
            $_SESSION['success_message']="Successfully logged out!";
            $this->view->render('index/index');
		}
//		header("Location:" . URL);
	}

}