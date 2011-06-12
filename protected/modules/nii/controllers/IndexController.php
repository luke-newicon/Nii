<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author matthewturner
 */
class IndexController extends NController
{
	public function actions(){
		return array(
			'markdownPreview'=>'modules.nii.widgets.markdown.NMarkdownAction',
			'NNotes'=>'modules.nii.widgets.notes.NNotesAction'
		);
	}
	
	/**
	 * controller action for the NFileManager
	 * 
	 * @see NFileManager::displayFile
	 */
	public function actionFile($id,$name='myfile',$downloadable=false){
		NFileManager::get()->displayFile($id, $name, $makeDownload);
	}
	
	/**
	 * controller action for the fileManager
	 * 
	 * @param int $id file manager id of file
	 * @param string $size the image thumb size (defined in NImage thumbs array. e.g. 'small') or
	 * a custom string of xy-100-122 (walk before you run) 100=x and 122 = y
	 */
	public function actionShowThumb($id,$size){
		$this->layout = 'ajax';
		NImage::get()->actionShowThumb($id, $size);
		Yii::app()->end();
	}
	
	public function actionInstall(){
		Yii::app()->install();
	}
	
}
?>
