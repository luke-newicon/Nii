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
class CrmActiveRecord extends NiiActiveRecord
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
}