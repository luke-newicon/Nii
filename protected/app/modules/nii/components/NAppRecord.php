<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NAppRecord
 *
 * @author steve
 */
class NAppRecord extends NActiveRecord
{
	/**
     * @var CDbConnection the default database connection for all active record classes.
     * By default, this is the 'db' application component.
     * @see getDbConnection
     */
    public static $db;
 
    /**
     * Returns the database connection used by active record.
     * By default, the "db" application component is used as the database connection.
     * If the self::$db is null then it ses the database to the connection returned by Nii::getMyDb();
     * @return CDbConnection the database connection used by active record.
     */
    public function getDbConnection()
    {
        if(self::$db!==null)
            return self::$db;
        else {
			self::$db = Yii::app()->getSubDomainDb();

            if(self::$db instanceof CDbConnection) {
                self::$db->setActive(true);
                return self::$db;
            } else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
}
