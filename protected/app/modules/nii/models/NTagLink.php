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
class NTagLink extends NActiveRecord 
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{nii_tag_link}}';
	}
	
	public function relations(){
		return array(
			'tag'=>array(CActiveRecord::BELONGS_TO, 'NTag', 'tag_id')
		);
	}
	
	/**
	 * Gets the model record that the row represnts
	 * @return NActiveRecord
	 */
	public function record(){
		return NActiveRecord::model($this->model)->findByPk($this->model_id);
	}
	

	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'tag_id'=>'int',
				'model'=>'string',
				'model_id'=>'int'
			)
		);
	}
	
	
}