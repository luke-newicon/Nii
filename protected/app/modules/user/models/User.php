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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return ((Yii::app()->getModule('user')->isAdmin())?array(
			#array('username, password, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANED)),
			array('superuser', 'in', 'range'=>array(0,1)),
			array('username, email, superuser, status', 'required'),
			array('createtime, lastvisit, superuser, status', 'numerical', 'integerOnly'=>true),
			array('username, domain', 'safe', 'on'=>'search'),
		):((Yii::app()->user->id==$this->id)?array(
			array('username, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username, domain', 'safe', 'on'=>'search'),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'contact'=>array(self::HAS_ONE, 'CrmContact', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name'=>'Name',
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
            	'select' => 'id, username, password, email, email_verified, activekey, createtime, lastvisit, superuser, status, domain',
            ),
        );
    }
	
	public function defaultScope()
    {
        return array(
            'select' => 'id, username, email, createtime, lastvisit, superuser, status, domain',
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
		return crypt($password);
	}
	
	
	
	
	/**
	 * CANT DO IT BY OVERRIDING __set OTHERWISE FORMS END UP WITH BIG CRYPTED PASSWORDS AS THEIR VALUES
	 * ensure that everytime the password field is set it gets encrypted.
	 * 
	 * @param string $name
	 * @param mixed $value 
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
	 * called on static instance
	 * @param int $id 
	 * @param type $size 
	 */
	public function getProfileImage($id=null, $size='profile'){
		if($id!=null){
			$user = User::model()->findByPk($id);
			Yii::app()->controller->widget('nii.widgets.Gravatar',array('email'=>$user->email));
		}else{
			// Display guest photo
			Yii::app()->controller->widget('nii.widgets.Gravatar',array('email'=>''));
		}
	}
	
	public function getName($userId){
		return 'GuestEE';
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
				'name'=>'string',
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