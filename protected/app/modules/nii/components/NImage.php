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
	 * processes the image
	 * 
	 * @return array of image data
	 * image => the binary resized image data for the thumbnail
	 * filepath => the fileath of the NFile as returned by the file manager
	 * mime => the mime type of the file
	 */
	public function process($id, $type){
			
		$imageCacheId = $this->getCacheId($id, $type);
		
		if (($image = Yii::app()->cache->get($imageCacheId)) === false) {
		
			$file = $this->getFile($id);

			// If the file can not be found then loads the default image
			if ($file === null ) {
				
				$mimeType = null;
				$actions = $type ? $this->getType($type) : array();
				$fileLocation = array_key_exists('noimage', $actions) ? $actions['noimage'] : $this->notFoundImage;
				$actions = $type ? $this->getType($type) : array();
				$image = $this->load($fileLocation,$actions);
				
			} else {
				$mimeType = $file->mime;
				// file exists in file manager
				$fileLocation = Yii::app()->fileManager->getFilePath($file);
				// Make the thumb image and save
				$actions = $type ? $this->getType($type) : array();
				try {
					$image = $this->load($fileLocation,$actions);
				} catch(CException $e){
					// if debug mode lets throw the error
					if(YII_DEBUG)
						throw new CException($e->getMessage());
					// otherwise display a nice alert error image
					$errorImg = Yii::getPathOfAlias('nii.extensions.image.alert').'.png';
					// make image fit
					if(array_key_exists('resize',$actions))
						$actions['resize']['master']='max';
					$image = $this->load($errorImg,$actions);
				}
			}
			
			$image = array(
				'image'=>$image->generate(),
				'filepath'=>$fileLocation,
				'mime'=>$mimeType
			);
			Yii::app()->cache->set($imageCacheId, $image);
		}
		
		return $image;
	}

	/**
	 * Displays the requested images thumbnail from filemanager file
	 * 
	 * @param int $id the fileManager id representing the image to generate the thumb from.
	 * @param string $type name of the type as defined in config @see self::types
	 */
	public function show($id, $type=null) {
		$image = $this->process($id, $type);
		Yii::app()->fileManager->sendFile($image['filepath'], $image['mime'], $image['image']);
	}
	
	/**
	 * get the file manager file for the file id
	 * @param int $id
	 * @return NFile 
	 */
	public function getFile($id){
		// TODO add caching here
		return Yii::app()->fileManager->getFile($id);
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
			$url = NHtml::url(array('/nii/index/show', 'id'=>$id, 'type'=>$type));
		else
			$url = NHtml::url(array('/nii/index/show','id'=>$id, 'type'=>''));
		return $url;
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