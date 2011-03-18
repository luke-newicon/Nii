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
class NWebUser extends CWebUser {

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
			$this->_user = User::model()->findByPk($this->getId());
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
		if($this->_contact===null){
			$this->_contact = $this->getRecord()->contact;
		}
		return $this->_contact;
	}

}