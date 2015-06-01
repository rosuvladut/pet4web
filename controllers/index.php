<?php

class Index extends Controller{

	function __construct(){
		parent::__construct();
	}

	public function index($arg = false){
		$this->view->render('index/index');
	}
}