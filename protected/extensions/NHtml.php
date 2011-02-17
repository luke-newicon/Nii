<?php
/**
 * NHtml class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NHtml
 *
 * @author steve
 */
class NHtml extends CHtml
{
    //put your code here
	public static function url($route){
		return self::normalizeUrl($route);
	}

	public static function baseUrl(){
		return Yii::app()->request->baseUrl;
	}
}