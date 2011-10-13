<?php
/**
 * Yii bootstrap file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @version $Id: yii.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system
 * @since 1.0
 */

require(dirname(__FILE__).'/../../yii/YiiBase.php');
require(dirname(__FILE__).'/modules/nii/Nii.php');
/**
 * Yii is a helper class serving common framework functionalities.
 *
 * It encapsulates {@link YiiBase} which provides the actual implementation.
 * By writing your own Yii class, you can customize some functionalities of YiiBase.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: yii.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system
 * @since 1.0
 */
class Yii extends YiiBase
{
	
	/**
	 * Creates a Web application instance.
	 * @param mixed $config application configuration.
	 * If a string, it is treated as the path of the file that contains the configuration;
	 * If an array, it is the actual configuration information.
	 * Please make sure you specify the {@link CApplication::basePath basePath} property in the configuration,
	 * which should point to the directory containing all application logic, template and data.
	 * If not, the directory will be defaulted to 'protected'.
	 * @return Nii
	 */
	public static function createWebApplication($config=null)
	{
		return self::createApplication('Nii',$config);
	}
	
	

	
}
