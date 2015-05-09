<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Create and registered in wordpress, plugin settings
 */
class Controller_nvSettings {

	private $options;

	/**
	 * Registered settings and load settings options
	 */
	public function __construct() {

		// register settings
//		$this->registerSettings();
//		$this->options = get_option( 'treetest-settings' );
	}

	/**
	 * Show settings
	 */
	public function action_index() {

		return;
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e('Tree Test Settings'); ?></h2>
			<form method="post" action="options.php">
				<?php
					submit_button();
					// Print out all hidden setting fields
					echo '<div id="poststuff">';
						echo '<div class="postbox">';
							
								// settings_fields( 'treetest-options' );
					
							

							do_settings_sections( 'treetest-settings' );
						echo "</div>";
					echo "</div>";
					// echo "</div>";
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Registered settings in wp
	 */
	public function registerSettings() {

		register_setting( 
			'treetest-options', // option group
			'treetest-settings' // option name
			// array($this, 'validate') // validator
		);

		// Basic settings section
		add_settings_section(
			'basic-settings', // ID
			'Basic Settings', // Title
			array($this, 'printSectionInfo' ), // callback
			'treetest-settings' // Page
		);

		// add field
		add_settings_field(
			'onlyForRegistereg', // id
			'To pass test, must be registered', // title
			array($this, 'onlyForRegisteregCallback'),
			'treetest-settings', // page
			'basic-settings'// parent section
		);
	}

	public function printSectionInfo() {

		echo '<h3 class="hndle">'; 
		// print 'Basic settings:';
		echo '</h3>';
	}

	public function onlyForRegisteregCallback() {

		// echo '<div class="postbox">';
		// echo '<h3 class="hndle">Тest Settings</h3>';
		echo '<div class="inside">';
			printf('<input type="checkbox" name="treetest-settings[onlyForRegistereg]" value="1" %s />',
				isset( $this->options['onlyForRegistereg'] ) ? checked($this->options['onlyForRegistereg'], 1 , false) : ''
			);
					
		echo "</div>";
		// echo "</div>";

	}

	public function validate($input) {

		$new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
	}


}
?>