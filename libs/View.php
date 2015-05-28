<?php

class View{
	static $_instance	= NULL; //static instance

	static function getInstance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance	= new View();
		}
		return self::$_instance;
	}

	private function __construct() { //private constructor
	}

	private function __clone() { //private clone
	}

	public function assign($key, $value){
		$this->{$key} = $value;
		return $this;
	}

	function render($file){
		require "views/" . $file . ".phtml";
	}
}