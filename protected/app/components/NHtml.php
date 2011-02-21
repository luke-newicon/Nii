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
   
	/**
	 * Format a route into a url a shorthand method of calling normalizeUrl
	 * 
	 * For convienience the $route parameter can be a string
	 * A yii route is defined array('/moduleId/controllerId/actionId', 'getParam1'=>'getParamVal1')
	 * This function allows route to be a string as well for example
	 * NHtml::url('/crm/contact/show', array('id'=>3))
	 * however you can also use this the same as calling normalizeUrl
	 * 
	 * @see CHtml::normalizeUrl
	 * @param mixed (string|array) $route if route is an array the $getArray parameter is ignored
	 * @param array $getArray additional get parameters
	 * @return type 
	 */
	public static function url($route, $getArray=array()){
		if(is_string($route)){
			$getArray[0] = $route; 
			$route = $getArray;
		}
		return self::normalizeUrl($route);
	}

	public static function baseUrl(){
		return Yii::app()->request->baseUrl;
	}

	/**
	 * Lowercase the first leter of a string
	 * @param $str
	 * @return string
	 */
	public static function lcFirst($str){
		if(function_exists('lcfirst'))
			return lcfirst($str);
		return strtolower(substr($str,0,1)).substr($str,1);
	}


	public static function hilightText($textToHilight, $searchTerm, $hilightClass='searchHilite', $htmlOptions=array())
	{
		if (is_array($searchTerm))
			return '';
		//if search term is empty then return the string do not perform the search
		if(empty($searchTerm))
			return $textToHilight;
		if(!isset($htmlOptions['class']))
			$htmlOptions['class'] = $hilightClass;
		$search = preg_quote($searchTerm, '/');
		return preg_replace("/($search)/i", '<span '.CHtml::renderAttributes($htmlOptions).'>$1</span>', $textToHilight);
	}

}