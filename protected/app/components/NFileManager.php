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
 *
 * HOW TO USE ME!
 * There are 3 reassons you will need this function:
 *
 * 1) Adding a file uploaded to the system. :doesnt make much sense (know what you mean though)
 *
 * TODO: matt code examples?
 *
 * 2) Creating a new file based on text etc in the system. :doesnt make much sense.
 *
 *
 * 3) Retrieving information for one or more files. (information?)
 *
 * @author steve
 *
 */
Yii::import('application.vendors.Zend.File.*');

/**
 * Stores and retrieves files from the system.
 *
 * @author matthewturner
 * @version 0.1
 */
class NFileManager extends CApplicationComponent {

	/**
	 * location without trailing slash (will strip trailing slash)
	 * @var <type>
	 */
	public $location;
	public $_fileTransObj;
	public $_fileId;
	public $fileHandlerClass = 'NFileHandler';
	public $fileNameTemplate = '{timestamp}.{filename}';

	public function __construct() {
		$this->_fileTransObj = new Zend_File_Transfer_Adapter_Http();
	}

	/**
	 * Saves a file and returns the id to reference the file
	 * This id should be stored and used to access information on the file in the future.
	 * If the upload fails it returns boolean false;
	 * To retrieve the error messages call ->getMessages which returns an array of the error
	 * messages. For example upload limit exceeded.
	 *
	 * @param string $area The area the file will be saved in (e.g dreg or wpack).
	 * @return int id to refer to the file, or boolean false if upload failed.
	 */
	public function saveFile($area='core') {
		if (!empty($_FILES)) {
			try {
				$targetPath = $this->location . $area . DS;
				$this->locationCheck($targetPath);

				$up = $this->getFileTransObj();

				$origFileName = $up->getFileName(null, false);

				$up->addFilter('rename', array('target' => $targetPath . time() . '_' . $origFileName));
				$up->receive();
				$info = $up->getFileInfo();
				$upFile = new NFiles();

				$upFile->original_name = $origFileName;
				$upFile->filed_name = $up->getFileName(null, false);
				$upFile->size = $up->getFileSize();
				$upFile->mime = $up->getMimeType();
				$upFile->file_path = $up->getFileName();
				$upFile->category = $area;
				$upFile->save();
				$this->_setFileId($upFile->fileId);
				return $this->_getFileId();
			}
			 catch (Zend_File_Transfer_Exception $e) {
				return false;
			}
		}
	}

	private function locationCheck($targetPath){
		//If base folder cannot be found then throws an error
		if ($this->folderFileCheck($this->location) == false) {
			echo "Sorry but the file could not be uploaded.\nThis is probably due to the upload directory being unavailable.\nCheck the network, and the location supplied in the conf.ini file is reachable.";
		} else {
			//checks to see if the area folder is present and readable. If it is not present, then the folder is created.
			if ($this->folderFileCheck($targetPath) === false) {
				mkdir($targetPath);
			}
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
	 * Returns an array of file information for the supplied file id
	 *
	 * <div>EXAMPLES<div>
	 * getFile(1);
	 * will return information for one file.
	 *
	 * returns
	 *
	 * array(
	 * 		0 => array(
	 * 			file_id=>1,
	 * 			'description'=>'Image description',
	 * 			'uploadedUserId'=>1,
	 * 			'uploadedDate'=>22/03/2010,
	 * 			'originalName'=>'My file',
	 * 			'filed_name'=>'Filed_name',
	 * 			'size'=>3,
	 * 			'mime'=>'image/jpeg',
	 * 			'file_path'=>'c://FileMcPath/path.jpg'
	 * 		)
	 * )
	 *
	 * @param array of file information or null
	 */
	public function getFile($fileIds) {
		$arr = $this->getFileInformation($fileIds);
		if (empty($arr))
			return null;
		return $arr[0];
	}

	/**
	 * Will create a new file in the system based on supplied text
	 *
	 * EXAMPLES
	 * addFile('test contents',array('filed_name'=>'MyNewFile.txt'))
	 * The mimimum code required to create a file on the system. This will create
	 * a file with the name MyNewFile.txt in the location specified in main.php and put
	 * 'test contents' as the contents of the file.
	 *
	 * $attributes = array('filed_name'=>'MyNewFile.text',
	 * 'mime'=>'image/jpeg'.'description'=>'File description')
	 * addFile('test contents',array('filed_name'=>'MyNewFile.txt'))
	 * This more advanced example will create a file on the system in the location specified
	 * in main.php called MyNewTextFile.txt and put 'test contents' as the contents. It will also
	 * record the description as File Description in the database
	 *
	 * @param String $fileContents The contents of the file that will be created on the system
	 * @return String the Id of the file which has been created in the system
	 */
	public function addFile($fileName, $fileContents, $area='nii', $mimeType=null) {

		$fileNewName = time() . $fileName;

		//$status = file_put_contents($this->location.$fileNewName,$fileContents);
		$filePath = rtrim($this->location, DS);
		$targetPath = $filePath.DS.$area.DS;

		$this->locationCheck($targetPath);

		$status = file_put_contents($targetPath. $fileNewName . '.txt', $fileContents);

		$newFile = new NFiles();
		$newFile->original_name = $fileName;
		$newFile->filed_name = $fileNewName;
		$newFile->size = filesize($filePath);
		$newFile->mime = CFileHelper::getMimeType($filePath);
		$newFile->file_path = $filePath;
		$newFile->category = $area;
		$newFile->save();

		$this->_setFileId($newFile->fileId);
		return $this->_getFileId();
	}

	/**
	 * Sets a variable with the id of the newly uploaded file
	 * @param int $id The id of the newly uploaded file.
	 */
	protected function _setFileId($id) {
		$this->_fileId = $id;
	}

	/**
	 * Returns the id of the file which has just been uploaded.
	 * @return string.
	 */
	public function _getFileId() {
		return $this->_fileId;
	}

	/**
	 * Returns an array of file information for the supplied file ids.
	 *
	 * File ids can be supplied as either a numeric value or as an array if
	 * searching for multiple files.
	 *
	 * <div>EXAMPLES<div>
	 * getFile(1);
	 * will return information for one file.
	 *
	 * getFile(array(1,2,3));
	 * Will return files with an id of 1,2,3
	 *
	 * Both of the above examples will return data in the following format:
	 *
	 * array(
	 * 		0 => array(
	 * 			file_id=>1,
	 * 			'description'=>'Image description',
	 * 			'uploadedUserId'=>1,
	 * 			'uploadedDate'=>22/03/2010,
	 * 			'originalName'=>'My file',
	 * 			'filed_name'=>'Filed_name',
	 * 			'size'=>3,
	 * 			'mime'=>'image/jpeg',
	 * 			'file_path'=>'c://FileMcPath/path.jpg'
	 * 		)
	 * )
	 */
	public function getFiles($ids) {

		// Sets up the function
		$fileIds = null;

		// Searches the database for the file ids.
		$files = NFile::model()->findAllByAttributes(array('id' => $ids));

		// If no results can be found then returns null.
		if (count($files == 0))
			return null;

		// This will contain the information on the files which will be returned to the user.
		$fileInformation = array();

		// Each result which is found is added to an array which can then be outputted.
		foreach ($files as $result) {
			$fileInformation[$result->id]['fileId'] = $result->fileId;
			$fileInformation[$result->id]['description'] = $result->description;
			$fileInformation[$result->id]['uploaded_by'] = $result->uploaded_by;
			$fileInformation[$result->id]['uploaded'] = $result->uploaded;
			$fileInformation[$result->id]['original_name'] = $result->original_name;
			$fileInformation[$result->id]['filed_name'] = $result->filed_name;
			$fileInformation[$result->id]['size'] = $result->size;
			$fileInformation[$result->id]['mime'] = $result->mime;
			$fileInformation[$result->id]['file_path'] = $result->file_path;
		}
		return $fileInformation;
	}

	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * Checks to make sure the area folder is present. If it is not, then it creates it.
	 * @param $area
	 */
	public function folderFileCheck($area) {
		if (!is_writable($area)) {
			return false;
		} else {
			return true;
		}
	}

}
?>
