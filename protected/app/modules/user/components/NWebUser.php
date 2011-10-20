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

	/**
	 * Store the NActiveRecor User model object
	 * @var NActiveRecord
	 */
	private $_user;
	
	
	public function init(){
		parent::init();
	}
	
	
	protected function afterLogin($fromCookie){
		// sometimes the user has not been defined (often when restoring from cookie
		// to catch this we just manually force it if it aint defined
		if(!Yii::app()->user)
			Yii::app()->user = $this;
		
		if($this->record === null){
			// something went badly wrong as we cant find the logged in users record
			throw new CException('Unable to retrieve the logged in users\'s db record');
		}
		
		$this->record->lastvisit = time();
		// record the number of times the user has logged in;
		$this->record->logins = $this->record->logins + 1;
		
		$this->record->save();
		// set message so the system can determin when a user has just logged in
		$this->setJustLoggedIn();
	}
	
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
	 * is the user a superuser? i.e. have the superuser database table row column superuser set to 1.
	 * @return boolean 
	 */
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
	 * @return string 
	 */
	public function getName(){
		$name = parent::getName();
		// if the name is an email address return the first part
		if($this->record !== null && $this->record->first_name != ''){
			return $this->record->first_name . ' ' . $this->record->last_name;
		}
		if (($pos = strpos($name,"@"))) {
			$name = strtok($name,'@');
		}
		return $name;
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
	
	public function getImageUrl($imageSize=40){
		return Yii::app()->getController()->createWidget('nii.widgets.Gravatar', array(
			'email'=>$this->getEmail(),
			'size'=>$imageSize
				
		))->getUrl();
	}
	
	
	/**
	 * This function returns true if the user has arived at the current page
	 * from logging in.
	 * This is useful for displaying logged in welcome messages or help boxes
	 */
	public function hasJustLoggedIn(){
		return Yii::app()->user->hasFlash('justloggedin');
	}
	
	/**
	 * stores a variable in the session identifying that the user has just logged in
	 * @see self::hasJustLoggedIn
	 */
	public function setJustLoggedIn(){
		if(Yii::app()->user)
			Yii::app()->user->setFlash('justloggedin','');
	}
	
	/**
	 * 
	 * @return UserSettings
	 */
	public function getSettings(){
		return UserSettings::getInstance();
	}
	
}
