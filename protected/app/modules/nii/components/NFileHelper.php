<?php

class NFileHelper extends CFileHelper {

	/**
	 * Deletes all files and folders in a selected directory.
	 * @param string $dir the source directory
	 */
	public static function deleteFilesRecursive($dir, $ignore=array()) {
		$files = scandir($dir);
		array_shift($files);	// remove '.' from array
		array_shift($files);	// remove '..' from array

		foreach ($files as $file) {
			$file = $dir . '/' . $file;
			if(!in_array($file, $ignore)) {
				if (is_dir($file)) {
					self::deleteFilesRecursive($file);
					rmdir($file);
				} else {
					unlink($file);
				}
			}
		}
	}

}
