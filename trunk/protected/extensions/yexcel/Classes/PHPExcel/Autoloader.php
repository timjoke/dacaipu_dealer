<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    1.7.8, 2012-10-12
 */

spl_autoload_unregister(array('YiiBase', 'autoload'));
PHPExcel_Autoloader::Register();
spl_autoload_register(array('YiiBase', 'autoload'));
//	As we always try to run the autoloader before anything else, we can use it to do a few
//		simple checks and initialisations
PHPExcel_Shared_ZipStreamWrapper::register();
// check mbstring.func_overload
if (ini_get('mbstring.func_overload') & 2) {
    throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
}
PHPExcel_Shared_String::buildCharacterSets();


/**
 * PHPExcel_Autoloader
 *
 * @category	PHPExcel
 * @package		PHPExcel
 * @copyright	Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Autoloader
{
	/**
	 * Register the Autoloader with SPL
	 *
	 */
	public static function Register() {
		/*if (function_exists('__autoload')) {
			//	Register any existing autoloader function with SPL, so we don't get any clashes
			spl_autoload_register('__autoload');
		}
		//	Register ourselves with SPL
		return spl_autoload_register(array('PHPExcel_Autoloader', 'Load'));*/
		
		$functions = spl_autoload_functions();
            foreach ( $functions as  $function)
                spl_autoload_unregister($function);
            $functions = array_merge(array(array('PHPExcel_Autoloader','Load')),$functions);
            foreach ( $functions as $function)
                $x = spl_autoload_register($function);
            return $x;
	}	//	function Register()
	
	/**
	 * Autoload a class identified by name
	 *
	 * @param	string	$pClassName		Name of the object to load
	 */
	public static function Load($pClassName){
		if ((class_exists($pClassName,FALSE)) || (strpos($pClassName, 'PHPExcel') !== 0)) {
			//	Either already loaded, or not a PHPExcel class request
			return FALSE;
		}

		$pClassFilePath = PHPEXCEL_ROOT .
						  str_replace('_',DIRECTORY_SEPARATOR,$pClassName) .
						  '.php';

		if ((file_exists($pClassFilePath) === false) || (is_readable($pClassFilePath) === false)) {
			//	Can't load
			return FALSE;
		}

		require($pClassFilePath);
	}	//	function Load()

}