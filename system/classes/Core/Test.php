<?php

class Core_Test {

	protected static $_paths = array(NV_SYSPATH, NV_APPPATH);

	/**
	 * Providea auto-loading supoort of classes that follow NST
	 * @param  [type] $class     [description]
	 * @param  string $directory [description]
	 * @return [type]            [description]
	 */
	public static function auto_load($class, $directory = 'classes')
	{
		// Transform the class name according to PSR-0
		$class     = ltrim($class, '\\');
		$file      = '';
		$namespace = '';

		if ($last_namespace_position = strripos($class, '\\'))
		{
			$namespace = substr($class, 0, $last_namespace_position);
			$class     = substr($class, $last_namespace_position + 1);
			$file      = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
		}

		$file .= str_replace('_', DIRECTORY_SEPARATOR, $class);

		if ($path = Core_Test::find_file($directory, $file))
		{

			// Load the class file
			require $path;

			// Class has been found
			return TRUE;
		}

		// Class is not in the filesystem
		return FALSE;


	}

	public static function find_file($dir, $file, $ext = NULL, $array = FALSE)
	{
		if ($ext === NULL)
		{
			// Use the default extension
			$ext = NV_EXT;
		}
		elseif ($ext)
		{
			// Prefix the extension with a period
			$ext = ".{$ext}";
		}
		else
		{
			// Use no extension
			$ext = '';
		}

		// Create a partial path of the filename
		$path =  $dir . DIRECTORY_SEPARATOR . $file . $ext;

		$found = FALSE;

		foreach (Core_Test::$_paths as $dir)
		{
			if (is_file($dir.$path))
			{
				// A path has been found
				$found = $dir.$path;

	 			// Stop searching
				break;
			}
		}

		return $found;
	}
}