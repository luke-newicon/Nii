<?php
/**
 * CrmActiveRecord class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of CrmActiveRecord
 *
 * @author steve
 */
class CrmActiveRecord extends NAppRecord
{

	
	public function saveMany($array, $contactId){
		$ret = true;
		if(!empty($array))
			$this->deleteAll('contact_id=:id',array(':id'=>$contactId));
		foreach($array as $i => $v){
			$model = get_class($this);
			$m = new $model;
			$m->attributes = $array[$i];
			$m->contact_id = $contactId;
			$ret = $m->save();
		}
		return $ret;
	}
	
	/**
	 * get all labels using distinct from table and merge with $preSetArray
	 * 
	 * @param string $className
	 * @param array $preSetArray array('Home'=>array('title'=>''),'Work'=>array('title'=>''))
	 * @return array 
	 */
	public static function getLabels($className, $preSetArray){
		return self::labelArray(
			self::model($className)->cmd()->selectDistinct('label')->queryAll(),
			$preSetArray
		);
	}
	
	/**
	 * merge two arrays and return in format suitable for popup list
	 * @param type $rowset
	 * @param type $defaultsArray
	 * @return type 
	 */
	public static function labelArray($rowset, $defaultsArray){
		$tmp=array();
		foreach($rowset as $l){
			if(isset($l->label)) continue;
			$tmp[$l->label] = $l->label;
		}
		return array_merge($tmp, array_combine(array_keys($defaultsArray), array_values($defaultsArray)));
	}
	
}