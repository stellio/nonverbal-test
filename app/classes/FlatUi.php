<?php

class FlatUI {

	/**
	 * Buttons
	 */
	public static function button($uri, $body, array $attributes = NULL) {

		if ($attributes === NULL) {
			$attributes = array('class' => 'btn');
		} else {
			foreach ($attributes as $key => $value) {
				if ($key == "class") {
					$attributes[$key] = 'btn ' . $value;
				}
			}
		}
		
		return nvHtml::anchor($uri, $body, $attributes);
	}

	public static function buttonPrimary($name, $body, array $attributes = NULL) {

	}

	/**
	 * Inputs
	 */

	/**
	 * Dropdown
	 */
	
	/**
	 * Select
	 */
	
	/**
	 * Tags input
	 */
	
	/**
	 * Progress bars & Sliders
	 */
	
	/**
	 * Navigation
	 */

	/**
	 * Checkboxes
	 */
	
	/**
	 * Radio Buttons
	 */
	
	/**
	 * Switches
	 */
	
	/**
	 * Glyphs
	 */
	public static function glyph($name) {

		return '<span class="fui-'.$name.'"></span>';
	}
	

	
	public static function checkbox($name, $value = NULL, $id = NULL, $checked = FALSE, array $attributes = NULL)
	{
		$flatUI = array('data-toggle' => 'checkbox','id' => $id );

		$html = array('<label class="checkbox" for="'.$id.'">',
			nvForm::checkbox($name, $value, $checked, FlatUI::mergeAttr($flatUI, $attributes)),
			'Checked</label>'
		);
        return join(' ', $html);
	}

    
	public static function anchor($uri, $title = NULL, array $attributes = NULL, $protocol = NULL, $index = TRUE)
	{
		return nvHtml::anchor($uri, $title, $attr);
	}



	/*
		Tool Functions
	 */
	
	/**
	 * Merge to array
	 * @param  [type] $what [description]
	 * @param  [type] $with [description]
	 * @return array      
	 */
	private static function mergeAttr($what, $with) {

		if (!$with === NULL) 
			$what= array_merge($what, $with);

		return $what;
	}

}