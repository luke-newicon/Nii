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
		$this->render('index');
	}

	public function actionApe(){
		$url = $this->getModule()->getAssetsUrl();
		Yii::app()->clientScript->registerScriptFile("$url/ape/JavaScript.js");
		Yii::app()->clientScript->registerScriptFile("$url/ape/config.js");
		$this->render('ape');
	}
	
	public function actionTalkToApe($message, $channel='sysmsg'){
		$host = Yii::app()->request->getHostInfo();
		// are we on local test server?
		if(strpos($host, 'local.ape-project.org') ){
			$APEserver = 'http://local.ape-project.org:6969/?';
		}else{
			$APEserver = 'http://ape.newicon.org:6969/?';
		}
		
		$APEPassword = 'testpasswd';

		$cmd = array(array( 
		  'cmd' => 'inlinepush', 
		  'params' =>  array( 
			  'password'  => $APEPassword, 
			  'raw'       => 'data', 
			  'channel'   => $channel, 
			  //Note: data can't be a string 
			  'data'      => array( 
				  'msg' => $message
			  ) 
		   ) 
		)); 

		
		$data = file_get_contents($APEserver.rawurlencode(json_encode($cmd))); 
		var_dump($APEserver.rawurlencode(json_encode($cmd)));
		echo $data;
	}
	
	public function actionWebcam(){
		$url = $this->getModule()->getAssetsUrl();
		Yii::app()->clientScript->registerScriptFile("$url/swfobject.js");
		$this->render('webcam',array('url'=>$url));
	}
	public function actionWebcamSave(){
		if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
			$jpg = $GLOBALS["HTTP_RAW_POST_DATA"];
			$img = $_GET["img"];
			$filename = "images/poza_". mktime(). ".jpg";
			file_put_contents($filename, $jpg);
		} else{
			echo "Encoded JPEG information not received.";
		}
	}
	
	public function actionInstall(){
		Yii::app()->install();
	}
}