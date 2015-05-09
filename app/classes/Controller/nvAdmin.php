<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Backend Controller
 */
class Controller_nvAdmin {

	const ACCESS_LEVEL = 'manage_options';


	public function __construct() {

		add_action('admin_menu', array($this, 'menuSetup'));
		add_action('admin_init', array($this, 'installSettings'));
		add_action('admin_enqueue_scripts', array($this, 'enqueueScript'));
	}	

	/**
	 * Add plugin button to main menu
	 */
	public function menuSetup() {

		add_menu_page(
			'Non-Verbal Test',  					// page title
			'Non-Verbal Test',					// menu title
			Controller_nvAdmin::ACCESS_LEVEL,	// capability
			'nvTest',						// menu slug
			array( $this, 'route' ),		// function
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

	/**
	 * Create and install plugin settings
	 */
	public function installSettings() {

		// new Controller_nvSettings();
	}

	/**
	 * Load backend javascripts
	 */
	public function enqueueScript() {

		// self
		wp_enqueue_style(
			'nonverbal-test-admin-style',
			NV_URL . 'includes/css/nonverbal-admin.css'
		);

		// Tools for answers add/remove
		wp_enqueue_script(
			'nonverbal-test-admin',
			NV_URL . 'includes/js/nonverbal-admin.js',
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

	public function installDb() {
	}

	/**
	 * Routing requests to other classes
	 */
	public function route() {

		NV_Routing::execute();
	}
}

?>