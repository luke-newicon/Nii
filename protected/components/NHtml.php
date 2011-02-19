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
	public static function url($route, $getArray=array()){
		
		return CHtml::encode(self::normalizeUrl(array($route, $getArray)));
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
		$attrs = new Newicon_Html_Attr($htmlOptions);
		$attrs->add('class',$hilightClass);
		$search = preg_quote($searchTerm, '/');
		return preg_replace("/($search)/i", '<span '.$attrs.'>$1</span>', $textToHilight);
	}

}