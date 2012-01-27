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
class TaskController extends AController {

	public function actionIndex() {
		
		$allTasks = NActiveRecord::model('ProjectTask')->findAll();
		$tasks = CJSON::encode($allTasks);
		$this->render('index', array('tasks'=>$tasks));
	}
	
	
	/**
	 * Handle a RESTful POST request (post requests instruct the API to create new records / resources).
	 * @param type $model 
	 */
	public function actionCreate(){
		$m = 'ProjectTask';
		$m = new $m;
		if($m===null)
			throw new CHttpException (404,'no model found');

		$m->attributes = $this->getRESTData();

		$m->save();
		$this->RESTResponse($m);
	}
	/**
	 * handle a RESTful UPDATE request
	 * @param type $model
	 * @param type $id 
	 */
	public function actionUpdate($id){
		$m = 'ProjectTask';
		$m = $this->modelLoad($m,$id);
		
		$m->attributes = $this->getRESTData();
		$saved = $m->save();
		$this->RESTResponse($m);
	}
	
	/**
	 * Handle RESTful DELETE request
	 * @param type $model
	 * @param type $id 
	 */
	public function actionDelete($id){
		$m = 'ProjectTask';	
		$m = $this->modelLoad($m,$id);
		$m->delete();
	}


}