<?php

/**
 * DocsController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of DocsController
 *
 * @author steve
 */
class DocsController extends NController 
{
	public function acitonIndex(){
		
		$this->render('index');
	}
}