<?php
/**
 * AuthItem class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of AuthItem
 *
 * @author steve
 * @property $name;
 * @property $description;
 * @property $bizRule;
 * @property $data;
 */
class AuthItemChild extends NActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function  tableName() {
		return '{{auth_item_child}}';
	}

	public function rules() {
		return array(
			array('parent,child', 'required'),
			array('parent,child', 'length', 'max'=>64, 'min'=>1),
			array('parent,child', 'safe'),
		);
	}

	/**
	* Declares attribute labels.
	*/
	public function attributeLabels()
	{
		return array(
			'parent'			=> 'Parent',
			'child'	=> 'Child',
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}



	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'parent'=>'varchar(64) not null',
				'child'=>'varchar(64) not null',
				0=>'PRIMARY KEY (parent,child)',
			),
			'foreignKeys'=>array(
				array('parent', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE'),
				array('child', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE'),
			)
		);
	}
	


}