<?php

Yii::import('app.vendors.phpQuery.phpQuery');

class DocController extends AController {
	
	public function dataType($type){
		$types = array(
			'Integer' => 'int',
			'String' => 'string',
			'Decimal' => 'float',
			'Boolean' => 'boolean',
			'DateTime' => 'string',
		);
		$classes = $this->classMap();
		$type = isset($classes[$type]) ? $classes[$type] : $type;
		if(array_key_exists($type, $types)){
			$type = $types[$type];
		}
		return $type;
	}
	
	public function classMap(){
		return Yii::app()->kashflow->classmap;
	}

	public function createFunction($page) {
		phpQuery::newDocumentFile($page);
		
		$fn = trim(end(explode('-',pq('.m1H')->html())));
		$description = explode('<br>', pq('.m1B_lj p:first')->html());
		$params = array();
		$returns = array();
		
		foreach(pq('.m1B_lj table tr') as $row){
			$type = pq($row)->find('td:first strong')->html();
			if($type == 'IN'){
				$param_name = pq($row)->find('.mnl_varName')->html();
				$param_type = pq($row)->find('.mnl_varType')->html();
				$param_description = pq($row)->find('td:last')->html();
				$params[] = array(
					'name' => $param_name,
					'datatype' => $this->dataType($param_type),
					'description' => trim(str_replace(array('<br>','<br/>'), '', $param_description)),
				);
			} elseif($type == 'RETURNS'){
				$return_name = pq($row)->find('.mnl_varName')->html();
				$return_type = pq($row)->find('.mnl_varType')->html();
				$return_description = pq($row)->find('td:last')->html();
				$returns[] = array(
					'name' => $return_name,
					'datatype' => $return_type,
					'description' => trim($return_description),
				);
			}
		}
		
		echo '<pre>';
		echo "/**\n";
		foreach($description as $line){
			if(trim($line))
				echo " * ".trim($line)."\n";
		}
		foreach($params as $param)
			echo " * @param ".$param['datatype']." $".$param['name']." ".$param['description']."\n";
		foreach($returns as $return)
			echo " * @return ".$this->dataType($return['datatype']).($return['name']?" $".$return['name']:'')." ".$return['description']."\n";
		echo " */\n";
		echo 'public function '.$fn.'(';
		$tp = $params;
		foreach($params as $param){
			echo '$'.$param['name'].(next($tp)?', ':'');
		}
		echo "){\n    ";
		if(!empty($return))
			echo 'return ';
		echo '$this->request(\''.$fn.'\'';
		if(!empty($params)){
			echo ", array(\n";
			foreach($params as $param)
				echo "        '".$param['name']."' => $".$param['name'].",\n";
			echo "    )";
		}
		echo ')';
		if(!empty($return)){
			echo '->'.$fn.'Result';
			$classes = $this->classMap();
			echo isset($classes[$return['datatype']]) ? '->'.$return['datatype'] : '';
		}
		echo ";\n}</pre>";
	}
	
	public function actionIndex(){
		phpQuery::newDocumentFile('http://accountingapi.com/manual.asp');
		$links = pq('#mr_manual_inner a');
		$loop = 0;
		foreach($links as $link){
			if($loop > 122 && $loop <= 143){
				$href = pq($link)->attr('href');
				if($href != '/manual_intro.asp' && $href != 'manual_methods_overview.asp'){
					$this->createFunction('http://accountingapi.com/'.$href);
				}
			}
			$loop++;
		}
	}
	
	public function actionClasses(){
		phpQuery::newDocumentFile('http://accountingapi.com/manual.asp');
		$links = pq('#mr_manual_inner a');
		$loop = 0;
		foreach($links as $link){
			if($loop > 143 && $loop <= 172){
				$href = pq($link)->attr('href');
				if($href != '/manual_intro.asp' && $href != 'manual_methods_overview.asp'){
					ob_start();
					$this->createClass('http://accountingapi.com/'.$href);
					$text = ob_get_clean();
					
				}
			}
			$loop++;
		}
	}
	
	public function createClass($page) {
		phpQuery::newDocumentFile($page);
		
		$class = trim(end(explode('-',pq('.m1H')->html())));
		$description = explode('<br>', pq('.m1B_lj p:first')->html());
		$params = array();
		
		$file = Yii::getPathOfAlias('app.runtime').'/Kashflow'.$class.".php";
		$fh = fopen($file, 'w');
		ob_start();
		
		$first = true;
		foreach(pq('.mnl_tbl2 tr') as $row){
			if($first){
				$first = false;
				continue;
			}
			$param_name = pq($row)->find('td:first strong')->html();
			$param_type = pq($row)->find('.mnl_varType')->html();
			$param_description = explode('<br>',pq($row)->find('td:last')->html());
			$params[] = array(
				'name' => $param_name,
				'datatype' => $this->dataType($param_type),
				'description' => $param_description,
			);
		}
		
		echo "/**\n * Kashflow".$class."\n * \n";
		foreach($description as $line){
			if(trim($line))
				echo " * ".trim($line)."\n";
		}
		echo " * \n";
		foreach($params as $param){
			echo " * @property ".$param['datatype']." $".$param['name'];
			$first = true;
			foreach($param['description'] as $desc_line){
				if(!$first)
					echo ' *';
				echo ' '.trim($desc_line)."\n";
				$first = false;
			}
		}
		echo " */\n";
		echo 'class Kashflow'.$class.' extends KashflowModel {';
		echo "\n\n}";
		
		$text = ob_get_clean();
		fwrite($fh, $text);
		fclose($fh);
	}

}