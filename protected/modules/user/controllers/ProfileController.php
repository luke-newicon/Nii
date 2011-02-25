<?php
/**
 * ProfileController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ProfileController
 *
 * @author steve
 */
class ProfileController extends NController
{

    public function actionIndex(){
		$this->render('/profile/index');
	}
}