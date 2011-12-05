<?php

/**
 * Tag class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of Tag
 *
 * @author steve
 */
class NTag extends NActiveRecord 
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function tableNAme(){
		return '{{nii_tag}}';
	}
	
	public function relations(){
		return array(
			'taglink'=>array(CActiveRecord::HAS_MANY, 'NTagLink', 'tag_id')
		);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'name'=>'string NOT NULL'
			),
			'keys'=>array(
				array('tag_key', 'name', true)
			)
		);
	}
	
	public function __toString() {
		return $this->tag;
	}
	
	
}