<?php

class nvTest extends Core_Test {

	const ACCESS_LEVEL = 'manage_options';


	public function __construct() {

		add_action('admin_menu', array($this, 'initMenu'));
		// add_action('admin_init', array($this, 'installSettings'));
		add_action('admin_enqueue_scripts', array($this, 'loadAssets'));
	}	

	/**
	 * Add plugin button to main menu
	 */
	public function initMenu() {

		add_menu_page(
			'Non-Verbal Test',  					// page title
			'Non-Verbal Test',					// menu title
			nvTest::ACCESS_LEVEL,			// capability
			'NV',						// menu slug
			array($this, 'route'),		// function
			NV_URL.'/assets/img/icon.png'// icon url
		);

//		add_submenu_page(
//			'TreeTest',						// parent slug
//            'Tree Test Settings ', 			// page title
//            'Settings',						// menu title
//            Controller_Admin::ACCESS_LEVEL, // capability
//            'TreeTest&module=Settings', 	// menu slug
//            array( $this, 'route' )			// function
//		);
	}


	public function loadAssets() {

		// self
		wp_enqueue_style(
			'nonverbal-test-admin-style',
			NV_URL . 'assets/css/nonverbal-admin.css'
		);

		wp_enqueue_style(
			'nonverbal-fixes',
			NV_URL . 'assets/css/nonverbal-bootstrap-fixes.css'
		);


		// Tools for answers add/remove
		wp_enqueue_script(
			'nonverbal-test-admin',
			NV_URL . 'assets/js/nonverbal-admin.js',
			array('jquery')
		);

		wp_localize_script(
			'nonverbal-test-admin', 
			'localize', 
			array(
				'ajaxurl' => admin_url('admin-ajax.php')
			)
		);
	}

	public function route() {

		Core_Routing::execute();
	}
}