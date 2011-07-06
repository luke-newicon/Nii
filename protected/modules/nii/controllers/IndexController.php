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
	public function actionFile($id,$name='',$makeDownload=false){
		NFileManager::get()->displayFile($id, $name, $makeDownload);
	}
	
	/**
	 * controller action for the fileManager
	 * 
	 * @param int $id file manager id of file
	 * @param string $size the image thumb size (defined in NImage thumbs array. e.g. 'small')
	 */
	public function actionShow($id,$type){
		$this->layout = 'ajax';
		NImage::get()->show($id, $type);
		Yii::app()->end();
	}
	
	public function actionInstall(){
		Yii::app()->install();
	}
	
}
?>
