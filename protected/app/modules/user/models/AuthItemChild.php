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
 * Description of AuthItemChild
 *
 * @property $parent;
 * @property $child;
 */
class AuthItemChild extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{auth_item_child}}';
	}

	public function rules() {
		return array(
			array('parent,child', 'required'),
			array('parent,child', 'length', 'max' => 64, 'min' => 1),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'parent' => 'Parent',
			'child' => 'Child',
		);
	}

	public static function install($className=__CLASS__) {
		parent::install($className);
	}

	public function schema() {
		return array(
			'columns' => array(
				'parent' => 'varchar(64) not null',
				'child' => 'varchar(64) not null',
				0 => 'PRIMARY KEY (parent,child)',
			),
			'foreignKeys' => array(
				array('parent', 'parent', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE'),
				array('child', 'child', '{{auth_item}}', 'name', 'CASCADE', 'CASCADE'),
			)
		);
	}

}