<?php

/**
 * Project class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of Project
 *
 * @author steve
 */
class ProjectScreen extends NAppRecord
{
	
	private $_file;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectProject the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{project_screen}}';
	}
	
	
	/**
	 * return a nicely formated image name
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * initially when first uploaded the screens name is equivelant to the filename, this function
	 * formats the filename so it a-lookedy-nice.
	 * @param string $filename
	 * @return string formatted filename 
	 */
	public function formatFileName($filename){
		// remove file extension
		$name = substr($filename, 0,strrpos($filename,'.'));
		// convert dashes to spaces
		$name = str_replace('-', ' ', $name);
		return $name;
	}
	
	/**
	 * gets the associated file manager file.
	 * 
	 * @return NFile 
	 */
	public function getFile(){
		if($this->_file === null) 
			$this->_file = NFileManager::get()->getFile($this->file_id);
		return $this->_file;		
	}
	
	/**
	 * Uses the top left pixel to determin the background color
	 * returns an array with red, green, blue, alpha, keys.
	 * 
	 * @return array Array (
	 *		[red] => 226
	 *		[green] => 222
	 *		[blue] => 252
	 *		[alpha] => 0
	 * )
	 */
	public function guessBackgroundColor(){
		$file = $this->getFile();
		switch (strtolower(CFileHelper::getExtension($file->getPath()))){
			case 'png':
				$im = imagecreatefrompng($file->getPath());
				break;
			case 'gif':
				$im = imagecreatefromgif($file->getPath());
				break;
			case 'jpg':
			case 'jpeg':
				$im = imagecreatefromjpeg($file->getPath());
				break;
		}
		$rgb = imagecolorat($im, 1, 1);
		return imagecolorsforindex($im, $rgb);
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'project_id'=>'int',
				'file_id'=>'int',
				'name'=>'string',
				'home_page'=>'bool'
			)
		);
	}
}