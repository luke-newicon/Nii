<?php
/**
 * Uploads should all pass through an app level upload manager. like this one :-)
 *
 * The problem:
 * File storage policies evolve as the site grows.
 * Often many different modules in an application want to store and upload files.
 * Changing file storage policy becomes difficult to maintain as you have to specify the new
 * file storage rules in each part of the application that involves uploading files.
 * Thus increase risk of bugs and broken functionality. Makes successfully upadting files torage
 * rules a very expensive and problematic task.
 *
 * The solution:
 * Standardise the method by which the application stores and retrives files and ecapsulate the
 * functionality. Like this class!
 *
 * The principle:
 *
 * Modules in the application can only retrieve files stored by asking the uploader.
 *
 * 1: tell the uploader to store the file.
 * 2: it will return an id.
 * 3: the module stores this id. It does NOT store a path or other method of findding the file
 * 4: Then you can pass the id to the uploader to retrieve the file information
 * simples.
 *
 * //general code example
 * //create an uploader object
 * $up = new Uploader();
 * //call the save file method to save files passed by the $_FILES variable
 * $id = $up->saveFile();
 * //check successful upload
 * if(false == $id){
 *     //upload failed show error messages
 *     echo implode('<br/>', $up->getMessages());
 * }else{
 * 	   $myModule->saveFileId($id);
 * 	   //get file info
 * 	   $filePath = $up->getUrlPath($id);
 * 	   //display link to file
 *     echo "<a href='$filePath'>new uploaded file</a>";
 * }
 *
 * @author steve
 *
 */
class Uploader extends CApplicationComponent
{
	private $_fileTransObj;
	private $_fileId;
	
	/**
	 * Optional upload directory if not set will use the default upload directory
	 * defined in the config file
	 * @var string
	 */
	public $uploadDir;

	public function __construct(){
		$this->_fileTransObj = new Zend_File_Transfer_Adapter_Http();
	}

	/**
	 * Returns the path to the controller which outputs the specified file.
	 * @param int $fileId The unique id of the file to be displayed.
	 * @return string
	 */
	public function getUrlPath($fileId,$makeDownload=false,$name=null){
		return self::url($fileId,$makeDownload=false,$name=null);
	}

	/**
	 * REturn the url link to display the file
	 * @param $fileId
	 * @param $makeDownload
	 * @param $name optional
	 * @return unknown_type
	 */
	public static function url($fileId, $makeDownload=false, $name=null){
		$makeDownload = ($makeDownload)?'1':'0';
		return Nworx::url("core/file/get-file/$fileId/$makeDownload/$name");
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
	public function saveFile($area='core'){
		if (!empty($_FILES)) {
			try{
				$targetPath = $this->getUploadDir() . $area . DS;
				
				//If base folder cannot be found then throws an error
				if ($this->folderFileCheck($this->getUploadDir())==false){
					echo "Sorry but the file could not be uploaded.\nThis is probably due to the upload directory being unavailable.\nCheck the network, and the location supplied in the conf.ini file is reachable.";
				} else {
					//checks to see if the area folder is present and readable. If it is not present, then the folder is created.
					if($this->folderFileCheck($targetPath)===false){
						mkdir($targetPath);
					}
					
					$up = $this->getFileTransObj();

					$origFileName = $up->getFileName(null,false);

					$up->addFilter('rename',array('target'=>$targetPath.time().'_'.$origFileName));
					$up->receive();
					$info = $up->getFileInfo();
					$upFile = new Nworx_Core_Model_File();
					$upFile->original_name = $origFileName;
					$upFile->filed_name = $up->getFileName(null, false);
					$upFile->size = $up->getFileSize();
					$upFile->mime = $up->getMimeType();
					$upFile->file_path = $up->getFileName();
					$upFile->category = $area;
					$upFile->save();
					$this->setFileId($upFile->id());
					return $this->getFileId();
				}
			} catch(Zend_File_Transfer_Exception $e){
				return false;
			}
		}
	}
	
	/**
	 * Adds a file to the upload manager. 
	 * Based on the fileContent 
	 * 
	 * @param $fileName
	 * @param varient $fileContent the contents of the file
	 * @param $area
	 * @return fileId
	 */
	public function addFile($fileName, $fileContent, $area='core'){
		$targetPath = $this->getUploadDir() . $area . DS;
		
		// If base folder cannot be found then throws an error
		if ($this->folderFileCheck($this->getUploadDir())==false)
			throw new Newicon_Exception("Sorry but the file could not be uploaded.\nThis is probably due to the upload directory being unavailable.\nCheck the network, and the location supplied in the conf.ini file is reachable.");
		
			
		// checks to see if the area folder is present and readable. If it is not present, then the folder is created.
		if($this->folderFileCheck($targetPath)===false){
			mkdir($targetPath);
		}
		
		$fileNewName = time().'_'.$fileName;
		$filePath = $targetPath.$fileNewName;
		file_put_contents($filePath, $fileContent);
		
		$upFile = new Nworx_Core_Model_File();
		$upFile->original_name = $fileName;
		$upFile->filed_name = $fileNewName;
		$upFile->size = filesize($filePath);
		$upFile->mime = Newicon_Utils_FileHelper::getMimeType($filePath);
		$upFile->file_path = $filePath;
		$upFile->category = $area;
		$upFile->save();
		$this->_setFileId($upFile->id());
		return $this->getFileId();
	}

	/**
	 * Sets a variable with the id of the newly uploaded file
	 * @param int $id The id of the newly uploaded file.
	 */
	protected function _setFileId($id){
		$this->_fileId = $id;
	}

	/**
	 * Returns the id of the file which has just been uploaded.
	 * @return string.
	 */
	public function getFileId(){
		return $this->_fileId;
	}

	/**
	 * Get the stored file. Pass in the uploader image id returned
	 * when originally uploading the file.
	 * @param $id
	 * @return Nworx_Core_Model_File or boolean false if the row does not exist
	 */
	public function getFile($id){
		try{
			$file = new Nworx_Core_Model_File($id);
			return $file;
		}catch(Newicon_Exception $e){
			return false;
		}
	}

	/**
	 * Loads a file from where it is stored outside of the document root and outputs the information to screen.
	 * @param int $fileId The uploader id of the file to display.
	 * @param boolean $renderInPage wether or not to render the file in page. The default is false
	 * @param string $customName A custom name to call the file when downloading. Please include the file extension.
	 * optional uses original_name if null
	 */
	public function displayFile($fileId,$makeDownload=false,$name=null){

		//retrives file information.
		$file = $this->getFile($fileId);

		//Displays an error message if the supplied fileid search returns no rows.
		if (count($file)=== 0){
			return false;
		}
			
		//Stores the location of the file as a variable
		$fileLocation = $this->getUploadDir().$file['category'].DS.$file['filed_name'];
			
		if($this->folderFileCheck($fileLocation)!=false){
			header('Content-Type:'.$file->mime);

			//tells browser to download file if render in page is set to false.
			//Extra lines are needed to get the file name to correctly download in IE7/7.
			if($makeDownload){
				if($name!= null){
					//Replaces all spaces with underscores which solves the problem of spaces being used in file names
					$safeName = str_replace('.','_',$name);
					$safeName = str_replace('%20','_',$safeName);
					//Needs to go last, this adds the file extension to the end of the file.
					$safeName = $safeName.'.'.pathinfo($file['filed_name'],PATHINFO_EXTENSION);
					header('Content-Disposition: attachment; filename='.$safeName);
				} else {
					header('Content-Disposition: attachment; filename='.$file->original_name);
				}

				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			}
			readfile($fileLocation);
		}else{
			Newicon_Mvc::response()->redirect404();
		}
	}

	/**
	 * Finds the path to a specified file.
	 * @param int $id The id of the file to find the path to.
	 * @return string
	 */
	public function getFilePath($id){

		//find out about the file
		$file = $this->getFile($id);

		//find the base path
		$filePath = $this->getUploadDir().$file['category'].DS.$file['filed_name'];
		return $filePath;
	}
	
	public static function filePath($id){
		$u = new Nworx_Core_Model_Uploader();
		return $u->getFilePath($id);
	}

	/**
	 * Checks to make sure the area folder is present. If it is not, then it creates it.
	 * @param $area
	 */
	public function folderFileCheck($area){
		if(!is_writable($area)) {
			return false;
		}
		else{
			return true;
		}
	}

	/**
	 * get upload path defined in configuration
	 * @return string upload path with a trailing slash
	 */
	public function getUploadDir(){
		if($this->uploadDir===null){
			//realpath removes any trailing slashes
			if(!isset(Nworx::get()->getConf()->core->uploadpath))
				throw new Newicon_Exception('No core.uploadpath specified in the config ini file');
			$path = Nworx::get()->getConf()->core->uploadpath;
			$this->uploadDir = $path . DS;
		}
		return $this->uploadDir;
	}

	/**
	 * get the file transfer object responsible for handling the upload
	 * @return Zend_File_Transfer_Adapter_Http
	 */
	public function getFileTransObj(){
		return $this->_fileTransObj;
	}

	/**
	 * typical use to return error messages on a failed file transfer
	 * @return array of string messages
	 */
	public function getMessages(){
		return $this->getFileTransObj()->getMessages();
	}
	
}