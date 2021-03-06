<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of DetailsController
 *
 * @author steve
 */
class DetailsController extends AController 
{
	
	public function pluploadProcess(&$targetDir, &$fileName, &$orginalName){
		// HTTP headers for no cache etc
		header('Content-type: text/plain; charset=UTF-8');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		// Settings
		$targetDir = Yii::getPathOfAlias('application.runtime'); //dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'wpii' . DIRECTORY_SEPARATOR . 'gallery';
		$cleanupTargetDir = false; // Remove old files
		$maxFileAge = 60 * 60; // Temp file age in seconds

		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		//sleep(5);
		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
		$orginalName = $fileName;
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '', $fileName);

		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}

		// Create target dir
		if (!file_exists($targetDir))
			@mkdir($targetDir);

		// Remove old temp files
		if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$filePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// Remove temp files if they are older than the max age
				if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
					@unlink($filePath);
			}

			closedir($dir);
		} else {
			Yii::log('Failed to open temp directory.', 'error', 'nii.widgets.plupload');
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
		}

		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];

		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else {
						Yii::log('Failed to open input stream.', 'error', 'nii.widgets.plupload');
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					}
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else {
					Yii::log('Failed to open output stream.', 'error', 'nii.widgets.plupload');
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
				}
			} else {
				Yii::log('Failed to move uploaded file.', 'error', 'nii.widgets.plupload');
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}
		} else {
			// Open temp file
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else {
					Yii::log('Failed to open input stream.', 'error', 'nii.widgets.plupload');
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
				}
				fclose($in);
				fclose($out);
			} else {
				Yii::log('Failed to open output stream.', 'error','nii.widgets.plupload');
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}
		}
		
		$file = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$size = getimagesize($file);
		$rgba = ProjectScreen::guessBackgroundColorFile($file);
		$fileContents = file_get_contents($file);
		// remove the tempory file
		unlink($file);
		
		return array(
			'width'=>$size[0],
			'height'=>$size[1],
			'background'=>"{$rgba['red']},{$rgba['green']},{$rgba['blue']},{$rgba['alpha']}",
			'fileContents'=>$fileContents
		);
	}
	
	public function actionUpload($projectId){
		$this->layout = 'ajax';
		
		// upload the file and return contents
		$fileInfo = $this->pluploadProcess($targetDir, $fileName, $orginalName);
		$fileContents = $fileInfo['fileContents'];
		
		$id = NFileManager::get()->addFile($fileName, $fileContents);
		
		$name = ProjectScreen::model()->formatFileName($orginalName);
		
		$s = ProjectScreen::model()->findByAttributes(array('name'=>$name,'project_id'=>$projectId));
		$replacement=false;
		if($s===null){
			$s = new ProjectScreen;
		}else{
			// delete current file
			NFileManager::get()->deleteFile($s->file_id);
			$replacement=true;
		}
		$s->file_id = $id;
		$s->project_id = $projectId;
		$s->width = $fileInfo['width'];
		$s->height = $fileInfo['height'];
		$s->name = ProjectScreen::model()->formatFileName($orginalName);
		$s->background = $fileInfo['background'];
		$s->save();
		

		
		// Return JSON-RPC response
		$ret = array(
			'jsonrpc' => '2.0',
			'result' => array(
				'screen'=>$s->getAttributes(),
				'replacement'=>$replacement
			),
			'id'=>'uploader'
		);
		die(CJSON::encode($ret));
	}

}