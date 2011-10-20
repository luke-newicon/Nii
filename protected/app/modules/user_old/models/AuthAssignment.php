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
class AuthAssignment extends NActiveRecord
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
		return '{{auth_assignment}}';
	}

	public function rules() {
		return array(
			array('itemname, userid', 'required'),
			array('name', 'nameExists'),
			array('name', 'length', 'max'=>64, 'min'=>1),
			array('description', 'safe'),
			array('name, description, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	* Declares attribute labels.
	*/
	public function attributeLabels()
	{
		return array(
			'itemname'			=> 'Name',
			'bizRule'		=> 'Business rule',
			'data'			=> 'Data',
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$user = UserModule::get()->userClass;
		return array(
			'user'=>array(self::BELONGS_TO, $user, 'userid'),
			'authitem'=>array(self::BELONGS_TO, 'AuthItem', 'itemname')
		);
	}

	/**
	 * Makes sure that the authitem exists.
	 * This is the 'nameExists' validator as declared in rules().
	 */
	public function nameExists($attribute, $params)
	{
		// Make sure that an authorization item with the name does already exist
		if(Yii::app()->getAuthManager()->getAuthItem($this->name)===null )
			$this->addError('name', Yii::t('user','An item with the name ":name" does not exists.', array(':name'=>$this->name)));
	}




	public function scopes(){
		return array(
		);
	}


	public function search(){

//		$criteria = $this->getDbCriteria();
//
//		$criteria->compare('name',$this->name,true);
//		$criteria->compare('description',$this->description,true);
//
//		return new CActiveDataProvider('AuthItem', array(
//			'criteria'=>$criteria,
//		));
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}

	public function schema(){
		return array(
			'columns'=>array(
				'itemname'=>'varchar(64) not null',
				'userid'=>'varchar(64) not null',
				'bizrule'=>'text',
				'data'=>'text',
				0=>'PRIMARY KEY (itemname,userid)',
			),
//			'foreignKeys'=>array(
//				array('itemname','auth_item','name','CASCADE','CASCADE')
//			)
		);
	}

}