<?php

class ActivityFeedPortlet extends NPortlet {

	public $title = '<h3>Activity Feed</h3>';
	public $limit = 20;
	public $logModels = "'HftContact','HftDonation','HftEvent'";
//	public $contentCssClass='portlet-body h300 overflow-scroll mbs';

	protected function renderContent() {
		
		$logs = NActiveRecord::model('NLog')->findAll(array('condition' => "model IN (".$this->logModels.")",'limit' => $this->limit, 'order'=>'datetime DESC, id DESC', 'group' => 'CONCAT(model, model_id, DATE_FORMAT(datetime, "%d%M%Y"),controller,action)'));
		$notes = NActiveRecord::model('HftContactNote')->findAll(array('limit' => $this->limit, 'order'=>'added DESC, id DESC'));
		
		$feed=array();
		
		if ($logs) {
			foreach ($logs as $log) {
				
				switch($log->model) {
					case "HftContact" :
						$icon = 'fam-user ';
						break;
					case "HftDonation" :
						$icon = 'fam-money ';
						break;
					case "HftEvent" :
						$icon = 'fam-calendar ';
						break;
				}
				
				$feed[$log['datetime'].'_'.rand(10,10)] = array(
					'activity' => $log['description'] . ' &mdash; ' . NHtml::link('View',array('/'.$log->controller.'/view', 'id'=>$log->model_id)),
					'user'=>$log->user->username,
					'icon' => '<span class="icon '.$icon.'">&nbsp;</span>',
				);
			}
		}
		if ($notes) {
			foreach ($notes as $note) {
				switch($note->model) {
					case "HftContact" :
						$model = 'Contact ';
						$model_name = $note->contact->name;
						$controller = 'contact/admin';
						break;
					case "HftDonation" :
						$model = 'Donation ';
						$model_name = '&pound;'.$note->donation->donation_amount;
						$controller = 'hft/donation';
						break;
					case "HftEvent" :
						$model = 'Event ';
						$model_name = $note->event->name;
						$controller = 'hft/event';
						break;
					default :
						$model = $model_name = $controller = '';
				}
				$feed[$note->added.'_'.rand(10,10)] = array(
					'activity' => $model.'note (<strong>'.$model_name.'</strong>): '.$note->note . ' &mdash; ' . NHtml::link('View',array('/'.$controller.'/view/id/'.$note->model_id.'#Notes')), 
					'user'=>$note->user->username,
					'icon' => '<span class="icon fam-page-white-text">&nbsp;</span>',
				);
			}
		}
		
		krsort($feed);
		$count=0;
		if($feed){
			echo '<table class="condensed-table mbn">';
			echo '<thead><tr><th></th><th>Activity</th><th>User</th><th>Date</th></tr></thead><tbody>';
			foreach ($feed as $datetime =>$f) {
				$count++; if ($count>$this->limit) continue;
				$dt = explode('_', $datetime);
				echo '<tr>';
				echo '<td>'.$f['icon'].'</td>';
				echo '<td>'.$f['activity'].'</td>';
				echo '<td style="white-space:nowrap;">'.$f['user'].'</td>';
				echo '<td style="white-space:nowrap;">'. NHtml::formatDate($dt[0], 'd-m-y').' <small style="color:#999; font-size: 10px;">'. NHtml::formatDate($dt[0], 'H:i').'</small></td>';
				echo '</tr>';
			}
			echo '</tbody></table>';
		}
	}
	

}