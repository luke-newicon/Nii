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
class AuthItem extends NActiveRecord
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
		return '{{auth_item}}';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('name', 'nameIsAvailable'),
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
			'name'			=> 'Name',
			'description'	=> 'Description',
			'bizRule'		=> 'Business rule',
			'data'			=> 'Data',
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




	public function scopes(){
		return array(
			'roles'=>array('condition'=>'type='.CAuthItem::TYPE_ROLE),
			'tasks'=>array('condition'=>'type='.CAuthItem::TYPE_TASK),
			'operations'=>array('condition'=>'type='.CAuthItem::TYPE_OPERATION),
		);
	}


	public function search(){

		$criteria = $this->getDbCriteria();

		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider('AuthItem', array(
			'criteria'=>$criteria,
		));
	}



	/**
	 * return the heirarchy of all auth items excluding roles
	 * @param $role CAuthItem a role to compare all permissions to.  Will add checked to permissions existing on the role
	 */
	public function getPermissionsTreeData(CAuthItem $role=null){
		$auth = Yii::app()->getAuthManager();
		$items = $auth->getAuthItems(CAuthItem::TYPE_TASK);
		//$a = $auth->getAuthItem($name);

		$curPerms = array();
		if($role!==null)
			$curPerms = $role->getChildren();

		$perms = array();
		foreach($items as $r){
			$arr = &$perms[];
			$arr = $this->getTreeItem($r, $curPerms);
			foreach($r->getChildren() as $r){
				$arr['children'][] = $this->getTreeItem($r, $curPerms);
			}
		}
		return $perms;
	}

	public function getTreeItem($authitem, $curPerms){
		return array(
			'data'=>$authitem->name,
			'attr'=>array('id'=>$authitem->name),
			'state'=> array_key_exists($authitem->name, $curPerms)?'checked':''
		);
	}

}