<?php

class Controller_TestMenuTemplate extends Controller_nvTemplate {
	
	public $template = 'templates/test-menu';


	public function __construct() {
		$this->loadFlat_UI();
	}

	public function before() {

		parent::before();

		if(true ) {// $this->auto_render) {
			$this->template->content = '';
			$this->template->id = $this->req('id');

		}
	}

	public function after() {

		if ($this->auto_render) {}
		parent::after();
	}

	private function loadFlat_UI() {
		$url = NV_URL;

			// echo $url;

		// css
		// wp_enqueue_style('nv_css_bootstrap', $url . 'includes/libs/bootstrap-featured/css/bootstrap.min.css');
		wp_enqueue_style('nv_css-flat-ui-bootstrap', $url . 'includes/libs/Flat-UI/dist/css/vendor/bootstrap.min.css');
		wp_enqueue_style('nv_css_flat-ui', $url . 'includes/libs/Flat-UI/dist/css/flat-ui.css');


		// js
		// wp_enqueue_script('nv_js_bootstrap',$url . 'includes/libs/bootstrap-featured/js/bootstrap.min.js', array('jquery'));

		// Tools for answers add/remove
		wp_enqueue_script('nv_js_flat-ui', $url . 'includes/libs/Flat-UI/dist/js/flat-ui.min.js',array('jquery'));

		wp_enqueue_script('nv_js_flat-ui-app',$url . 'includes/libs/Flat-UI/docs/assets/js/application.js',	array('jquery'));	
	// }
	}
}