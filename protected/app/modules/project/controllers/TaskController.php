<?php

/**
 * ProjectController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of TaskController
 *
 * @author steve
 */
class TaskController extends AController
{
	/**
	 * 
	 * @param int $id task id
	 */
	public function actionIndex($id)
	{
		$t = $this->loadTask($id);
		$this->render('index', array('task'=>$t));
	}
	
	/**
	 * Load in a task by id if it does ot exist then throw a http error
	 * @param int $id
	 * @return ProjectTask
	 * @throws CHttpException 
	 */
	public function loadTask($id)
	{
		$t = ProjectTask::model()->findByPk($id);
		if($t===null)
			throw new CHttpException('This task does not exist');
		return $t;
	}
}