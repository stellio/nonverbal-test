<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Basic View class
 */
class Core_View
{
	const 	TAB_TEST = 1,
			TAB_SIGN = 2,
			TAB_TPE = 3,
			TAB_PROFILES = 4,
			TAB_QUESTIONS = 5,
			TAB_RESULTS = 6;

	// global variables
	protected static $_global_data = array();

	/**
	 * Returns a new View object. If you do not define the "file" parameter,
	 * you must call [View::set_filename].
	 *
	 *     $view = View::factory($file);
	 *
	 * @param   string  $file   view filename
	 * @param   array   $data   array of values
	 * @return  View
	 */
	public static function factory($file = NULL, array $data = NULL)
	{
		return new nvView($file, $data);
	}
	
	/**
	 * Captures the output that is generated when a view is included.
	 * The view data will be extracted to make local variables. This method
	 * is static to prevent object scope resolution.
	 *
	 *     $output = View::capture($file, $data);
	 *
	 * @param   string  $kohana_view_filename   filename
	 * @param   array   $kohana_view_data       variables
	 * @return  string
	 */
	protected static function capture($view_filename, array $view_data)
	{
		// Import the view variables to local namespace
		extract($view_data, EXTR_SKIP);

		if (nvView::$_global_data)
		{
			// Import the global view variables to local namespace
			extract(nvView::$_global_data, EXTR_SKIP | EXTR_REFS);
		}

		// Capture the view output
		ob_start();

		try
		{
			// Load the view within the current scope
			include $view_filename;
		}
		catch (Exception $e)
		{
			// Delete the output buffer
			ob_end_clean();

			// Re-throw the exception
			throw $e;
		}

		// Get the captured output and close the buffer
		return ob_get_clean();
	}

	/**
	 * Sets a global variable, similar to [View::set], except that the
	 * variable will be accessible to all views.
	 *
	 *     View::set_global($name, $value);
	 *
	 * @param   string  $key    variable name or an array of variables
	 * @param   mixed   $value  value
	 * @return  void
	 */
	public static function set_global($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $key2 => $value)
			{
				nvView::$_global_data[$key2] = $value;
			}
		}
		else
		{
			nvView::$_global_data[$key] = $value;
		}
	}

	/**
	 * Assigns a global variable by reference, similar to [View::bind], except
	 * that the variable will be accessible to all views.
	 *
	 *     View::bind_global($key, $value);
	 *
	 * @param   string  $key    variable name
	 * @param   mixed   $value  referenced variable
	 * @return  void
	 */
	public static function bind_global($key, & $value)
	{
		nvView::$_global_data[$key] =& $value;
	}

	// View filename
	protected $_file;

	// Array of local variables
	protected $_data = array();

	/**
	 * Sets the initial view filename and local data. Views should almost
	 * always only be created using [View::factory].
	 *
	 *     $view = new View($file);
	 *
	 * @param   string  $file   view filename
	 * @param   array   $data   array of values
	 * @return  void
	 * @uses    View::set_filename
	 */
	public function __construct($file = NULL, array $data = NULL)
	{
		if ($file !== NULL)
		{
			$this->set_filename($file);
		}

		if ($data !== NULL)
		{
			// Add the values to the current data
			$this->_data = $data + $this->_data;
		}
	}

	/**
	 * Magic method, searches for the given variable and returns its value.
	 * Local variables will be returned before global variables.
	 *
	 *     $value = $view->foo;
	 *
	 * [!!] If the variable has not yet been set, an exception will be thrown.
	 *
	 * @param   string  $key    variable name
	 * @return  mixed
	 * @throws  Kohana_Exception
	 */
	public function & __get($key)
	{
		if (array_key_exists($key, $this->_data))
		{
			return $this->_data[$key];
		}
		elseif (array_key_exists($key, nvView::$_global_data))
		{
			return nvView::$_global_data[$key];
		}
		else
		{
			throw new Exception('View variable is not set: :var');
		}
	}

	/**
	 * Magic method, calls [View::set] with the same parameters.
	 *
	 *     $view->foo = 'something';
	 *
	 * @param   string  $key    variable name
	 * @param   mixed   $value  value
	 * @return  void
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * Magic method, determines if a variable is set.
	 *
	 *     isset($view->foo);
	 *
	 * [!!] `NULL` variables are not considered to be set by [isset](http://php.net/isset).
	 *
	 * @param   string  $key    variable name
	 * @return  boolean
	 */
	public function __isset($key)
	{
		return (isset($this->_data[$key]) OR isset(nvView::$_global_data[$key]));
	}

	/**
	 * Magic method, unsets a given variable.
	 *
	 *     unset($view->foo);
	 *
	 * @param   string  $key    variable name
	 * @return  void
	 */
	public function __unset($key)
	{
		unset($this->_data[$key], nvView::$_global_data[$key]);
	}

	/**
	 * Magic method, returns the output of [View::render].
	 *
	 * @return  string
	 * @uses    View::render
	 */
	
	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (Exception $e)
		{
			/**
			 * Display the exception message.
			 *
			 * We use this method here because it's impossible to throw and
			 * exception from __toString().
			 */
			
			throw new Exception("Error convert to String", 1);
			
			
		}
	} 

	/**
	 * Sets the view filename.
	 *
	 *     $view->set_filename($file);
	 *
	 * @param   string  $file   view filename
	 * @return  View
	 * @throws  View_Exception
	 */
	public function set_filename($file)
	{
		if (($path = nvTest::find_file('views', $file)) === FALSE)
		{
			throw new Exception('The requested view could not be found: '. $file, 1);
		}

		// Store the file path locally
		$this->_file = $path;

		return $this;
	}

	/**
	 * Assigns a variable by name. Assigned values will be available as a
	 * variable within the view file:
	 *
	 *     // This value can be accessed as $foo within the view
	 *     $view->set('foo', 'my value');
	 *
	 * You can also use an array to set several values at once:
	 *
	 *     // Create the values $food and $beverage in the view
	 *     $view->set(array('food' => 'bread', 'beverage' => 'water'));
	 *
	 * @param   string  $key    variable name or an array of variables
	 * @param   mixed   $value  value
	 * @return  $this
	 */
	public function set($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $name => $value)
			{
				$this->_data[$name] = $value;
			}
		}
		else
		{
			$this->_data[$key] = $value;
		}

		return $this;
	}

	/**
	 * Assigns a value by reference. The benefit of binding is that values can
	 * be altered without re-setting them. It is also possible to bind variables
	 * before they have values. Assigned values will be available as a
	 * variable within the view file:
	 *
	 *     // This reference can be accessed as $ref within the view
	 *     $view->bind('ref', $bar);
	 *
	 * @param   string  $key    variable name
	 * @param   mixed   $value  referenced variable
	 * @return  $this
	 */
	public function bind($key, & $value)
	{
		$this->_data[$key] =& $value;

		return $this;
	}

	/**
	 * Renders the view object to a string. Global and local data are merged
	 * and extracted to create local variables within the view file.
	 *
	 *     $output = $view->render();
	 *
	 * [!!] Global variables with the same key name as local variables will be
	 * overwritten by the local variable.
	 *
	 * @param   string  $file   view filename
	 * @return  string
	 * @throws  View_Exception
	 * @uses    View::capture
	 */
	public function render($file = NULL)
	{
		if ($file !== NULL)
		{
			$this->set_filename($file);
		}

		if (empty($this->_file))
		{
			throw new Exception('You must set the file to use within your view before rendering',1);
		}

		// Combine local and global data and capture the output
		return nvView::capture($this->_file, $this->_data);
	}




	// -------------------------------------------------------------

	/**
	 * Simple message box
	 * @param  string $msg  the message text
	 * @param  string $type type of message. By default - error
	 */
	public static function admin_notices($msg, $type = 'success') {
		// if($type === 'info')
			// echo '<div class="updated"><p><strong>'.$msg.'</strong></p></div>';
			// echo '<div class="alert alert-success" role="alert">' .$msg. '</div>';
		// else
			// echo '<div class="error"><p><strong>'.$msg.'</strong></p></div>';
			// echo '<div class="alert alert-danger" role="alert">'. $msg.'</div>';
			// 
		echo '<div class="alert alert-' . $type .'" role="alert">' . $msg . '</div>';

	}

	/**
	 * Show view with content 
	 * @param  string $view    	view name
	 * @param  string $content	the content
	 */
	/*function render($view, $content = '') {

		$view = NV_DIR . 'includes/view/View_' . $view . '.php';

		if (file_exists($view)) {
			include ($view);
 		} else {
			echo "<h2>Cant render View</h2>";
		}
	}*/

	/**
	 * Return '<option></option>' selected parameter if key and type equal
	 * @param  string  $key		the option value id
	 * @param  string  $type 	the item value from base
	 * @return string			selected parameter|nothing
	 */
	function isSelected($key, $type) {

        $result = ($key == $type) ? 'selected="selected"' : '';
        return $result;
    }

    /**
     * Trim string to 70 symbols
     * @param  string $val the string
     * @return string      shorten string
     */
    function shorten($val) {
    	
    	return mb_substr(strip_tags($val), 0, 70) . '...';
    }

    function tabs($test, $activeTab, $subTitle = "") {

    	$id = $test->getId();
    	$acTb = $activeTab;

    	?>
    	<h2>Тест : <?=$test->getName();?> <?=($subTitle != "")? ".".$subTitle : ""?></h2>
    	<h2 class="nav-tab-wrapper">
	        <a href="admin.php?page=nvTest&action=edit&id=<?=$id;?>" class="nav-tab <?=($acTb == $this::TAB_TEST)? 'nav-tab-active': ''?>">Общие</a>
	        <a href="admin.php?page=nvTest&module=nvSign&test_id=<?=$id;?>" class="nav-tab  <?=($acTb == $this::TAB_SIGN)? 'nav-tab-active': ''?>">Признаки</a>
	        <a href="admin.php?page=nvTest&module=nvTpe&test_id=<?=$id;?>" class="nav-tab  <?=($acTb == $this::TAB_TPE)? 'nav-tab-active': ''?>">ТПЭ</a>
	        <a href="admin.php?page=nvTest&module=nvProfile&test_id=<?=$id;?>" class="nav-tab <?=($acTb == $this::TAB_PROFILES)? 'nav-tab-active': ''?>">Профили</a>
	        <a href="admin.php?page=nvTest&module=nvQuestion&test_id=<?=$id;?>" class="nav-tab <?=($acTb == $this::TAB_QUESTIONS)? 'nav-tab-active': ''?>">Вопросы</a>
	        <a href="admin.php?page=nvTest&module=nvResult&test_id=<?=$id;?>" class="nav-tab <?=($acTb == $this::TAB_RESULTS)? 'nav-tab-active': ''?>">Результаты</a>
    	</h2>
    	<?php
    }

	function link($params = array(), $source = '', $hint = '') {

		$entryPoint = 'admin.php?page=nvTest&';
		$url = array();

		foreach ($params as $key => $value) {
			$url[] = $key . '=' . $value ;
		}
		return '<a href="' . $entryPoint . join('&', $url) . '" title="' . $hint . '">' . $source . '</a>';
	}

	function button($params = array(), $source = '', $class = '') {

		$entryPoint = 'admin.php?page=NV&';
		$url = array();

		foreach ($params as $key => $value) {
			$url[] = $key . '=' . $value ;
		}
		return '<a class="' . $class . '" href="' . $entryPoint . join('&', $url) . '" >' . $source . '</a>';
	}

	function imgDelete() {
		return '<img class="treetest-icons" src="' . NV_URL . '/assets/img/16/delete.png">';
	}

	function imgEdit() {
		return '<img class="treetest-icons" src="' . NV_URL . '/assets/img/16/pencil.png">';
	}

	function imgChart() {
		return '<img class="treetest-icons" src="' . TT_URL . '/assets/img/16/chart_pie.png">';
	}

    /**
     * Default class method. Must be overload in child views
     */
	function show() {}
}
?>