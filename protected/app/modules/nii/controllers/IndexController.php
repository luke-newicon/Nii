<?php

/**
 * Description of Index
 *
 * @author matthewturner
 */
class IndexController extends AController
{
	
	public function accessRules() {
		return array(
			array('allow',
				'expression' => '$user->checkAccessToRoute()',
			),
			array('allow',
				'actions' => array('attachments'),
				'users'=>array('?'),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}
	
	public function actions(){
		return array(
			'markdownPreview'=>'modules.nii.widgets.markdown.NMarkdownAction',
			'notes'=>'modules.nii.widgets.notes.NNotesAction',
			'attachments'=>'modules.nii.widgets.attachments.NAttachmentsAction',
			'relationships'=>'modules.nii.widgets.relationships.NRelationshipsAction',
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
		exit;
	}
	


	public function actionHeartbeat(){
		// this is called to force the session to stay open
		echo json_encode(array('success'=>true));
	}
	
	
	public function actionTrash($model, $model_id, $name, $returnUrl, $successMsg=null) {
		$trash = new $model;
		$trash = $trash->findByPk($model_id);
		if ($trash) {
			$trash->trashed = '1';
			if ($trash->save(false)) {
				Yii::app()->user->setFlash('success', ($successMsg ? $successMsg : $this->t('Successfully deleted '.$name.' details')));
				$this->redirect(str_replace('.','/',$returnUrl));
			} else {
				echo 'Error';
			}
		}
	}
	
	public function actionFileNameWithIcon($id) {
		$file = NFileManager::get()->getFile($id);
		$iconClass = NHtml::getMimeTypeIcon($file->mime);
		echo '<span class="'.$iconClass.'"></span>'.$file->original_name;
	}
	
}
