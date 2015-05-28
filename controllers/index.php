<?php

class Index extends Controller{

	function __construct(){
		parent::__construct();
		//$this->view->message = "ana are mere";
		//$this->view->render('index/index');
	}

	public function index($arg = false){
		$this->view->render('index/index');
	}
}