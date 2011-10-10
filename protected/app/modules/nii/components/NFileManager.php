<?php

/**
 * Uploads should all pass through an app level upload manager. like this one :-)
 *
 * The problem:
 * File storage policies evolve as the site grows.
 * Often many different modules in an application want to store and upload files.
 * Changing file storage policy becomes difficult to maintain as you have to specify the new
 * file storage rules in each part of the application that involves uploading files.
 * Thus increase risk of bugs and broken functionality. Makes successfully upadting files storage
 * rules a very expensive and problematic task.
 *
 * The solution:
 * Standardise the method by which the application stores and retrives files and ecapsulate the
 * functionality. Like this class!
 *
 * The filemanager should be able to work out the files system path from the category variable
 * In the case of complex file storage where a cron job may move files monthly onto a longer term file storage server, 
 * the cron job can update the category field in the file database thus enabling the filemanager to work out where it is.
 *
 * Typical configuration example:
 * -----------------------------
 *     'fileManager'=>array(
 *         'class'=>'NFileManager',
 *	       'location'=>Yii::getPathOfAlias('base.uploads'),
 *	       'defaultCategory' => 'attachments',
 *	       'categories' => array(
 *	           'attachments' => 'attachments',
 *             'profile_photos' => 'profile_photos',
 *             'logos' => 'logos',
 *         ),
 *     ),
 * 
 * TODO: provide mechanism to store files in subfolders like month-day to avoid max file folder limits.
 * 
 * @author The Newicon Team
 * @version 1.0
 */
Yii::import('application.vendors.Zend.File.*');
require('Zend/File/Transfer/Adapter/Http.php');

/**
 * Stores and retrieves files from the system.
 *
 * @author matthewturner
 * @version 0.1
 */
class NFileManager extends CApplicationComponent 
{

	/**
	 * location without trailing slash (will strip trailing slash)
	 * if specifying an absolute path you must set locationIsAsbsolute to true, also it is recomended to use
	 * Yii::getPathOfAlias('system') to ensure absolute is generated properly depending on the current runtime environment
	 * @var string
	 */
	public $location;
	
	/**
	 * the last NFile object added and uploaded
	 * @var NFile 
	 */
	public $lastFile;
	
	
	public $defaultCategory='nii';
	
	/**
	 * A list of categories mapping to a storage location
	 * categoryName=>'location'
	 * @var array 
	 */
	public $categories;
	
	/**
	 * Determins if the location attribute is a path relative to the basePath (Yii::app()->basePath) or an absolute path
	 * by default it assumes a relative path. However it is acceptable to specify the location as an absolute path 
	 * using Yii::getPathOfAlias()
	 * @var boolean 
	 */
	public $locationIsAbsolute = false;
	
	/**
	 * The Zend file transfer object
	 * @var Zend_File_Transfer_Adapter_Http 
	 */
	private $_fileTransObj;
	

	public function __construct() {
		$this->_fileTransObj = new Zend_File_Transfer_Adapter_Http();

		//Stops a double directory seperator from appearing in the location.
		$this->location = rtrim($this->location, DIRECTORY_SEPARATOR);
	}

	/**
	 * Saves a file and returns the id to reference the file
	 * This id should be stored and used to access information on the file in the future.
	 * If the upload fails it returns boolean false;
	 * To retrieve the error messages call NFileManager->getFileTransObj()->getMessages which returns an array of the error
	 * messages. For example upload limit exceeded.
	 *
	 * @param string $category The category to save the file in, categories can map to different storage locations.
	 * @return int id to refer to the file, or boolean false if upload failed.
	 */
	public function saveFile($category='default') {
		if (!empty($_FILES)) {
			$targetPath = $this->getPath($category);
		
			//$targetPath = $this->location . DIRECTORY_SEPARATOR . $area . DIRECTORY_SEPARATOR;
			$this->_locationCheck($targetPath);
			$up = $this->getFileTransObj();
			$origFileName = $up->getFileName(null, false);
			$filedName = date('YmdHis') . '_' . $origFileName;

			$up->addFilter('rename', array('target' => $targetPath . $filedName));
			$up->receive();

			
			$info = $up->getFileInfo();
			$upFile = new NFiles();

			if ($filedName)
				$uploadedFileName = $filedName;
			else
				$uploadedFileName = $up->getFileName(null, false);

			$upFile->addNewFile('', $origFileName, $uploadedFileName, $up->getFileSize(), CFileHelper::getMimeTypeByExtension($origFileName), $category);
			$this->lastFile = $upFile;
			
			return $upFile->id;	
		}
	}
	
	/**
	 * Get the system path where the file should be stored.
	 * This function determines the path from the category variable
	 * 
	 * @param string $category
	 * @return string file system path with trailing DS
	 */
	public function getPath($category='default'){
		$category = ($category=='default'?$this->defaultCategory:$category);
		
		// if the default category does not exist assume it is a folder with the default category name
		$categoryLoc = array_key_exists($category, $this->categories) ? $this->categories[$category] : $category;
		
		if(!file_exists($this->location))
			mkdir($this->location);
		
		if($this->locationIsAbsolute)
			$targetPath = $this->location.DS.$categoryLoc;
		else
			$targetPath = Yii::app()->basePath.DS.$this->location.DS.$categoryLoc;
		// if path doesn't exist atempt to create it.
		if(!file_exists($targetPath))
			mkdir($targetPath);
		
		return $targetPath.DS;
	}
	
	/**
	 * Gets the system path to the file.
	 * Note: this is not usually a web accessible path
	 * Note: this uses the NFile's category and filed_name attribute to determin the path. 
	 *
	 * @param NFile $file
	 * @return string system path to the file
	 */
	public function getFilePath($file){
		if(!$file instanceof NFile && is_int($file)){
			$file = $this->getFile($file);
		}
		return $this->getPath($file->category) . $file->filed_name;
	}
	
	/**
	 * Makes and returns the url accessible path to the file.
	 * 
	 * @param mixed $id can be the integer filemanager id or a NFile object
	 */
	public function getUrl($id, $name='', $downloadable=false){
		if($id instanceof NFile)
			$id = $id->id;
		return NHtml::url(array('/nii/index/file','id'=>$id, 'name'=>$name, 'downloadable'=>$downloadable));
	}
	
	

	/**
	 * Checks to see if the upload location is accessible.
	 * @param string $targetPath The path to check
	 */
	private function _locationCheck($targetPath) {
		//If base folder cannot be found then throws an error
		if (!is_writable($targetPath)) {
			if (!mkdir($targetPath))
				throw new CException("Sorry the file could not be uploaded.\nThis may be due to the upload directory being unavailable.\nCheck the upload directory exists and has the right permissions.");
		}
	}

	/**
	 * get the file transfer object responsible for handling the upload
	 * @return Zend_File_Transfer_Adapter_Http
	 */
	public function getFileTransObj() {
		return $this->_fileTransObj;
	}

	/**
	 * Returns an NFile object for the supplied file id
	 *
	 * @param int file id
	 * @return NFile record or null
	 */
	public function getFile($id) {
		// could add to local cache array
		// file_id => file record
		// thus subsequent calls to getFile would not result in additional lookups
		return NFile::model()->findByPk($id);
	}
	
	/**
	 * Returns an array of NFile objects for the supplied file ids.
	 *
	 * @param array $ids array of NFile ids.
	 * @return array of NFile active records, if no records found an empty array is returned
	 * @see NFile
	 */
	public function getFiles($ids) {
		// Searches the database for the file ids.
		return NFile::model()->findAllByPk($ids);;
	}

	/**
	 * Will create a new NFileManager managed file in the system based on supplied $fileContents variable
	 * This is particularly useful when adding files from email attachments.
	 * The file is represented by base64 text which can be decoded and passed into the $fileContents
	 * variable, the function will store a physical file in the appropriate 
	 * directory and add a NFile record to represent it.
	 *
	 * @param string $fileName the name fo the file
	 * @param string $fileContents The contents of the file that will be created on the system
	 * @param string $category the category used to determine how to store the file defaults to nii
	 * @param string $mimeType the mimeType of the file, if unknown it will attempt to autodetect the mimetype.
	 * @return int the Id of the file which has been created in the system
	 */
	public function addFile($fileName, $fileContents, $category='nii', $mimeType=null) {

		$fileNewName = time() . $fileName;
		$filePath = $this->getPath($category) . $fileNewName;

		file_put_contents($filePath, $fileContents);

		$newFile = new NFile();
		$mimeType = ($mimeType!==null) ? $mimeType : CFileHelper::getMimeType($filePath);
		$newFile->addNewFile('', $fileName, $fileNewName, filesize($filePath), $mimeType, $category);

		$this->lastFile = $newFile;
		return $newFile->id;
	}


	/**
	 * Remove a file from the system
	 * 
	 * @param int or array $ids File id/s to mark as deleted.
	 * @param boolean $deleteFile Whether or not to remove the file from the system.
	 */
	public function deleteFiles($ids, $deleteFile = false) {

		// If only marking the file as deleted then updates the table to show the file as deleted.
		// If the file is to be removed from the file system then there is no point in leaving an
		// orphan record in the database. The records are deleted along with the file.
		if (!$deleteFile) {
			NFile::model()->updateByPk($ids, array('deleted' => 1));
		} else {

			//CODE TO DELETE FILE FROM THE SYSTEM HERE!!!!!!1
			//removes the unneeded records from the database.
			NFile::model()->deleteByPk($ids);
		}
	}



	/**
	 * Loads a file from where it is stored on the system and outputs the information to screen.
	 * 
	 * @param mixed $id the NFile id of the file to display. Or an NFile object
	 * @param boolean $renderInPage wether or not to render the file in page. The default is false
	 * @param string $customName A custom name to call the file when downloading. Please include the file extension.
	 * optional uses original_name if null
	 * @returns void | false on error
	 * @see NFileManager::displayFileData
	 */
	public function displayFile($id, $name='', $makeDownload=false) {

		// Retrieves file information.
		if($id instanceof NFile) {
			$file = $id;
		} else {
			$file = $this->getFile($id);
			if($file === null) 
				throw new CHttpException(404, "The file can not be found.");
		}

		if($name == '')
			$name = $file->original_name;

		$data = file_get_contents($this->getFilePath($file));
		$this->displayFileData($data, $file['mime'], $name, $makeDownload);
	}

	/**
	 * Outputs file data to the screen
	 * 
	 * @param string $data
	 * @param string $mimeType
	 * @param string $name
	 * @param boolean $makeDownload
	 */
	public function displayFileData($data, $mimeType, $name='', $makeDownload=false) {
		if ($data) {
			header('Content-Type:' . $mimeType);
			if ($name == '') {
				$name = md5(date('Y-m-d h:i:s', time()));
			}
			// Tells browser to download file if render in page is set to false.
			// Extra lines are needed to get the file name to correctly download in IE7/7.
			if ($makeDownload) {
				// Replaces all spaces with underscores which solves the problem of spaces being used in file names
				$safeName = str_replace('.', '_', $name);
				$safeName = str_replace('%20', '_', $safeName);
				// Needs to go last, this adds the file extension to the end of the file.
				$safeName = $safeName . '.' . pathinfo($name, PATHINFO_EXTENSION);
				header('Content-Disposition: attachment; filename=' . $safeName);
//				header("Cache-Control: private, max-age=10800, pre-check=10800");
//				header("Pragma: private");
//				header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));
				header("Pragma: public");
				header("ExpiresDefault: access plus 10 years");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			}
			echo $data;

			// Once the file has been read, this code stops anything else from being rendered onto the bottom of it.
			exit();
		} else {
			throw new CHttpException(404, Yii::t('app', 'The specified file cannot be found.'));
		}
	}
	
	
	/**
	 * deletes a file from the server and removes the associated database record.
	 * @param int $fileId
	 */
	public function deleteFile($fileId){
		
		$f = $this->getFile($fileId);
		if($f===null)
			// The file row does not exist, it's already deleted, lets ignore this request
			return false;
		
		$filePath = $this->getFilePath($f);
		// it is possible if upload directories have changed or db and filesystem is out of sync
		// for there to be no file so first lets check there is a file available for deletion
		if(is_file($filePath)){
			unlink($filePath);
		}
		
		return $f->delete();
	}
	
	
	
	/**
	 * @return NFileManager 
	 */
	public static function get(){
		return Yii::app()->fileManager;
	}

}