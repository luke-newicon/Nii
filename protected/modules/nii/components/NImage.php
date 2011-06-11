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
	 * Default image sizes
	 * array(
	 *     'small'=>array('x'=>100,'y'=>100),
	 *     'medium'=>array('x'=>100,'y'=>100, q=>75)
	 * )
	 * @var Array
	 */
	public $thumbs = array(
		'small' => array('x' => 100, 'y' => 100),
		'medium' => array('x' => 400, 'y' => 400)
	);

	/**
	 * The default quality of new thumbnails created by the plugin.
	 * @var int
	 */
	public $defaultQuality = 75;

	/**
	 * Returns the thumbnail size options
	 * @return array
	 */
	public function getThumbSizes() {
		return $this->thumbs;
	}

	/**
	 * Returns the size settings off a thumbnail.
	 * @param int $size
	 * @return array
	 */
	public function getThumbSize($size) {
		if (!array_key_exists($size, $this->thumbs))
			throw new CException('No image thumb key sepcified for ' . $size . ' you must specify thumb keys in the main config. e.g. small=>array("x"=>100,"y"=>100) see NImage::thumbs property');

		$ret = $this->thumbs[$size];
		//Checks to ensure a x and why property is set.
		if (!isset($ret['x']) || !isset($ret['y']))
			throw new CException('no x or y lengths specified for this thumb image type');
		return $ret;
	}

	/**
	 * Displays the requested images thumbnail
	 * @param int $id the fileManager id representing the image to generate the thumb from.
	 * @param mixed $thumbType if a string it is treated as key of the
	 * $this->thumbs property array and will get thumb info.
	 * If specified as an array it assumes it contains a unique thumbs configuration
	 * see $this->thumbs property for array config. array('x'=>100,'y'=>100)
	 */
	public function showThumb($id, $thumbType) {

		$imageCacheId = $this->getThumbCacheId($id, $thumbType);

		if (!yii::app()->getCache()->get($imageCacheId)) {

			$file = Yii::app()->fileManager->getFile($id);

			// If the file cant be found then loads the default image
			if ($file === null ) {
				yii::app()->getCache()->delete($imageCacheId);
				$fileLocation = yii::app()->fileManager->getBaseLocation().$this->notFoundImage;
				$fileName = $this->notFoundImage;
			} else {
				$fileLocation = $file['file_path'];
				$fileName = $file['filed_name'];
			}

			// TODO: Check to make sure the user has permission to download the selected file.
			// The location the tempoary image should be stored in.
			$tempImageLocation = Yii::app()->getRuntimePath();
			
			$fileLocation = yii::app()->fileManager->getFilePath($file);
			$image = Yii::app()->image->load($fileLocation);
			$info = $this->getThumbSize($thumbType);

			$q = isset($info['q']) ? $info['q'] : $this->defaultQuality;
			$image->resize($info['x'], $info['y'])->quality($q);

			$image->save($tempImageLocation . $fileName);
			$imageToCache = file_get_contents($tempImageLocation . $fileName, 'r');
			yii::app()->getCache()->set($imageCacheId, $imageToCache, '6500');

			// Removes the tempoary file
			unlink($tempImageLocation . $fileName);
		}

		$data = yii::app()->getCache()->get($imageCacheId);

		$upload = Yii::app()->fileManager;
		$upload->displayFileData($data, '.png', 'image.png', false);
	}

	/**
	 * Gets the chache id for an image
	 * @param int $id The id of the image that the id should relate to
	 * @param string $imageType The size of image to display. These options are
	 * set in the main config file. Examples could be ('product','thumb')
	 * @return string The cache id of the thumbnail.
	 */
	public function getThumbCacheId($id, $thumbType) {
		$imageSize = $this->getThumbSize($thumbType);
		return 'thumb' . $id . $imageSize['x'] . $imageSize['y'];
	}
	
	/**
	 *
	 * @return NImage
	 */
	public static function get(){
		return Yii::app()->image;
	}
}