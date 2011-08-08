<?php

/**
 * NSprite class file.
 *
 * @author Steven OBrien <steven.obrien@newicon.net>
 * @link http://www.newicon.net/
 * @copyright Copyright &copy; 2008-2011 Newicon Ltd
 * @license http://www.yiiframework.com/license/
 */

/**
 * generate a sprite from the icon set
 * Principles of operation: (or... how to use it)
 * So you have lots of icons and images floating around. 
 * - famfamfam (http://famfamfam.com)
 * - fugue (http://p.yusukekamiyamane.com/) (https://github.com/yusukekamiyamane/fugue-icons)
 * 
 * famfamfam icon set is great and ubiquitous on the web, and comes with a few thousand 
 * icons then there is the fugue icon set which is excellent as well, this has even more.
 * I typically use a few of these icons in all my projects but usually only a handful.
 * So...
 * 
 * Goals of this class.
 * - I specify which out of a bunch of icons I use in my application
 * - This class generates a nice sprite.png file with all the images together
 * - This class generates a nice sprite.css file with all the necessary classes
 *   following the convention: .icon .name-of-icon 
 *   some notes on naming. All underscores in image names are converted to "-" 
 *   for the css classes, (can't stand "_" in css class names, is this just me?)
 *   the extension is removed. if the file is in a folder heirachy 
 *   then this is reflected in the naming, for example .icon .folder-icon-name
 * - it then, like a true gentleman, publishes them for me, using the yii asset manager
 * - if you ad more images simple delete the asset folder and next page refrsh 
 *   a new sprite will spawn into existence
 * - Bob is now your uncle.
 * 
 * @property $cssParentClass
 * @property $sprites
 * @property $iconFolderPath
 * @author Steven OBrien <steven.obrien@newicon.net>
 * @package nii
 */
Class NSprite extends CApplicationComponent
{
	
	/**
	 * This defines the parent class to use on all elements that use the icon sprite
	 * for example defining an icon to apear on an element you would write the 
	 * following: class="icon name-of-icon"
	 * 
	 * @property string 
	 */
	public $cssParentClass = 'icon';
	
	/**
	 * array of image paths relative to the NSprite::$iconFolderPath to include in the sprite, without a preceeding slash
	 * this is automatically populated if empty, by NSprite::findFiles()
	 * @property array 
	 */
	public $sprites = array();
	
	/**
	 * Stores the path to the folder where the individual images that 
	 * will be included in the spite are kept.
	 * @property string 
	 */
	public $iconFolderPath;
	
	/**
	 * array of all image data
	 * @var array
	 */
	private $_images = array();

	/**
	 * get the filepath to the components asset folder
	 * 
	 * @return string
	 */
	public function getAssetFolder(){
		return dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
	}
	
	/**
	 * get the url path to the sprite.css file
	 * 
	 * @return string 
	 */
	public function getSpriteCssFile(){
		return $this->getAssetsUrl().'/sprite.css';
	}
	
	/**
	 * gets the url to the components published assets folder
	 * if the assets folder does not exist it wil re generate the sprite
	 * and publish the assets folder
	 * 
	 * @return string 
	 */
	public function getAssetsUrl(){
		// check if we need to generate the sprite
		// if the asset folder exists we will assume we do not 
		// want to regenerate the sprite
		if(!is_file($this->getPublishedAssetsPath(false))){
			$this->generate();
		}
		$a = Yii::app()->getAssetManager();
		return $a->publish($this->getAssetFolder());
	}
	
	/**
	 * returns the file path to the published asset folder, 
	 * - if $publish is false it will not publish the asset folder
	 *   and will return the correct file path
	 * - if $publish is true then it will publish the folder
	 * 
	 * @param boolean $publish default true
	 * @return string the published asset folder file path
	 */
	public function getPublishedAssetsPath($publish=true){
		$a = Yii::app()->getAssetManager();
		if($publish)
			$a->publish($this->getAssetFolder());
		return $a->getPublishedPath($this->getAssetFolder());
	}
	
	/**
	 * Generates the sprite.png and sprite.css files and publishes
	 * them to theappropriate published assets folder
	 * 
	 * @return void
	 */
	public function generate(){
		// publish the path
		if(empty($this->sprites))
			$this->findFiles();
		$this->_generateImageData();
		$this->_generateImage();
		echo $this->_generateCss();
	}
	
	/**
	 * Generates the sprite from all the items in the NSprite::image array
	 * and publishes the sprite to the published asset folder.
	 * 
	 * @return void
	 */
	private function _generateImage(){
		$total = $this->_totalSize(); 
        $sprite = imagecreatetruecolor($total['width'], $total['height']); 
        imagesavealpha($sprite, true); 
        $transparent = imagecolorallocatealpha($sprite, 0, 0, 0, 127); 
        imagefill($sprite, 0, 0, $transparent); 
        $top = 0; 
        foreach($this->_images as $image){ 
            $img = imagecreatefrompng($image['path']); 
            imagecopy($sprite, $img, ($total['width'] - $image['width']), $top, 0, 0,  $image['width'], $image['height']); 
            $top += $image['height']; 
        }
		$fp = $this->getPublishedAssetsPath().DIRECTORY_SEPARATOR.'sprite.png';
		imagepng($sprite, $fp);
        ImageDestroy($sprite); 
	}
	
	/**
     * generates css code for all the items in the NSprite::_images array
	 * and publishes the sprite.css file into the published assets folder
	 * 
	 * @return void
     */ 
    private function _generateCss(){ 
		$total = $this->_totalSize();
		$top = $total['height']; 
		$css = '.'.$this->cssParentClass.'{background-image:url(sprite.png);}'."\n";
		foreach($this->_images as $image) 
		{ 
			$css .= '.'.$this->cssParentClass.'.'.$image['name'].' { ';
			$css .= 'background-position: '.($image['width'] - $total['width']).'px '.($top - $total['height']).'px; '; 
			$css .= 'width: '.$image['width'].'px; ';
			$css .= 'height: '.$image['height'].'px; ';
			$css .= '}'."\n";
			$top -= $image['height']; 
		} 
		$fp = $this->getPublishedAssetsPath().DIRECTORY_SEPARATOR.'sprite.css';
		file_put_contents($fp, $css);
	}
	
	/**
	 * Calculate the total size of the sprite image
	 * 
	 * @return array 
	 */
    private function _totalSize(){
		$arr = array('width' => 0, 'height' => 0); 
		foreach($this->_images as $image){ 
			if($arr['width'] < $image['width'])
				$arr['width'] = $image['width']; 
			$arr['height'] += $image['height']; 
		}
		return $arr;
    } 
	
	/**
	 * create an array with specific individual image information in
	 * populates @see NSprite::_images
	 * 
	 * @return void
	 */
	private function _generateImageData(){
		$path = $this->getIconPath();
		foreach($this->sprites as $i => $s){
			$imgPath = "$path/$s";
			if(!file_exists($imgPath))
				throw new CException("The image file's path '$imgPath' does not exist.");
			$info = getimagesize($imgPath);
			if(!is_array($info))
				throw new CException("The image '$imgPath' is not a correct image format.");
			$this->_images[$i]['path'] = $imgPath;
			$this->_images[$i]['width'] = $info[0];
			$this->_images[$i]['height'] = $info[1];
			$this->_images[$i]['mime'] = $info['mime'];
			$type = explode('/', $info['mime']);
			$this->_images[$i]['type'] = $type[1];
			// convert the relative path into the class name
			// replace slashes with dashes and remove extension from file name
			$p = pathinfo($imgPath);
			$name = str_replace(array('/','\\','_'),'-', $s);
			$this->_images[$i]['name'] = str_replace(array($p['extension'],'.'),'',$name);
		}
	}
	
	/**
	 * returns the string file path to the icons folder that holds the individual images
	 * that may be used to generate the sprite.
	 * 
	 * @return string 
	 */
	public function getIconPath(){
		if($this->iconFolderPath===null)
			$this->iconFolderPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'icons';
		return $this->iconFolderPath;
	}
	
	/**
	 * Finds all the image files within the NSprite::$iconFolderPath
	 * and populates the sprites array 
	 * @see NSprite::$sprites
	 * @return void
	 */
	public function findFiles(){
		$f = CFileHelper::findFiles($this->getIconPath(), array('fileTypes'=>array('png','gif','jpeg','jpg')));
		foreach($f as $p){
			$this->sprites[] = trim(str_replace(realpath($this->getIconPath()), '', $p),'/');
		}
	}
	
}
