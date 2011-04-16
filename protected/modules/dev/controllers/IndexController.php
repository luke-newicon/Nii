<?php
/**
 * IndexController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of IndexController
 *
 * @author steve
 */
class IndexController extends Controller
{
	public function actionIndex(){
		
	}

	public function actionApe(){
		$this->render('ape');
	}
	
	public function actionTalkToApe($message){
		$APEserver = 'http://ape.newicon.org:6969/?';
		$APEPassword = 'testpasswd';

		$cmd = array(array( 
		  'cmd' => 'inlinepush', 
		  'params' =>  array( 
			  'password'  => $APEPassword, 
			  'raw'       => 'data', 
			  'channel'   => 'sysmsg', 
			  //Note: data can't be a string 
			  'data'      => array( 
				  'msg' => $message
			  ) 
		   ) 
		)); 

		var_dump($APEserver.rawurlencode(json_encode($cmd)));
		$data = file_get_contents($APEserver.rawurlencode(json_encode($cmd))); 

		if ($data == 'OK') {
			echo 'Message sent!';
		} else {
			echo 'Error sending message, server response is : <pre>'.$data.'</pre>';
		}
	}
}