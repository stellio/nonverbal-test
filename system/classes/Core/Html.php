<?php

class Core_Html extends Core_Object {


	/**
	 * @var  array  preferred order of attributes
	 */
	public static $attribute_order = array
	(
		'action',
		'method',
		'type',
		'id',
		'name',
		'value',
		'href',
		'src',
		'width',
		'height',
		'cols',
		'rows',
		'size',
		'maxlength',
		'rel',
		'media',
		'accept-charset',
		'accept',
		'tabindex',
		'accesskey',
		'alt',
		'title',
		'class',
		'style',
		'selected',
		'checked',
		'readonly',
		'disabled',
	);

	/**
	 * @var  boolean  use strict XHTML mode?
	 */
	public static $strict = TRUE;

	/**
	 * @var  boolean  automatically target external URLs to a new window?
	 */
	public static $windowed_urls = FALSE;
	
	/**
	 * Create HTML link anchors. Note that the title is not escaped, to allow
	 * HTML elements within links (images, etc).
	 *
	 *     echo HTML::anchor('/user/profile', 'My Profile');
	 *
	 * @param   string  $uri        URL or URI string
	 * @param   string  $title      link text
	 * @param   array   $attributes HTML anchor attributes
	 * @param   mixed   $protocol   protocol to pass to URL::base()
	 * @param   boolean $index      include the index page
	 * @return  string
	 * @uses    URL::base
	 * @uses    URL::site
	 * @uses    HTML::attributes
	 */
	public static function anchor($uri, $title = NULL, array $attributes = NULL, $protocol = NULL, $index = TRUE)
	{
		if ($title === NULL)
		{
			// Use the URI as the title
			$title = $uri;
		}

		if ($uri === '')
		{
			// Only use the base URL
			// $uri = URL::base($protocol, $index);
			
		}
		else
		{
			if (strpos($uri, '://') !== FALSE)
			{
				if (Core_HTML::$windowed_urls === TRUE AND empty($attributes['target']))
				{
					// Make the link open in a new window
					$attributes['target'] = '_blank';
				}
			}
			elseif ($uri[0] !== '#')
			{
				// Make the URI absolute for non-id anchors
				// $uri = URL::site($uri, $protocol, $index);
			}
		}

		// Add the sanitized link to the attributes
		$attributes['href'] = $uri;

		return '<a'.Core_HTML::attributes($attributes).'>'.$title.'</a>';
	}

	/**
	 * Convert special characters to HTML entities. All untrusted content
	 * should be passed through this method to prevent XSS injections.
	 *
	 *     echo HTML::chars($username);
	 *
	 * @param   string  $value          string to convert
	 * @param   boolean $double_encode  encode existing entities
	 * @return  string
	 */
	public static function chars($value, $double_encode = TRUE)
	{
		return htmlspecialchars( (string) $value, ENT_QUOTES, Core_Core::$charset, $double_encode);
	}

	/**
	 * Compiles an array of HTML attributes into an attribute string.
	 * Attributes will be sorted using HTML::$attribute_order for consistency.
	 *
	 *     echo '<div'.HTML::attributes($attrs).'>'.$content.'</div>';
	 *
	 * @param   array   $attributes attribute list
	 * @return  string
	 */
	public static function attributes(array $attributes = NULL)
	{
		if (empty($attributes))
			return '';

		$sorted = array();
		foreach (Core_HTML::$attribute_order as $key)
		{
			if (isset($attributes[$key]))
			{
				// Add the attribute to the sorted list
				$sorted[$key] = $attributes[$key];
			}
		}

		// Combine the sorted attributes
		$attributes = $sorted + $attributes;

		$compiled = '';
		foreach ($attributes as $key => $value)
		{
			if ($value === NULL)
			{
				// Skip attributes that have NULL values
				continue;
			}

			if (is_int($key))
			{
				// Assume non-associative keys are mirrored attributes
				$key = $value;

				if ( ! Core_HTML::$strict)
				{
					// Just use a key
					$value = FALSE;
				}
			}

			// Add the attribute key
			$compiled .= ' '.$key;

			if ($value OR Core_HTML::$strict)
			{
				// Add the attribute value
				$compiled .= '="'.Core_HTML::chars($value).'"';
			}
		}

		return $compiled;
	}


	// Old funciton
	public static function link($params = array(), $source = '', $hint = '', $class = '') {

		$entryPoint = 'admin.php?page=NV&';
		$url = array();

		foreach ($params as $key => $value) {
			$url[] = $key . '=' . $value ;
		}
		return '<a href="' . $entryPoint . join('&', $url) . '" title="' . $hint . '" class="' . $class . '"  >' . $source . '</a>';
	}

	public static function imgDelete() {
		return '<span class="fui-trash"></span>';
	}

	public static function imgPlus() {
		return '<span class="fui-plus"></span>';	
	}

	public static function imgInfo() {
		return '<span class="fui-info-circle"></span>';	

	}

	public static function imgEdit() {
		return '<span class="fui-new"></span>';
	}

	public static function imgChart() {
		return '<img class="treetest-icons" src="' . TT_URL . '/assets/img/16/chart_pie.png">';
	}

	public static function button($params = array(), $source = '', $class = '') {

		$entryPoint = 'admin.php?page=NV&';
		$url = array();

		foreach ($params as $key => $value) {
			$url[] = $key . '=' . $value ;
		}
		return '<a class="' . $class . '" href="' . $entryPoint . join('&', $url) . '" >' . $source . '</a>';
	}

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

	public static function shorten($val) {
    	
    	return mb_substr(strip_tags($val), 0, 70) . '...';
    }

    /**
	 * Return '<option></option>' selected parameter if key and type equal
	 * @param  string  $key		the option value id
	 * @param  string  $type 	the item value from base
	 * @return string			selected parameter|nothing
	 */
	public static function isSelected($key, $type) {

        $result = ($key == $type) ? 'selected="selected"' : '';
        return $result;
    }

    public static function options($sings, $selected = array()) {

    	foreach ($sings as $item) {
    		
    		if (in_array($item->code, $selected))
    			echo sprintf('<option value="%s" selected>%s (%s)</option>', $item->code, $item->code, $item->name);
    		else
    			echo sprintf('<option value="%s">%s (%s)</option>', $item->code, $item->code, $item->name);
    	}
    }

    public static function isChecked($bool) {
    	echo ($bool)? 'checked="checked"' : '';
    }
}