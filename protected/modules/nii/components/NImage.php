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
		
		$file = Yii::app()->fileManager->getFile($id);
		
		// If the file can not be found then loads the default image
		if ($file === null ) {
			if (Yii::app()->cache !== NULL)
				Yii::app()->cache->delete($imageCacheId);
			$actions = $type ? $this->getType($type) : array();
			$fileLocation = array_key_exists('noimage', $actions) ? $actions['noimage'] : $this->notFoundImage;
		} else {
			$fileLocation = Yii::app()->fileManager->getFilePath($file);
		}
		
		if ($file === null ) {
			$actions = $type ? $this->getType($type) : array();
			$image = $this->load($fileLocation,$actions);
			$image->render();
		} else {
			if (Yii::app()->cache !== NULL){
				$cachedImage = Yii::app()->cache->get($imageCacheId);
				if (!$cachedImage) {
					// TODO: Check to make sure the user has permission to download the selected file.
					// Make the thumb image and save
					$actions = $type ? $this->getType($type) : array();
					$image = $this->load($fileLocation,$actions);
					$imageContents = $image->generate();
					// Cache contents
					Yii::app()->cache->set($imageCacheId, $imageContents, '6500');
				} else {
					$imageContents = $cachedImage;
				}
			} else {
				$imageContents = file_get_contents($fileLocation);
			}

			Yii::app()->fileManager->displayFileData($imageContents, $file->mime, $file->original_name);
		}
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