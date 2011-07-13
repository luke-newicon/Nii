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
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * !!!! NOTE IF YOU CHANGE THIS FUNCTION YOU MUST CHANGE THE JAVASCRIPT EQUIVELANT ON THE details/index.php PAGE
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * initially when first uploaded the screens name is equivelant to the filename, this function
	 * formats the filename so it a-lookedy-nice.
	 * @param string $filename
	 * @return string formatted filename 
	 */
	public function formatFileName($filename){
		// remove file extension
		$name = preg_replace("/\.[^\.]*$/", '', $filename);
		//$name = substr($filename, 0,strrpos($filename,'.'));
		// convert dashes to spaces
		$name = str_replace(array('-','_'), ' ', $name);
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
	
	
	/**
	 * Gets the number of hotspots on the screen
	 * 
	 * @return integer
	 */
	public function getNumHotspots(){
		return ProjectHotSpot::model()->countByAttributes(array('screen_id'=>$this->id));
	}
	
	/**
	 * Gets the number of screens that link to this screen
	 * 
	 * @return integer 
	 */
	public function getNumIncomingLinks(){
		return ProjectHotSpot::model()->countByAttributes(array('screen_id_link'=>$this->id));
	}
	
	/**
	 * Gets the number of screens that link to this screen
	 * 
	 * @return integer 
	 */
	public function getNumOutgoingLinks(){
		return ProjectHotSpot::model()->countByAttributes(array('screen_id'=>$this->id,'screen_link_id'=>''));
	}
	
	
	
	public function getTemplates(){
		$templates = ProjectTemplate::model()->findAllByAttributes(array('project_id'=>$this->project_id));
		return $templates;
	}
	
	public function getTemplateHotspots(){
		$templates = ProjectScreenTemplate::model()->findAllByAttributes(array('screen_id'=>$this->id));
		$tArr = array();
		foreach($templates as $t){
			$tArr[] = $t->template_id;
		}
		return ProjectHotSpot::model()->findAllByAttributes(array('template_id'=>$tArr));
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
				'home_page'=>'bool',
				'sort'=>'int'
			),
			'keys'=>array(
				array('sort'),
				array('file_id'),
				array('project_id')
			),
			'foreignKeys'=>array(
				array('project_screen','project_id','project_project','id','CASCADE','CASCADE')
			)
		);
	}
}