<?php
/**
 * NSettings
 * 
 * Based on http://www.yiiframework.com/extension/settings/
 *  
 * @package nii 
 * @author steve obrien <steve@newicon.net> credit: twisted1919 (cristian.serban@onetwist.com)
 * @copyright OneTwist CMS (www.onetwist.com)
 * @access public
 *
 * 1.1e - Special thanks to Gustavo (http://www.yiiframework.com/forum/index.php?/user/6112-gustavo/)
 */
class NSettings extends CApplicationComponent
{

    public $saveItemsToDatabase=array();
    public $deleteItemsFromDatabase=array();
    public $deleteCategoriesFromDatabase=array();
    public $cacheNeedsFlush=array();
    
    public $items=array();
    public $loaded=array();

	public $cacheComponentId='cache';
    public $cacheId='global_website_settings';
    public $cacheTime=84000;

	public $dbComponentId='db';
	protected $_tableName='{{nii_settings}}';
	public $dbEngine='InnoDB';
	
    public function init()
    {
        parent::init();
        Yii::app()->attachEventHandler('onEndRequest', array($this, 'whenRequestEnds'));
    }


    /**
     * NSettings::set()
     * 
     * @param string $category name of the category 
     * @param mixed $key 
     * can be either a single item (string) or an array of item=>value pairs 
     * @param mixed $value value to set for the key, leave this empty if $key is an array
     * @param bool $toDatabase whether to save the items to the database
     * @return CmsSettings
     */
    public function set($key='', $value='', $category='system', $toDatabase=true)
    { 
        if(is_array($key))
        {
            foreach($key AS $k=>$v)
                $this->set($k, $v, $category, $toDatabase);
        }
        else
        {
            if($toDatabase)
            {
                if(isset($this->saveItemsToDatabase[$category])&&is_array($this->saveItemsToDatabase[$category]))
                    $this->saveItemsToDatabase[$category]=array_merge($this->saveItemsToDatabase[$category], array($key=>$value));
                else
                    $this->saveItemsToDatabase[$category]=array($key=>$value);
            }
            if(isset($this->items[$category])&&is_array($this->items[$category]))
                $this->items[$category]=array_merge($this->items[$category], array($key=>$value));
            else
                $this->items[$category]=array($key=>$value); 
        }
        return $this;   
    }

    /**
     * NSettings::get()
     * 
     * @param string $category name of the category
     * @param mixed $key 
     * can be either :
     * empty, returning all items of the selected category
     * a string, meaning a single key will be returned
     * an array, returning an array of key=>value pairs  
     * @param string $default the default value to be returned
     * @return mixed
     */
    public function get($key='', $category='system', $default=null)
    {
        if(!isset($this->loaded[$category]))
            $this->load($category);

		if(empty($key)&&empty($default)&&!empty($category))
            return isset($this->items[$category])?$this->items[$category]:null;

        if(!empty($key)&&is_array($key))
        {
            $toReturn=array();
			foreach($key AS $k=>$v)
            {
				if(is_numeric($k))
					$toReturn[$v]=$this->get($k, $category);
                else
                    $toReturn[$k]=$this->get($k, $category, $v);
			}
			return $toReturn;
        }
        
        if(isset($this->items[$category][$key]))
            return $this->items[$category][$key];
        return $default;
    }

    /**
     * Delete an item or all items from a category
     * 
     * @param string $category the name of the category 
     * @param mixed $key 
     * can be either:
     * empty, meaning it will delete all items of the selected category 
     * a single key
     * an array of keys
     * @return CmsSettings
     */
    public function delete($key='', $category)
    {
        if(empty($category))
            return $this;
        
        if(!empty($category)&&empty($key))
        {
            $this->deleteCategoriesFromDatabase[]=$category;
            if(isset($this->items[$category]))
                unset($this->items[$category]);
            return;
        }
        if(is_array($key))
        {
            foreach($key AS $k)
                $this->delete($category, $k);
        }
        else
        {
            if(isset($this->items[$category][$key]))
            {
                unset($this->items[$category][$key]);
                if(empty($this->deleteItemsFromDatabase[$category]))
                    $this->deleteItemsFromDatabase[$category]=array();
                $this->deleteItemsFromDatabase[$category][]=$key;
            }    
        }
        return $this;
    }

    /**
     * load from database the items of the specified category
     * 
     * @param string $category
     * @return array the items of the category
     */
    public function load($category)
    {        
        $items=$this->getCacheComponent()->get($category.'_'.$this->cacheId);
        $this->loaded[$category]=true;
        
        if(!$items)
        {
            $connection=$this->getDbComponent();
            $command=$connection->createCommand('SELECT `key`, `value` FROM '.$this->getTableName().' WHERE category=:cat');
            $command->bindParam(':cat', $category);
            $result=$command->queryAll();
            
            if(empty($result))
                return;

            $items=array();
            foreach($result AS $row)
                $items[$row['key']] = @unserialize($row['value']);
            $this->getCacheComponent()->add($category.'_'.$this->cacheId, $items, $this->cacheTime); 
        }

        if(isset($this->items[$category]))
            $items=array_merge($items, $this->items[$category]);
        
        $this->set($items, null, $category, false); 
        return $items;
    }
    
    public function toArray()
    {
        return $this->items;
    }


	

	/**
	 * @param $name string the name of the settings database table, defaults to '{{settings}}'
	 */
	public function setTableName($name)
	{
		if(strpos($name, '{{')!=0||strpos($name, '}}')!=(strlen($name)-2))
			throw new CException('The table name must be like "{{'.$name.'}}" not just "'.$name.'"');
		$this->_tableName=$name;
	}
	
	/**
	 * @return string the name of the settings database table, defaults to '{{settings}}'
	 */
	public function getTableName()
	{
		return $this->_tableName;
	}
		

	/**
	 * @return CCache the cache component
	 */
	protected function getCacheComponent()
    {
        return Yii::app()->getComponent($this->cacheComponentId);
    }
	
	/**
	 * @return CDbConnection the db connection component
	 */
	protected function getDbComponent()
	{
        return Yii::app()->getComponent($this->dbComponentId);
    }

    protected function addDbItem($category='system', $key, $value)
    {
        $connection=$this->getDbComponent();
        $command=$connection->createCommand('SELECT id FROM '.$this->getTableName().' WHERE `category`=:cat AND `key`=:key LIMIT 1');
        $command->bindParam(':cat', $category);
        $command->bindParam(':key', $key);
        $result=$command->queryRow();
        $value=@serialize($value);
        
        if(!empty($result))
            $command=$connection->createCommand('UPDATE '.$this->getTableName().' SET `value`=:value WHERE `category`=:cat AND `key`=:key');
        else
            $command=$connection->createCommand('INSERT INTO '.$this->getTableName().' (`category`,`key`,`value`) VALUES(:cat,:key,:value)');

        $command->bindParam(':cat', $category);
        $command->bindParam(':key', $key);
        $command->bindParam(':value', $value);
        $command->execute();
    }

    protected function whenRequestEnds()
    {
        $this->cacheNeedsFlush=array();
        
        if(count($this->deleteCategoriesFromDatabase)>0)
        {
            foreach($this->deleteCategoriesFromDatabase AS $catName)
            {
                $connection=$this->getDbComponent();
                $command=$connection->createCommand('DELETE FROM '.$this->getTableName().' WHERE `category`=:cat');
                $command->bindParam(':cat', $catName);
                $command->execute();
                $this->cacheNeedsFlush[]=$catName;
                
                if(isset($this->deleteItemsFromDatabase[$catName]))
                    unset($this->deleteItemsFromDatabase[$catName]);
                if(isset($this->saveItemsToDatabase[$catName]))
                    unset($this->saveItemsToDatabase[$catName]);
            }
        }
        
        if(count($this->deleteItemsFromDatabase)>0)
        {
            foreach($this->deleteItemsFromDatabase AS $catName=>$keys)
            {
                $params=array();
                $i=0;
                foreach($keys AS $v)
                {
                    if(isset($this->saveItemsToDatabase[$catName][$v]))
                        unset($this->saveItemsToDatabase[$catName][$v]);
                    $params[':p'.$i]=$v; 
                    ++$i;
                }
                $names=implode(',', array_keys($params));
                
                $connection=$this->getDbComponent();
                $query='DELETE FROM '.$this->getTableName().' WHERE `category`=:cat AND `key` IN('.$names.')';
                $command=$connection->createCommand($query);
                $command->bindParam(':cat', $catName);
                
                foreach($params AS $key=>$value)
                    $command->bindParam($key, $value);
                
                $command->execute();
                $this->cacheNeedsFlush[]=$catName;
            }
        }
        
        if(count($this->saveItemsToDatabase)>0)
        {
            foreach($this->saveItemsToDatabase AS $catName=>$keyValues)
            {
                foreach($keyValues AS $k=>$v)
                    $this->addDbItem($catName, $k, $v);
                $this->cacheNeedsFlush[]=$catName;
            }   
        }
        
        if(count($this->cacheNeedsFlush)>0)
        {
            foreach($this->cacheNeedsFlush AS $catName)
                $this->getCacheComponent()->delete($catName.'_'.$this->cacheId);
        }   
    }
	

	/**
	 * create the settings table
	 */
	protected function createTable()
	{
		$connection=$this->getDbComponent();
		$tableName=$connection->tablePrefix.str_replace(array('{{','}}'), '', $this->getTableName());
		$sql='CREATE TABLE IF NOT EXISTS `'.$tableName.'` (
		  `id` int(11) NOT NULL auto_increment,
		  `category` varchar(64) NOT NULL default "system",
		  `key` varchar(255) NOT NULL,
		  `value` text NOT NULL,
		  PRIMARY KEY  (`id`),
		  KEY `category_key` (`category`,`key`)
		) '.($this->dbEngine ? 'ENGINE='.$this->dbEngine : '').'  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; ';
        $command=$connection->createCommand($sql);
        $command->execute();
	}
	
	public static function install(){
		$s = new NSettings;
		$s->createTable();
	}
	
    
}