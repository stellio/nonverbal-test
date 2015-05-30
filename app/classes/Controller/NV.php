<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Manage test
 */
class Controller_NV extends Controller_BackendTemplate  {

	public $view;

	public function __construct() {
		parent::__construct();

		// function loadFlat_UI() {
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


	/**
	 * Show list of existing tests
	 */
	public function action_index() {

		$url = NV_URL;

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
		
		$view = nvView::factory('test/list');
		$test = nvModel::factory('nvTestList');

		$this->template->content = $view->bind('tests', $test->getTestList());
	}

	public function action_delete() {

		$test = nvModel::factory('nvTest');
		
		if (isset($_GET['id']) && $_GET['id'] != 0) {

			$test->delete($_GET['id']);
				
		}

		$this->action_index();
	}
}
?>