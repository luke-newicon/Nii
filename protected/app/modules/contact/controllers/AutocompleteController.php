<?php

class AutocompleteController extends Controller {

	/**
	 *
	 * @param string $term - the query itself
	 * @param string $wildcard - options are both|left|right|exact
	 * @param string $type - any limiting factors
	 */
	public function actionContactList($term=null, $wildcard='both', $type=null, $condition=null) {
		if ($term) {
			
			if ($type) {
				$type = " AND contact_type='".$type."'";
			}
			
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
			
			$contacts = Contact::model()->findAll(
				array(
					'condition'=>"name ".$term.$type,
					'limit'=>30,
				)
			);
			$return = array();
			if ($contacts) {
				foreach ($contacts as $contact) {
					$result['id'] = $contact['id'];
					$result['label'] = $contact['name'];
					$result['value'] = $contact['name'];
					$result['name'] = $contact['name'].'|'.$contact['salutation'].'|'.$contact['lastname'].'|'.$contact['title'];
					array_push($return, $result);
				}
				
				echo CJSON::encode($return);
				Yii::app()->end();
			}
		}
	}
	
	public function actionDioceseList($term=null, $wildcard='both') {
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
			
			$dioceses = Diocese::model()->findAll(
				array(
					'condition'=>"diocese_index ".$term.$type,
					'limit'=>30,
				)
			);
			$return = array();
			if ($dioceses) {
				foreach ($dioceses as $diocese) {
					$result['id'] = $diocese['id'];
					$result['label'] = $diocese['diocese_index'];
					$result['value'] = $diocese['diocese_index'];
					$result['name'] = $diocese['diocese_index'];
					array_push($return, $result);
				}
				
				echo CJSON::encode($return);
				Yii::app()->end();
			}
		}
	}
	
}