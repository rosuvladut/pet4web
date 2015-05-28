<?php

//require('models/');

class Controller {
	
	public function __construct(){
		session_start();
		$this->view = View::getInstance();
	}
}