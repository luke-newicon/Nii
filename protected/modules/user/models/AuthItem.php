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
 */
class AuthItem extends CFormModel
{

	public $name;
	public $description;
	public $bizRule;
	public $data;

	public function rules() {
		return array(
			array('name', 'required'),
			array('name', 'nameIsAvailable'),
			array('name', 'length', 'max'=>64, 'min'=>1),
		);
	}

	/**
	* Declares attribute labels.
	*/
	public function attributeLabels()
	{
		return array(
			'name'			=> 'Name',
			'description'	=> 'Description',
			'bizRule'		=> 'Business rule',
			'data'			=> 'Data',
		);
	}

	/**
	 * Makes sure that the name is available.
	 * This is the 'nameIsAvailable' validator as declared in rules().
	 */
	public function nameIsAvailable($attribute, $params)
	{
		// Make sure that an authorization item with the name does not already exist
		if(Yii::app()->getAuthManager()->getAuthItem($this->name)!==null )
			$this->addError('name', Yii::t('user','An item with the name ":name" already exists.', array(':name'=>$this->name)));
	}

}