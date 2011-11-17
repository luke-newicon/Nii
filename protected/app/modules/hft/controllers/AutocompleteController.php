<?php

class AutocompleteController extends Controller {

	/**
	 *
	 * @param string $term - the query itself
	 * @param string $wildcard - options are both|left|right|exact
	 * @param string $type - any limiting factors
	 */
	public function actionEventList($term=null, $wildcard='both', $condition=null) {
		if ($term) {
			
			switch ($wildcard) {
				case "both" :
					$term = " LIKE '%".$term."%'";
				break;
				case "left" :
					$term = " LIKE '%".$term."'";
				break;
				case "right" :
					$term = " LIKE '".$term."%'";
				break;
				case "exact" :
					$term = " = '".$term."'";
				break;
			}
			
			$events = HftEvent::model()->findAll(
				array(
					'condition'=>"name ".$term,
					'limit'=>30,
				)
			);
			$return = array();
			if ($events) {
				foreach ($events as $event) {
					$result['id'] = $event['id'];
					$result['label'] = $event['name'];
					$result['value'] = $event['name'];
					$result['name'] = $event['name'];
					array_push($return, $result);
				}
				
				echo CJSON::encode($return);
				Yii::app()->end();
			}
		}
	}
	
}