<?php

Class ApiController extends RestController 
{
	
	/**
	 * load a Project model
	 * @param int $pid
	 * @return Project 
	 */
	public function loadProject($pid){
		$p = HotspotProject::model()->findByPk($pid);
		if($p===null)
			throw new CHttpException(404,"No project with id:$pid found");
		return $p;
	}
	
	public function actionList($model){
		$m = $this->modelLookup($model);
		$res = CActiveRecord::model($m)->findAll();
		$this->response($res);
	}
	
	/**
	 * The present implementation only creates a link once for each project
	 * called by api/link
	 */
	public function actionLink_list($projectId){
		$p = $this->loadProject($projectId);
		$this->response($p->getLink());
	}
	
	public function actionView($model, $id){
		$m = $this->modelLookup($model);
		$m = $this->modelLoad($m, $id);
		$this->response($m);
	}
	
	/**
	 * Handle a RESTful POST request (post requests instruct the API to create new records / resources).
	 * @param type $model 
	 */
	public function actionCreate($model){
		$m = $this->modelLookup($model);
		$m = new $m;
		if($m===null)
			throw new CHttpException (404,'no model found');

		$m->attributes = $this->getData();

		$m->save();
		$this->response($m);
	}
	/**
	 * handle a RESTfull UPDATE request
	 * @param type $model
	 * @param type $id 
	 */
	public function actionUpdate($model, $id){
		$m = $this->modelLookup($model);
		$m = $this->modelLoad($m,$id);
		
		$m->attributes = $this->getData();;
		$saved = $m->save();
		Yii::log("saved: $saved",'error');
		$this->response($m);
	}
	
	/**
	 * Handle RESTfull DELETE request
	 * @param type $model
	 * @param type $id 
	 */
	public function actionDelete($model, $id){
		$m = $this->modelLookup($model);	
		$m = $this->modelLoad($m,$id);
		$m->delete();
	}
	
	
	/**
	 * The following actions enable CRUD operations for models within the context of the project.
	 * E.g. api/hotspot/2/hotspot if sent as a post will create a new hotspot under project with id 2
	 */
	
	/**
	 * 
	 * @param type $pid
	 * @param type $model 
	 */
	public function actionProjectList($pid, $model){
		$m = $this->modelLookup($model);
		$this->loadProject($pid);
		$res = CActiveRecord::model($m)->findAllByAttributes(array('project_id'=>$pid));
		$this->response($res);
	}
	
	public function actionProjectView($pid, $model, $id){
		$this->actionView($model, $id);
	}

	public function actionProjectCreate($pid, $model){
		$this->actionCreate($model);
	}
	
	public function actionProjectUpdate($pid, $model, $id){
		$this->actionUpdate($model, $id);
	}
	
	public function actionProjectDelete($pid, $model, $id){
		$this->actionDelete($model, $id);
	}
	
	public function modelLoad($model, $id){
		$model = CActiveRecord::model($model)->findByPk($id);
		if($model===null)
			throw new CHttpException (404,'no model found');
		return $model;
	}
	
	public function modelLookup($model){
		$mr = $this->modelResources();
		if(array_key_exists($model, $mr)){
			return $mr[$model];
		}
		return $model;
	}
	
	public function modelResources(){
		return array(
			'link'=>'ProjectLink',
			'screen'=>'ProjectScreen',
			'hotspot'=>'HotspotHotspot',
		);
	}
	
	/**
	 * gets the request data
	 * 
	 * @return array 
	 */
	public function getData(){
		// if the request is formatted as json!
		// Yii::app()->request->getAcceptTypes() // make sure we are dealing with json
		if(Yii::app()->request->getIsPutRequest() || Yii::app()->request->getIsPostRequest()){
			// asumming json passed so
			$data = file_get_contents('php://input');
			return CJSON::decode($data);
		}
	}
	
	public function response($data, $status = 200, $contentType = 'application/json'){
		// should use the content-type header or the url suffix to determine the output format
		// var_export($data, TRUE);
		// header("Content-Type: $contentType");
		echo CJSON::encode($data);
	}
	
	
	
}