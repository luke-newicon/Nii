<?php

/**
 *
 */
class UploadifyWidget extends CInputWidget {

	/**
	 * The id used for the uploader
	 * @var string
	 */
	public $ID = 'fileUpload';
	/**
	 * Automatically upload files as they are added to the queue.
	 * @var string
	 */
	public $auto = true;
	/**
	 * The path to an image you would like to use as the browse button.
	 * @var string
	 */
	public $buttonImg;
	/**
	 * The text that appears on the default button.
	 * @var string
	 */
	public $buttonText;
	/**
	 * The path to an image you would like to use as the cancel button.
	 * @var string
	 */
	public $cancelImg;
	/**
	 * The path to the back-end script that checks for pre-existing files on the server.
	 * @var string
	 */
	public $checkScript;
	/**
	 * The type of data to display in the queue item during an upload.
	 * @var string
	 */
	public $displayData;
	/**
	 * The path to the expressInstall.swf file.
	 * @var string
	 */
	public $expressInstall;
	/**
	 * The name of your files array in the back-end script.
	 * @var string
	 */
	public $fileDataName;
	/**
	 * The text that will appear in the file type drop down at the bottom of the browse dialog box.
	 * @var string
	 */
	public $fileDesc;
	/**
	 * A list of file extensions that are allowed for upload.
	 * @var string
	 */
	public $fileExt = '*.jpg;*.jpeg;*.gif;*.png';
	/**
	 * The path to the folder where you want to save the files.
	 * @var string
	 */
	public $folder;
	/**
	 * The height of the browse button.
	 * @var int
	 */
	public $height;
	/**
	 * Enable to hide the flash button so you can style the underlying DIV element.
	 * @var boolean
	 */
	public $hideButton;
	/**
	 * The form method for sending scriptData to the back-end script.
	 * @var string
	 */
	public $method;
	/**
	 * Allow multiple file uploads.
	 * @var boolean
	 */
	public $multi;
	/**
	 * The ID of the element on the page you want to use as your file queue.
	 * @var string
	 */
	public $queueID;
	/**
	 * The limit of files that can be in the queue at one time.
	 * @var int
	 */
	public $queueSizeLimit;
	/**
	 * Enable automatic removal of the queue item for completed uploads.
	 * @var boolean
	 */
	public $removeCompleted;
	/**
	 * Enable to activate rollover states for your browse button.
	 * @var boolean
	 */
	public $rollover;
	/**
	 * Normally this is not used and the route variable should be used instead.
	 * The path to the back-end script that will process the file uploads.
	 * When used the route will be passed as a post variable 'route'.
	 * @var string
	 */
	public $script;
	/**
	 * The access mode for scripts in the main swf file.
	 * @var string
	 */
	public $scriptAccess;
	/**
	 * An object containing name/value pairs with additional information that should be sent to the back-end script when processing a file upload.
	 * @var array
	 */
	public $scriptData;
	/**
	 * The limit of uploads that can run simultaneously per Uploadify instance.
	 * @var int
	 */
	public $simUploadLimit;
	/**
	 * The size limit in bytes for each file upload.
	 * @var int
	 */
	public $sizeLimit;
	/**
	 * The path to the uploadify.swf file.
	 * @var string
	 */
	public $uploader;
	/**
	 * The width of the browse button.
	 * @var int
	 */
	public $width;
	/**
	 * The wmode of the flash file.
	 * @var string
	 */
	public $wmode;
	/**
	 * Triggers once when all files in the queue have finished uploading.(function)
	 * @var string
	 */
	public $onAllComplete;
	/**
	 * Triggers once for each file that is removed from the queue.(function)
	 * @var string
	 */
	public $onCancel;
	/**
	 * Triggers at the beginning of an upload if a file with the same name is detected.(function)
	 * @var string
	 */
	public $onCheck;
	/**
	 * Triggers once when the uploadifyClearQueue() method is called.(function)
	 * @var string
	 */
	public $onClearQueue;
	/**
	 * Triggers once for each file upload that is completed.(function)
	 * 
	 * Example:
	 * function(event, queueID, fileObj, response, data) {
	 *		alert(response);
	 * }
	 * @var string
	 */
	public $onComplete;
	/**
	 * Triggers when an error is returned for a file upload.(function)
	 * @var string
	 */
	public $onError;
	/**
	 * Triggers when the Uploadify instance is loaded.(function)
	 * @var string
	 */
	public $onInit;
	/**
	 * Triggers once when a file in the queue begins uploading.(function)
	 * @var string
	 */
	public $onOpen;
	/**
	 * Triggers each time the progress of a file upload changes.(function)
	 * @var string
	 */
	public $onProgess;
	/**
	 * Triggers when the number of files in the queue matches the queueSizeLimit.(function)
	 * @var string
	 */
	public $onQueueFull;
	/**
	 * Triggers once for each file that is added to the queue.(function)
	 * @var string
	 */
	public $onSelect;
	/**
	 * Triggers once each time a file or group of files is added to the queue.(function)
	 * @var string
	 */
	public $onSelectOnce;
	/**
	 * Triggers when the flash file is done loading.(function)
	 * @var string
	 */
	public $onSWFReady;
	/**
	 * The route the uploader will fire e.g. contacts/default/upload
	 * @var string
	 */
	public $route;
	/**
	 * The asset url given by the asset manager.(private)
	 * @var string
	 */
	private $assetUrl;

	public function init() {
		$localPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$this->assetUrl = Yii::app()->getAssetManager()->publish($localPath);

		Yii::app()->clientScript->registerScriptFile($this->assetUrl . '/js/swfobject.js');
		Yii::app()->clientScript->registerScriptFile($this->assetUrl . '/js/jquery.uploadify.js');
		Yii::app()->clientScript->registerCssFile($this->assetUrl . '/css/uploadify.css');

		if (!$this->uploader) {
			$this->uploader = $this->assetUrl . '/images/uploadify.swf';
		}
		if (!$this->cancelImg) {
			$this->cancelImg = $this->assetUrl . '/images/cancel.png';
		}
		if (!$this->script) {
			$this->script = CHtml::normalizeUrl($this->route);
		}
		if($this->route){
			$this->scriptData['route'] = $this->route;
		}

	}

	public function getOptions() {
		$options = array('auto','buttonImg','buttonText','cancelImg','checkScript',
			'displayData','expressInstall','fileDataName','fileDesc','fileExt',
			'folder','height','hideButton','method','multi','queueID',
			'queueSizeLimit','removeCompleted','rollover','script','scriptAccess',
			'scriptData','simUploadLimit','sizeLimit','uploader','width','wmode',
			'onAllComplete','onCancel','onCheck','onClearQueue','onComplete',
			'onError','onInit','onOpen','onProgess','onQueueFull','onSelect',
			'onSelectOnce','onSWFReady');

		foreach ($options as $option) {
			if($this->$option !== null){
				$array[$option] = $this->$option;
			}
		}
		return $array;
	}

	public function run() {
		$this->render('index', array('config' => CJavaScript::encode($this->getOptions())));
	}

}