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
 
    private static $_models=array();            // class name => model
 
    private $_md;                               // meta data
    private $_new=false;                        // whether this instance is new or not
    private $_attributes=array();               // attribute name => attribute value
    private $_related=array();                  // attribute name => related objects
    private $_c;                                // query criteria (used by finder only)
    private $_pk;                               // old primary key value
 
    /**
     * Returns the database connection used by active record.
     * By default, the "db" application component is used as the database connection.
     * You may override this method if you want to use a different database connection.
     * @return CDbConnection the database connection used by active record.
     */
    public function getDbConnection()
    {
        if(self::$db!==null)
            return self::$db;
        else
        {
 
            // Create CDbConnection and set properties
            self::$db = new CDbConnection();
            foreach(Yii::app()->getMyDb() as $key => $value)
                self::$db->$key = $value;
 
 
        // Uncomment the following lines to prove that you have two database connections
        /*
            CVarDumper::dump(Yii::app()->db);
            echo '<br />';
            CVarDumper::dump(Yii::app()->db2);
            die;
        */
            if(self::$db instanceof CDbConnection)
            {
                self::$db->setActive(true);
                return self::$db;
            }
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
}
