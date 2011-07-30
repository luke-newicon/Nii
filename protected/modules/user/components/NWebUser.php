<?php

/**
 * NWebUser class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NWebUser
 *
 * @author steve
 */
class NWebUser extends CWebUser 
{

	private $_user;
	
	private $_contact;
	
	
	/**
	 * gets the User class activerecord representing the currently logged in user.
	 * If no user is logged in then this function will return null
	 * @return User | null 
	 */
	public function getRecord() {
		if($this->getId() === null)
			return null;
		if($this->_user === null){
			$this->_user = UserModule::userModel()->findByPk($this->getId());
		}
		return $this->_user;
	}
	
	/**
	 * returns the related contact CrmContact record if it exists, or null if it does not.
	 * 
	 * @return CrmContact | null
	 */
	public function getContact(){
		if($this->getRecord() === null)
			return null;
		if(UserModule::get()->useCrm && $this->_contact===null){
			$this->_contact = $this->getRecord()->contact;
		}
		return $this->_contact;
	}
	
	
	
	
	public function isSuper(){
		return ($this->record ===null)?false:$this->record->superuser;
	}
	
	/**
	 * overrides default behaviour to always return true if user has super powers
	 * i.e. is a superuser
	 * @see CWebUser::checkAccess
	 * @param type $operation
	 * @param type $params
	 * @param type $allowCaching 
	 */
	public function checkAccess($operation, $params = array(), $allowCaching = true) 
	{
		if ($this->record==null)
			return false;
		if($this->record->superuser)
			return true;
		return parent::checkAccess($operation, $params, $allowCaching);
	}
	
	public function checkAccessToRoute(){
		$route = Yii::app()->controller->getRoute();
		return Yii::app()->user->checkAccess($route);	
	}

	/**
	 * Finds the most suitable representation for the users name
	 * Often users may not have all fields so finds one that is not empty.
	 * 
	 * first it checks to see if there is a related crm contact record.
	 * if there is it uses first and last name
	 * if there is not it uses the default user table, if no username is supplied uses the email
	 * @return type 
	 */
	public function getName(){
		if($this->record !== null){
		}
		return parent::getName();
	}
	
	/**
	 * get the current users email address
	 */
	public function getEmail(){
		if($this->record !== null){
			return $this->record->email;
		}
			
		return $this->username;
		
	}
	
	
	/**
	 * To be sure the domain is secure lets do one final 
	 * check before ever allowing someone to log in
	 */
	public function login($identity,$duration=0){
		if(UserModule::get()->domain){
			if($identity->getUser()->domain == Yii::app()->getSubDomain()){
				parent::login($identity,$duration);
			}
		}else{
			parent::login($identity,$duration);
		}
	}

}
