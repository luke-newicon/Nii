<?php
/**
 * Dashboard class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of Dashboard
 *
 * @author steve
 */
class DashboardController extends NiiController
{
	
	

    public function actionIndex(){
		$u = User::model()->findByPk(Yii::app()->user->getId());
		$this->render('/dashboard/index',array('u'=>$u));
	}
}