<?php

/**
 * Description of NData
 *
 * @author steve
 */
class NData
{
    public static function param($param, $defaultVal, $appendIfExists='', $prependIfExists=''){
		return empty($param)?$defaultVal:$prependIfExists.$param.$appendIfExists;
	}
	
	/**
	 * replaces all occurances of $replaceArray keys in the subject string with
	 * the corresponding $replaceArray values
	 * 
	 * @param string $subject
	 * @param array $replaceArray array('FindString'=>'replaceString')
	 */
	public static function replace($subject, $replaceArray){
		return str_replace(array_keys($replaceArray), array_values($replaceArray), $subject);
	}

	public static function post($name, $default=null){
		return Yii::app()->request->getPost($name, $default);
	}

	public static function base64UrlEncode($data)
	{
		return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
	}

	public static function base64UrlDecode($base64)
	{
		return base64_decode(strtr($base64, '-_', '+/'));
	}


}
