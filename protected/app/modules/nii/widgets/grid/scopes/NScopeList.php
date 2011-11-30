<?php

class NScopeList extends CWidget {

	public $htmlOptions;
	public $dataProvider;
	public $tag = 'div';
	public $separator = ' | ';
	public $scopes = array();
	public $displayScopesCount = true;
	public $displayCurrentScopeDescription = true;
	public $gridId;
	public $defaultScope = 'default';
	public $scopeUrl = '';
	
	public $enableCustomScopes = true;

	/**
	 * Initializes scopes by setting some default property values.
	 */
	public function init() {
		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();
		if (isset($this->scopes['default']))
			$this->defaultScope = $this->scopes['default'];
		if (isset($this->scopes['scopeUrl']))
			$this->scopeUrl = $this->scopes['scopeUrl'];
	}

	public function run() {
		$scopes = $this->createScopeItems();
		if (empty($scopes))
			return;
		echo CHtml::tag($this->tag, $this->htmlOptions, $scopes);
	}

	public function createScopeItems() {
		$render = '';
		$scopes = isset($this->scopes['items']) ? $this->scopes['items'] : null;
		
		$customScopes = '';
		
		if ($this->enableCustomScopes==true) {
			$customScopes = Setting::model()->findAllByAttributes(array(
				'type' => 'custom_scope',
				'setting_name' => $this->gridId,
				'user_id' => Yii::app()->user->record->id,
			));
		}
		
		$render .= '<ul class="scopes pills">';
		if ($scopes) {
			$class = ' first';
			foreach ($scopes as $scope => $label) {
				$description = '';
				if (is_array($label)) {
					if (array_key_exists('description', $label))
						$description = $label['description'];
					if (array_key_exists('label', $label))
						$label = $label['label'];
					else
						$label = ucfirst($scope);
				}
				if ($this->dataProvider->getCurrentScope() == $scope) {
					$class.=' active';					
				}
				$count = ($this->displayScopesCount) ? ' <span class="count">(' . $this->dataProvider->countScope($scope) . ')' : '';
				$render .= '<li class="' . $scope . $class . ((!next($scopes) && !$customScopes) ? ' last' : '') . '">';
				$class = '';
				$htmlOptions = array('href' => $this->makeScopeUrl($scope));
				
				$render .= CHtml::openTag('a', $htmlOptions) . $label . $count . '</span></a>';
//				if ($this->separator && (next($this->scopes['items']) || $customScopes))
//					$render .= $this->separator;
				$render .= '</li>';
			}
		}

		if ($this->enableCustomScopes==true) {

			if (!$scopes)
				$class = ' first';
			if ($customScopes) {
				$customScopesCount = Setting::model()->countByAttributes(array(
					'type' => 'custom_scope',
					'setting_name' => $this->gridId,
					'user_id' => Yii::app()->user->record->id,
				));
				$c = 1;
				foreach ($customScopes as $customScope) {
					$count = ($this->displayScopesCount) ? ' <span class="count">(' . $this->dataProvider->countCustomScope($customScope) . ')' : '';
					$f = CJSON::decode($customScope->setting_value);
					$render .= '<li class="custom-scope ' . $class . '" id="scope-'.$customScope->id.'">';
					$class = '';
					$htmlOptions = array('href' => $this->makeScopeUrl($customScope->id));
					if ($this->dataProvider->getCurrentScope() == $customScope->id) {
						$htmlOptions['class'] = 'current';
						$currentScopeType = 'custom';
						$currentScope = $customScope;
						$fields = $f;
					}
					$render .= CHtml::openTag('a', $htmlOptions) . $f['scopeName'] . $count . '</a>';
					if ($this->separator && ($c < $customScopesCount)) 
						$render .= $this->separator;	
					
					
//					$render .= '<span class="scopeEditButtons">';
//					$render .= NHtml::btnLink('', '#', 'icon fam-pencil block-icon', array(
//						'onclick'=>$this->editCustomScopeDialog(array(
//							'model' => get_class($this->dataProvider->model),
//							'controller' => Yii::app()->controller->uniqueid,
//							'action' => Yii::app()->controller->action->id,
//							'id'=>$customScope->id,
//						))
//					));
//					$render .= NHtml::btnLink('', '#', 'icon fam-delete block-icon', array(
//						'onclick'=>$this->deleteCustomScope($customScope->id, $this->gridId),
//					));
//					$render .= '</span>';
					$render .= '</li>';
					$c++;
				}
			}

			$render .= '<li class="addCustomScope last">';
			$render .= NHtml::btnLink('', '#', 'icon fam-add', array(
						'onclick' => $this->addCustomScopeDialog(array(
							'model' => get_class($this->dataProvider->model),
							'controller' => Yii::app()->controller->uniqueid,
							'action' => Yii::app()->controller->action->id,
						)),
						'title' => 'Add a Custom Scope',
					));
			$render .= '</li>';
			
//			$render .= $this->scopeLinkHover();
		}
		$render .= '</ul>';
		
		if ($this->displayCurrentScopeDescription) {
			
			if (isset($currentScopeType) && $currentScopeType=='custom') {
				$op = $fields['match'];
				$rules = array();
				
				if ($fields['scopeDescription'] && $fields['scopeDescription']!='') 
					$customScopeDescription = $fields['scopeDescription'];
				else {
					$cs = new CustomScope;
					$model = new $fields['formModel'];
					foreach ($fields['rule'] as $rule) {
						$method = '';
						foreach ($cs->searchMethods as $sm) {
							if ($sm['value'] == $rule['searchMethod'])
								$method = $sm['label'];
						}
						$rules[] = "'".$model->getAttributeLabel($rule['field'])."'" . " " . $method . " '" . $rule['value']."'";
					}
				}
				
//				$currentDescription .= '<span style="color: #666; float: left; display: block; margin-right: 5px;">Custom Scope</span>';
				
				$currentDescription .= '<span style="float: left; display: block; margin-right: 15px;">';
				if (isset($customScopeDescription)) {
					$currentDescription .= $customScopeDescription;
				} else {
					$currentDescription .= '<span style="color: #666;">Rules: </span>';
					$currentDescription .= implode(' <small>'.$op.'</small> ', $rules);
				}
				$currentDescription .= '</span>';
				
				$currentDescription .= '<span class="scopeEditButtons">';
				$currentDescription .= NHtml::btnLink('', '#', 'icon fam-pencil block-icon', array(
					'onclick'=>$this->editCustomScopeDialog(array(
						'model' => get_class($this->dataProvider->model),
						'controller' => Yii::app()->controller->uniqueid,
						'action' => Yii::app()->controller->action->id,
						'id'=>$currentScope->id,
					))
				));
				$currentDescription .= NHtml::btnLink('', '#', 'icon fam-delete block-icon', array(
					'onclick'=>$this->deleteCustomScope($currentScope->id, $this->gridId),
				));
				$currentDescription .= '</span>';
				
			}
			
			if (isset($currentDescription) && $currentDescription != '')
				$render .= '<div class="scopeDescription" style="clear:both; overflow:hidden;">'.$currentDescription.'</div>';
		}

		return $render;
	}

	public function makeScopeUrl($scope) {
		if ($scope == $this->defaultScope)
			return Yii::app()->getController()->createUrl($this->scopeUrl);
		else
			return Yii::app()->getController()->createUrl($this->scopeUrl, array($this->dataProvider->scopeVar => $scope));
	}

	public function addCustomScopeDialog($params=array()) {
		$dialog_id = 'customScopeDialog';
		$controller = str_replace('/','.',$params['controller']);
		$action = str_replace('/','.',$params['action']);
		$url = CHtml::normalizeUrl(array('/nii/grid/customScopeDialog/', 'controller' => $controller, 'action' => $action, 'model' => $params['model']));
		return '$("#' . $dialog_id . '").dialog({
			open: function(event, ui){
				$("#' . $dialog_id . '").load("' . $url . '");
			},
			minHeight: 100, position: ["center", 100],
			width: 600,
			autoOpen: true,
			title: "Custom Scope",
			modal: true,
		});
		return false;';
	}
	
	public function editCustomScopeDialog ($params=array()) {
		$dialog_id = 'customScopeDialog';
		$controller = str_replace('/','.',$params['controller']);
		$action = str_replace('/','.',$params['action']);
		$url = CHtml::normalizeUrl(array('/nii/grid/customScopeDialog/', 'id'=>$params['id'], 'controller' => $controller, 'action' => $action, 'model' => $params['model']));
		return '$("#' . $dialog_id . '").dialog({
			open: function(event, ui){
				$("#' . $dialog_id . '").load("' . $url . '");
			},
			minHeight: 100, position: ["center", 100],
			width: 600,
			autoOpen: true,
			title: "Custom Scope",
			modal: true,
		});
		return false;';
	}
	
	public function deleteCustomScope ($id, $gridId) {
		$url = CHtml::normalizeUrl(array('/nii/grid/deleteCustomScope/', 'id'=>$id));
		return '$(function(){
			if (confirm("Are you sure you wish to delete this scope?")) {
				$.ajax({
					url: "'.$url.'",
					dataType: "json",
					type: "get",
					success: function(response) {
						$.fn.yiiGridView.update("'.$gridId.'");
						showMessage(response.success);
					}
				});
			}
		});
		return false;';
	}
	
	public function scopeLinkHover() {
		Yii::app()->getClientScript()->registerScript('gridscopes',"
			
			window.gridscopes = {
				gridTimer:null,
				showButtons:function(id) {
					$('#'+id+' .scopeEditButtons').fadeIn();
				},
				hideButtons:function(id) {
					$('#'+id+' .scopeEditButtons').fadeOut();
				}
			}
	
			$('body').delegate('.custom-scope','mouseenter',function() {
				id = $(this).attr('id');
				clearTimeout(window.gridscopes.gridTimer);
				window.gridTimer = setTimeout('window.gridscopes.showButtons(id)',1000);
			});
			
			$('body').delegate('.custom-scope','mouseleave',function(e) {
				console.log(e);
				id = $(this).attr('id');
				clearTimeout(window.gridscopes.gridTimer);
				window.gridTimer = setTimeout('window.gridscopes.hideButtons(id)',200);
			});	
		");
	}
}