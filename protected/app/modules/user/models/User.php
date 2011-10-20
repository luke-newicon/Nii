<?php
/**
 * 
 * The following are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password 
 * @property string $email
 * @property string $activekey
 * @property integer $createtime
 * @property integer $lastvisit
 * @property integer $superuser
 * @property integer $status
 */
class User extends NActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANED=-1;


	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		
		// if you are not an admin, and you are not editing your own details, you get no rules!
		if(!Yii::app()->getModule('user')->isAdmin() && (Yii::app()->user->id != $this->id))
			return array();
		
		
		// things we can always do
		$rules = array(
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('username', 'unique', 'message' => UserModule::t("This username already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'unique', 'message' => UserModule::t("This email address already exists.")),
			array('username, domain', 'safe', 'on'=>'search'),
			array('first_name, last_name, company, plan, trial, trial_ends_at, logins', 'safe'),
		);
		
		
		// rules for mass assignment when a user is editing their own details
		if(Yii::app()->user->id == $this->id){
			$rules = array_merge($rules, array(
				array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
				array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			));
		}
		
		// if the user is an admin user they are able make users super users and change passwords.
		if (Yii::app()->getModule('user')->isAdmin()){
			$rules = array_merge($rules, array(
				array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
				array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
				array('superuser', 'in', 'range'=>array(0,1)),
				array('createtime, lastvisit, superuser, status', 'numerical', 'integerOnly'=>true),
			));
		}
		
		return $rules;
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'first_name'=>'First Name',
			'last_name'=>'Last Name',
			'company'=>'Company',
			'username'=>UserModule::t("Username"),
			'password'=>UserModule::t("Password"),
			'verifyPassword'=>UserModule::t("Password, again!"),
			'email'=>UserModule::t("E-mail Address"),
			'email_verified' => UserModule::t("Email Verified"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'id' => UserModule::t("Id"),
			'activekey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'lastvisit' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactvie'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, first_name, last_name, company, password, email, email_verified, activekey, createtime, lastvisit, superuser, status, domain, plan, logins',
            ),
        );
    }
	
	public function defaultScope()
    {
        return array(
            'select' => 'id, first_name, last_name, company, username, email, createtime, lastvisit, superuser, status, domain, plan, trial, trial_ends_at, logins',
        );
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}

	/**
	 *
	 * @param string $password
	 * @return boolean
	 */
	public function checkPassword($checkPass){
		// uses a salt so that two people with the same password will have
		// different encrypted password values
		// creates a unique salt from each password
		return (UserModule::checkPassword($this->password, $checkPass));
	}


	public function cryptPassword($password){
		return UserModule::passwordCrypt($password);
	}
	

	/**
	 * Before save will ensure new users have their password fields encrypted.
	 * 
	 * NOTE: when updating a user you must encrypt the password manually
	 * 
	 * @return type 
	 */
	public function  beforeSave() {
		if ($this->getScenario()=='insert'){
			$this->password = $this->cryptPassword($this->password);
			$this->activekey = $this->cryptPassword(microtime().$this->password);
			$this->createtime=time();
		}
		$this->lastvisit=time();
		return parent::beforeSave();
	}
	
	/**
	 * Retrieves the list of Users based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed users.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('username',$this->username,true);
		$user = UserModule::get()->userClass;
		return new CActiveDataProvider($user, array(
			'criteria'=>$criteria,
		));
	}
	

	public static function getCurrentUser(){
		return UserModule::userModel()->findByPk(Yii::app()->user->getId());
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema() {
		return array(
			'columns'=>array(
				'id'=>'pk',
				'first_name'=>'string',
				'last_name'=>'string',
				'company'=>'string',
				'username'=>'string',
				'password'=>'string NOT NULL',
				'email'=>'string NOT NULL',
				'email_verified'=>'boolean NOT NULL DEFAULT 0',
				'activekey'=>'string NOT NULL',
				'createtime'=>'int',
				'lastvisit'=>'int',
				'superuser'=>'boolean NOT NULL DEFAULT 0',
				'status'=>'boolean NOT NULL DEFAULT 0',
				'domain'=>'string',
				'plan'=>'string',
				'trial_ends_at'=>'datetime',
				'trial'=>'boolean NOT NULL DEFAULT 1',
				'logins'=>'int'
			),
			'keys'=>array(
				array('username', 'username', true),
				array('email', 'email', true),
				array('status'),
				array('superuser'),
				array('domain')
			)
		);
	}


}