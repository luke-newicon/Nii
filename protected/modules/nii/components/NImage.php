<?php
Yii::import('nii.extensions.image.CImageComponent');

/**
 * Nii Image related goodness such as resizing.
 * @author matthewturner
 * @version 1.0
 */
class NImage extends CImageComponent 
{

	// The location of the not found image
	public $notFoundImage;

	/**
	 * Default image types
	 * keys refer to image functions,
	 * resize,
	 * crop,
	 * height,
	 * width,
	 * scale,
	 * master the master dimension (none,min,max,width,height)
	 * scale,
	 * flip (horizontal, vertical)
	 * rotate 
	 * array(
	 *     'thumb' => array(
	 * 			'resize' => array(
	 *				'width'=>100, 
	 *				'height'=>100, 
	 *              // the master dimension i.e. none,min,max,width,height (min will resize by the smallest dimension, 
	 *              // max by the largest, none will resize the image without maintaining aspect ratio to the dimensions)
	 *				'master'=>'Image::MIN',
	 *				'scale'=>'down'),
	 *		),
	 *		'small' => array(
	 *			'resize' => array('width'=>150, 'height'=>150, 'master'=>Image::MIN, 'scale'=>'down'),
	 *		),
	 *		'medium' => array(
	 *			'resize' => array('width'=>400, 'height'=>400, 'master'=>Image::MIN, 'scale'=>'down'),
	 *		),
	 *		'large' => array(
	 *			'resize' => array('width'=>800, 'height'=>800, 'master'=>Image::MIN, 'scale'=>'up'),
	 *		),
	 * )
	 * @var Array
	 */
	public $types;

	public function init()
    {
        parent::init();
		$defaultTypes = array(
			'thumb' => array(
				'resize' => array('width'=>100, 'height'=>100, 'master'=>Image::MIN, 'scale'=>'down'),
			),
			'small' => array(
				'resize' => array('width'=>150, 'height'=>150, 'master'=>Image::MIN, 'scale'=>'down'),
			),
			'medium' => array(
				'resize' => array('width'=>400, 'height'=>400, 'master'=>Image::MIN, 'scale'=>'down'),
			),
			'large' => array(
				'resize' => array('width'=>800, 'height'=>800, 'master'=>Image::MIN, 'scale'=>'up'),
			),
		);
        $this->types = CMap::mergeArray($defaultTypes, $this->types);
    }
	
	
	public function addType($name, $array){
		if(array_key_exists($name, $this->types))
			throw new CException("The key '$name' already exists in the type definition. ");
		$this->types[$name] = $array;
	}

	/**
	 * Returns the image type settings.
	 * 
	 * @param int $type
	 * @return array
	 */
	public function getType($type) {
		
		if (is_string($type) && !array_key_exists($type, $this->types))
			throw new CException('No image type key sepcified for ' . $type . ' you must specify type keys in the main config. e.g. "small"=>array("resize"=>array("width"=>100,"height"=>100,"master"=>"min","scale"=>"down")) see NImage::types property');
		
		$ret = is_array($type) ? $type : $this->types[$type];
		
		return $ret;
	}

	/**
	 * Displays the requested images thumbnail from filemanager file
	 * 
	 * @param int $id the fileManager id representing the image to generate the thumb from.
	 * @param string $type name of the type as defined in config @see self::types
	 */
	public function show($id, $type=null) {
		
		$imageCacheId = $this->getCacheId($id,$type);
		
		// if cache is enabled WHICH IT SHOULD BE! lets check for chache
		if (Yii::app()->cache !== NULL){
			if(($cachedImage = Yii::app()->cache->get($imageCacheId))){
				Yii::app()->fileManager->displayFileData($cachedImage['img'], $cachedImage['mime'], $cachedImage['original_name']);
				return;
			}
		}
		
		// no chache so lets crunch		
		$file = Yii::app()->fileManager->getFile($id);
		
		// If the file can not be found then loads the default image
		if ($file === null ) {
			$actions = $type ? $this->getType($type) : array();
			$fileLocation = array_key_exists('noimage', $actions) ? $actions['noimage'] : $this->notFoundImage;
			$actions = $type ? $this->getType($type) : array();
			$image = $this->load($fileLocation,$actions);
			$image->render();
			return;
		}
		
		
		// file exists in file manager
		$fileLocation = Yii::app()->fileManager->getFilePath($file);
		
		// Make the thumb image and save
		$actions = $type ? $this->getType($type) : array();
		$image = $this->load($fileLocation,$actions);
		$imageContents = $image->generate();
		// Cache contents
		$cache = array('img'=>$imageContents,'mime'=>$file->mime, 'original_name'=>$file->original_name);
		if (Yii::app()->cache !== NULL){
			Yii::app()->cache->set($imageCacheId, $cache, '6500');
		} 

		Yii::app()->fileManager->displayFileData($cache['img'], $file['mime'], $file['original_name']);
	}

	/**
	 * Gets the cache id for an image
	 * 
	 * @param int $id The id of the image that the id should relate to
	 * @param string $type The type of image to display. These options are
	 * set in the main config file. Examples could be ('product','thumb')
	 * @return string The cache id of the thumbnail.
	 */
	public function getCacheId($id, $type=null) {
		if($type)
			return $id.'-'.$type;
		else
			return $id;
	}
	
	/**
	 * Get the url to call to display the image or use as an img tag src attribute
	 * 
	 * @param int $id filemanagers NFile id
	 * @param string $type type key name
	 * @return string url 
	 */
	public function url($id,$type=null){
		if($type)
			return NHtml::url(array('/nii/index/show', 'id'=>$id, 'type'=>$type));
		else
			return NHtml::url(array('/nii/index/show','id'=>$id));
	}
	
	/**
	 * @return NImage
	 */
	public static function get($id=null,$actions=array()){
		$i = Yii::app()->image;
		if($id!==null){
			$f = NFileManager::get()->getFile($id);
			return $i->load(NFileManager::get()->getFilePath($f),$actions);
		}
		return $i;
	}
}