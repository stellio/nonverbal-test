<?php

class Controller_FrontendTemplate extends Controller_nvTemplate {
	
	public $template = 'templates/frontend';


	public function __construct() {
		
	}

	public function before() {

		parent::before();

		if(true ) {// $this->auto_render) {
			$this->template->content = '';
		}
	}

	public function after() {

		if ($this->auto_render) {}
		parent::after();
	}
}