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
 * 2) Creating a new file based on binary or text etc in the system. For example recieving the base_64 encoded 
 * text for an email attachment, you want to create a file from the encoding. Call fileManager->addfile('myEmailAttach','EDV!E£FD(file contents)_ejhfuw3342')
 *
 * 3) Retrieving information for one or more files. (information?)
 *
 * @author steve
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
	 * @var <type>
	 */
	public $location;
	public $_fileTransObj;
	public $_id;
	//public $fileHandlerClass = 'NFileHandler';
	public $fileNameTemplate = '{timestamp}.{filename}';

	public function __construct() {
		$this->_fileTransObj = new Zend_File_Transfer_Adapter_Http();

		//Stops a double directory seperator from appearing in the location.
		$this->location = rtrim($this->location, DIRECTORY_SEPARATOR);
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

			$targetPath = $this->location . DIRECTORY_SEPARATOR . $area . DIRECTORY_SEPARATOR;

			$this->locationCheck($targetPath);

			$up = $this->getFileTransObj();

			$origFileName = $up->getFileName(null, false);

			$filedName = time() . '_' . $origFileName;
			
			$up->addFilter('rename', array('target' => $targetPath . $filedName));
			$up->receive();
			$info = $up->getFileInfo();
			$upFile = new NFile();

			if ($filedName)
				$uploadedFileName = $filedName;
			else
				$uploadedFileName = $up->getFileName(null, false);

			$upFile->addNewFile('', $up->getFileName(null, false), $uploadedFileName, $up->getFileSize(), $up->getMimeType(), $up->getFileName(), $area);

			$this->_setid($upFile->id);
			return $this->_getid();
		}
	}

	/**
	 * Checks to see if the upload location is accessible.
	 * @param string $targetPath The path to check
	 */
	private function locationCheck($targetPath) {
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
	private function getFileTransObj() {
		return $this->_fileTransObj;
	}

	/**
	 * Returns an array of file information for the supplied file id
	 *
	 * <div>EXAMPLES<div>
	 * getFile(1);
	 * will return information for one file. or many if array specified
	 *
	 * @param int file id
	 * @return NFile record or null
	 */
	public function getFile($id) {
		return NFile::model()->findByPk($id);
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
		$filePath = rtrim($this->location, DIRECTORY_SEPARATOR);
		$targetPath = $filePath . DIRECTORY_SEPARATOR . $area . DIRECTORY_SEPARATOR;

		$this->locationCheck($targetPath);

		$status = file_put_contents($targetPath . $fileNewName . '.txt', $fileContents);

		$newFile = new NFile();
		$newFile->addNewFile('', $fileName, $fileNewName, filesize($filePath), CFileHelper::getMimeType($filePath), $filePath, $area);

		$this->_setid($newFile->id);
		return $this->_getid();
	}

	/**
	 * Remove a file from the system
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
	 * Sets a variable with the id of the newly uploaded file
	 * @param int $id The id of the newly uploaded file.
	 */
	private function _setid($id) {
		$this->_id = $id;
	}

	/**
	 * Returns the id of the file which has just been uploaded.
	 * @return string.
	 */
	private function _getid() {
		return $this->_id;
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
	 * @see NFile
	 * @return array of NFile active records, if no records found an empty array is returned
	 */
	public function getFiles($ids) {
		// Searches the database for the file ids.
		return NFile::model()->findAllByPk($ids);;
	}

	private function setLocation($location) {
		$this->location = $location;
	}

	// Returns the base file location.
	public function getBaseLocation(){
		return $this->location;
	}

	/**
	 * Checks to make sure the area folder is present. If it is not, then it creates it.
	 * @param $area
	 */
	private function folderFileCheck($area) {
		if (!is_writable($area)) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Loads a file from where it is stored outside of the document root and outputs the information to screen.
	 * @param int $id The uploader id of the file to display.
	 * @param boolean $renderInPage wether or not to render the file in page. The default is false
	 * @param string $customName A custom name to call the file when downloading. Please include the file extension.
	 * optional uses original_name if null
	 * @returns void | false on error
	 * @see NFileManager::displayFileData
	 */
	public function displayFile($id, $name=null, $makeDownload=false) {

		//retrives file information.
		$file = $this->getFile($id);

		//Displays an error message if the supplied id search returns no rows.
		if (count($file) === 0) {
			return false;
		}

		if(!$name)
			$name = $file->filed_name;

		//Stores the location of the file as a variable
		$fileLocation = $this->location . $file['category'] . DIRECTORY_SEPARATOR . $file['filed_name'];
		$data = file_get_contents($fileLocation);
		$this->displayFileData($data, $file['mime'], $name, $makeDownload);
	}

	/**
	 * Outputs file data to the screen
	 * @param string $data
	 * @param string $mimeType
	 * @param <type> $name
	 * @param <type> $makeDownload
	 */
	public function displayFileData($data, $mimeType, $name=null, $makeDownload=false) {
		if ($data) {
			header('Content-Type:' . $mimeType);
			if ($name === null) {
				$name = md5(date('Y-m-d h:i:s', time()));
			}
			//tells browser to download file if render in page is set to false.
			//Extra lines are needed to get the file name to correctly download in IE7/7.
			if ($makeDownload) {
				//Replaces all spaces with underscores which solves the problem of spaces being used in file names
				$safeName = str_replace('.', '_', $name);
				$safeName = str_replace('%20', '_', $safeName);
				//Needs to go last, this adds the file extension to the end of the file.
				$safeName = $safeName . '.' . pathinfo($name, PATHINFO_EXTENSION);
				header('Content-Disposition: attachment; filename=' . $safeName);

				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			}
			echo $data;

			//Once the file has been read, this code stops anything else from being rendered onto the bottom of it.
			Yii::app()->end();
		} else {
			throw new CHttpException(404, Yii::t('app', 'The specified file cannot be found.'));
		}
	}

}