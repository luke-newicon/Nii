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
	
	/**
	 * the associated NFile record for the screen image
	 * @var NFile 
	 */
	private $_file;
	
	/**
	 * @var array of width and height
	 */
	private $_size;
	
	/**
	 * store the comments collection for this screen
	 * @var array of ProjectComment objects 
	 */
	private $_comments;
	
	
	
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
	
	public function rules(){
		return array(
			array('width', 'safe')
		);
	}
	
	/**
	 * return a nicely formated image name
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * !!!! NOTE IF YOU CHANGE THIS FUNCTION YOU MUST CHANGE THE JAVASCRIPT EQUIVELANT ON THE screen/index.php PAGE
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * initially when first uploaded the screens name is equivelant to the filename, this function
	 * formats the filename so it a-lookedy-nice.
	 * javascript also uses this function to determine whether you are overwriting a file or not.
	 * 
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
		if($this->_file === null)
			throw new CHttpException (404,'whoops, no screen found');
		return $this->_file;		
	}
	
	
	
	/**
	 * Uses the top left pixel to determin the background color
	 * returns an array with red, green, blue, alpha, keys.
	 * @see self::guessBackgroundColorFile
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
		return ProjectScreen::guessBackgroundColorFile($file->getPath());
	}
	
	/**
	 * Does the heavy lifting of guessing a background color from a supplied file path
	 * is a static function to allow function to be used globaally outside of the activerecord context.
	 * For example during screen upload. 
	 * (if you already have a filepath you can call this function directly thus saving 
	 * a database call from looking up the screen's file)
	 * 
	 * @see self::guessBackgroundColor
	 * @param string $filePath
	 * @return array Array (
	 *		[red] => 226
	 *		[green] => 222
	 *		[blue] => 252
	 *		[alpha] => 0
	 * )
	 */
	public static function guessBackgroundColorFile($filePath){
		switch (strtolower(CFileHelper::getExtension($filePath))){
			case 'png':
				$im = imagecreatefrompng($filePath);
				break;
			case 'gif':
				$im = imagecreatefromgif($filePath);
				break;
			case 'jpg':
			case 'jpeg':
				$im = imagecreatefromjpeg($filePath);
				break;
		}
		$rgb = @imagecolorat($im, 1, 1);
		return @imagecolorsforindex($im, $rgb);
	}
	
	
	/**
	 * produce an array of image width and height for the screens image file
	 * @return array
	 * [0] => image width in pixels
	 * [1] => image height in pixels
	 */
	public function getSize(){
		if($this->_size===null)
			$this->_size = getimagesize($this->getFile()->getPath());
		return $this->_size;
	}
	
	/**
	 * get the width of the screen image in pixels
	 */
	public function getWidth(){
		if($this->width != 0)
			return $this->width;
		$a = $this->getSize();
		return $a[0];
	}
	
	/**
	 * get the height of the screen image in pixels
	 */
	public function getHeight(){
		if($this->height != 0)
			return $this->height;
		$a = $this->getSize();
		return $a[1];
	}
	
	/**
	 * Gets the number of hotspots on the screen
	 * 
	 * @return integer
	 */
	public function getNumHotspots(){
		return ProjectHotSpot::model()->countByAttributes(array('screen_id'=>$this->id));
	}
	
	
	public function getNumTemplateHotspots(){
		$tIds = $this->getTemplatesAppliedIds();
		return ProjectHotSpot::model()->countByAttributes(array('template_id'=>$tIds));
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
	
	/**
	 * Get the total number of comments this screen has
	 * 
	 * @return integer 
	 */
	public function getNumComments(){
		return ProjectComment::model()->countByAttributes(array('screen_id'=>$this->id));
	}
	
	
	/**
	 * get all templates for this project
	 * @return array 
	 */
	public function getTemplates(){
		$templates = ProjectTemplate::model()->findAllByAttributes(array('project_id'=>$this->project_id));
		return $templates;
	}
	
	/**
	 * returns an array of template id's that are applied to this screen
	 * @return array 
	 */
	public function getTemplatesAppliedIds(){
		$ts = array();
		$appliedTs = ProjectScreenTemplate::model()->findAllByAttributes(array('screen_id'=>$this->id));
		foreach($appliedTs as $t){
			$ts[] = $t->template_id;
		}
		return $ts;
	}
	
	/**
	 * return all the hotspots applied to the screen through templates
	 * @param $onlyLinked if true only returns spots that have active links to other screens
	 * @return array 
	 */
	public function getTemplateHotspots($onlyLinked=false){
		$tIds = $this->getTemplatesAppliedIds();
		$condition = ($onlyLinked) ? 'screen_id_link != 0' : '';
		return ProjectHotSpot::model()->findAllByAttributes(array('template_id'=>$tIds),$condition);
	}
	
	/**
	 * get hotspots on this screen
	 * @param $onlyLinked if true only returns spots that have active links to other screens
	 * @return array 
	 */
	public function getHotspots($onlyLinked=false){
		$condition = ($onlyLinked) ? 'screen_id_link != 0' : '';
		return ProjectHotSpot::model()->findAllByAttributes(array('screen_id'=>$this->id,'template_id'=>0),$condition);
	}

	
	/**
	 * get all comments on this screen
	 * @return array 
	 */
	public function getComments(){
		// lets cache results of getcomments as its called a few times
		if($this->_comments === null)
			$this->_comments = ProjectComment::model()->findAllByAttributes(array('screen_id'=>$this->id));
		return $this->_comments;
	}
	
	
	/**
	 * delete all screens associated with a project
	 * @param int $project_id 
	 */
	public function deleteScreens($project_id){
		$ps = ProjectScreen::model()->findAllByAttributes(array('project_id'=>$project_id));
		foreach($ps as $s){
			$s->delete();
		}
	}
	
	public function afterDelete() {
		parent::afterDelete();
		// Delete the File image for this screen
		NFileManager::get()->deleteFile($this->file_id);
		// We need to delete the hostpots on this screen
		ProjectHotSpot::model()->deleteAllByAttributes(array('screen_id'=>$this->id), 'template_id = 0');
		// We also need to delete hotspots that link to this screen, or maybe make them zombie spots.
		ProjectHotSpot::model()->updateAll(array('screen_id_link'=>0),"screen_id_link = {$this->id}");
		// need to delete the template links to this screen
		ProjectScreenTemplate::model()->deleteAllByAttributes(array('screen_id'=>$this->id));
		
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
				'width'=>'int',
				'height'=>'int',
				// stored json serialized string of rgba background color
				'background'=>'string',
				'home_page'=>'bool',
				'sort'=>'int(5) NULL DEFAULT  \'0\' '
			),
			'keys'=>array(
				array('sort'),
				array('file_id'),
				array('project_id')
			),
		);
	}
	
	/**
	 * get the thumbnail url for the sidebar
	 * @return string 
	 */
	public function getImageUrlThumb(){
		return NHtml::urlImageThumb($this->file_id, 'projectSidebarThumb');
	}
	
	
	/**
	 * get the thumbnail url for select autocomplete box used
	 * by the hotspot form
	 * @return string 
	 */
	public function getImageUrlSelectThumb(){
		return NHtml::urlImageThumb($this->file_id, 'project-drop-down-48-crop');
	}

	public function getImageUrl(){
		return NHtml::urlFile($this->file_id, $this->name);
	}
	
	public function getAttributes() {
		$arr = parent::getAttributes();
		return array_merge($arr, array(
			'image_url_thumb_select'=>$this->getImageUrlSelectThumb(),
			'image_url_thumb'=>$this->getImageUrlThumb(),
			'image_url'=>$this->getImageUrl()
		));
	}

}