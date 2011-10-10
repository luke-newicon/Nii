<?php

/**
 * NWidget class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of NWidget
 *
 * @author steve
 */
class NWidget extends CWidget 
{
	
	/**
	 * stores the widget.assets url
	 * @var type 
	 */
	private $_assetsUrl;
	
	
	/**
	 * This function assumes the assets folder is in the same directory as this file
	 * i.e:
	 * /
	 * -- assets/
	 * -- NWidget
	 * @return string url to assets folder 
	 */
	public function getAssetsUrl($assetsFolder='assets'){
		
		
		if($this->_assetsUrl===null){
			$assetsPath = dirname(__FILE__).DS.$assetsFolder;
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish($aliasPathToAssets);
		}
			
		return $this->_assetsUrl;
	}
	
	
	
}