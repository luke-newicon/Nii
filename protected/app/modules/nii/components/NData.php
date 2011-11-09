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
	 * @param array $replaceArray array('find-string'=>'replace-string')
	 */
	public static function replace($subject, $replaceArray){
		return str_replace(array_keys($replaceArray), array_values($replaceArray), $subject);
	}

	/**
	 * shortcut function to Yii::app()->request->getPost();
	 * 
	 * @param string $name post parameter to return
	 * @param mixed $default the default value to return if the post parameter does not exist
	 * @return string/mixed the post paramter or the default value if it does not exist 
	 */
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

	/**
	 * parses a csv string into an array
	 * defaults to in build str_getcsv php implementation if it exists
	 * 
	 * @param string $input 
	 * @param string $delimiter
	 * @param string $enclosure (field enclosure character)
	 * @param string $escape the escape character
	 * @param string $eol
	 * @return type 
	 */
	public static function getCsv($input, $delimiter=',', $enclosure='"', $escape=null) {
		if (function_exists('str_getcsv')) {
			$r = str_getcsv($input, $delimiter, $enclosure, $escape);
		} else {
			$temp = fopen("php://memory", "rw");
			fwrite($temp, $input);
			fseek($temp, 0);
			$r = array();
			while (($data = fgetcsv($temp, 0, $delimiter, $enclosure)) !== false) {
				$r[] = $data[0];
			}
			fclose($temp);
		}
		return $r;
	}
	
	/**
	 * Takes an array of active record objects and 
	 * returns an array of their attribute arrays
	 * 
	 * useful for creating arrays of objects that can be json encoded
	 * 
	 * @param array $activeRecordArray
	 * @return array
	 */
	public static function toAttrArray($activeRecordArray){
		$ret = array();
		foreach($activeRecordArray as $a)
			$ret[] = $a->getAttributes();
		return $ret;
	}

	/**
	 * get an arry of countries
	 * @return array of country-code => country name
	 */
	public static function countries(){
		return require(Yii::getPathOfAlias('nii.data.countries').'.php');
	}
	
	
	/**
	 * Take an integer in pence and convert to pounds
	 */
	public static function penceToPounds($pence){
		$pounds = $pence / 100;
		return number_format($pounds, 2);
	}
	
	/**
	 *	Defines visible columns for grid views
	 * @param model $model
	 * @param string $gridId
	 * @return array 
	 */
	
	public static function visibleColumns($model, $gridId) {
				
		// Get user settings
		$cols = Yii::app()->user->settings->get('grid_columns_'.$gridId);
	
		// If user settings don't exist, check for system settings instead
		if ($cols==null)
			$cols = Yii::app()->settings->get('grid_columns_'.$gridId);
		
		// If neither exists, make array
		if ($cols==null)
			$cols = array();

		$model = new $model;
		$allcolumns = $model->columns(array());
		$columns = array();
		
		foreach ($allcolumns as $col) {
			if ($col['name']) {
				if (array_key_exists($col['name'], $cols)) {
					$columns[$col['name']] = $cols[$col['name']];
				} else {
					$columns[$col['name']] = '1';
				}
			}
		}

		return $columns;
		
	}
	
	/**
	 *	Defines columns to be used for exporting grid data
	 * @param model $model
	 * @param string $gridId
	 * @return array 
	 */
	public static function exportColumns($model, $gridId) {
		
		// Get user settings
		$cols = Yii::app()->user->settings->get('export_columns_'.$gridId);
	
		// If user settings don't exist, check for system settings instead
		if ($cols==null)
			$cols = Yii::app()->settings->get('export_columns_'.$gridId);
		
		// If neither exists, make array
		if ($cols==null)
			$cols = array();

		$model = new $model;
		$allcolumns = $model->columns(array());
		$columns = array();
		
		foreach ($allcolumns as $col) {
			if ($col['name']) {
				if (array_key_exists($col['name'], $cols)) {
					$columns[$col['name']] = $cols[$col['name']];
				} else {
					$columns[$col['name']] = '1';
				}
			}
		}

		return $columns;
	}
	
	/**
	 *	Not sure if this is still being used... May be able to delete, but check for usage first!
	 */
	public static function exportColumnsSql($model, $controller=null, $action=null) {
		$allCols = self::exportColumns($model, $controller, $action);
		$cols = array();
		$check = new $model;
		foreach ($allCols as $col => $value) {
			if ($value == '1' || $value == true) {
				$cols[$col] = $col; //Controller::checkExportCols($model, $col);
			}
		}
		return $cols;
	}
	
}
