<?php

/**
 * DetailsController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Project details controller.
 * This controller handles requests for specific project
 *
 * @author steve
 */
class DetailsController extends AController
{
	public function actionIndex($id) {
		$project = TaskProject::model()->findByPk($id);
		if ($project === null)
			throw new CHttpException('Oops no project exists here');

		$this->render('index', array('project' => $project));
	}
}