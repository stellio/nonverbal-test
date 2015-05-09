<?php

class Core_Form extends Core_Object {

	public static function input($name, $value = NULL, array $attributes = NULL)
	{
		// Set the input name
		$attributes['name'] = $name;

		// Set the input value
		$attributes['value'] = $value;

		if ( ! isset($attributes['type']))
		{
			// Default type is text
			$attributes['type'] = 'text';
		}

		return '<input'.Core_HTML::attributes($attributes).' />';
	}

	/**
	 * Creates a checkbox form input.
	 *
	 *     echo Form::checkbox('remember_me', 1, (bool) $remember);
	 *
	 * @param   string  $name       input name
	 * @param   string  $value      input value
	 * @param   boolean $checked    checked status
	 * @param   array   $attributes html attributes
	 * @return  string
	 * @uses    Form::input
	 */
	public static function checkbox($name, $value = NULL, $checked = FALSE, array $attributes = NULL)
	{
		$attributes['type'] = 'checkbox';

		if ($checked === TRUE)
		{
			// Make the checkbox active
			$attributes[] = 'checked';
		}

		return Core_Form::input($name, $value, $attributes);
	}

}