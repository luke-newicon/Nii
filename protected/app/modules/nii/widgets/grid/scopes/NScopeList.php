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
		$model = new $this->dataProvider->model;
		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();
		if (isset($model->gridScopes['default']))
			$this->defaultScope = $model->gridScopes['default'];		
		elseif (isset($this->scopes['default']))
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
		$model = new $this->dataProvider->model;
		$render = '';
		$scopes = isset($model->gridScopes['items']) ? $model->gridScopes['items'] : (isset($this->scopes['items']) ? $this->scopes['items'] : null);
		$scopeCount = count($scopes);
		
		$twipsy=false;
		
		if ($this->enableCustomScopes==true) {
			$key = 'custom_scope_'.$this->gridId;
			$customScopes = Yii::app()->user->settings->get($key,array());
			$scopeCount = $scopeCount + count($customScopes);
		}
		
		$btnGroup = ($scopeCount>1) ? ' btngroup' : '';
		$render .= '<ul class="scopes'.$btnGroup.'">';
		if ($scopes) {
			$class = ' first';
			foreach ($scopes as $scope => $label) {
				$class .= ' btn';
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
					$currentDescription = $description;
				}
				$count = ($this->displayScopesCount) ? ' <span class="count">(' . $this->dataProvider->countScope($scope) . ')' : '';
				$render .= '<li class="' . 'scope-'.$scope . $class . ((!next($scopes) && !isset($customScopes)) ? ' last' : '') . '">';
				$class = '';
				$htmlOptions = array('href' => $this->makeScopeUrl($scope));
				if ($description) {
					$twipsy=true;
					$htmlOptions['title'] = $description;
					$htmlOptions['class'] = 'twipsy-button';
				}
				
				$render .= CHtml::openTag('a', $htmlOptions) . $label . $count . '</span></a>';
//				if ($this->separator && (next($this->scopes['items']) || $customScopes))
//					$render .= $this->separator;
				$render .= '</li>';
			}
		}

		if ($this->enableCustomScopes==true) {

			if (!$scopes)
				$class = ' first';
			if (isset($customScopes)) {
				$customScopesCount = count($customScopes);
				$c = 1;
				foreach ($customScopes as $id=>$customScope) {
					$class .= ' btn';
					$count = ($this->displayScopesCount) ? ' <span class="count">(' . $this->dataProvider->countCustomScope($customScope) . ')' : '';
					$f = $customScope;
					if ($this->dataProvider->getCurrentScope() == $id) {
						$class .= ' active';
						$currentScopeType = 'custom';
						$currentScope = $customScope;
						$customScopeDescription = $customScope['scopeDescription'];
						$currentScopeId = $id;
						$fields = $f;
					}
					$render .= '<li class="custom-scope ' . $class . '" id="scope-'.$id.'">';
					$class = '';
					$htmlOptions = array('href' => $this->makeScopeUrl($id));
					if (isset($customScope['scopeDescription'])) {
						$twipsy=true;
						$htmlOptions['title'] = $customScope['scopeDescription'];
						$htmlOptions['class'] = 'twipsy-button';
					}
					$render .= CHtml::openTag('a', $htmlOptions) . $f['scopeName'] . $count . '</a>';
					$render .= '</li>';
					$c++;
				}
			}

			$render .= '</ul>';
			$render .= '<span class="addCustomScope">';
			$render .= NHtml::btnLink('', '#', 'icon fam-add', array(
						'onclick' => $this->addCustomScopeDialog(array(
							'model' => get_class($this->dataProvider->model),
							'controller' => Yii::app()->controller->uniqueid,
							'action' => Yii::app()->controller->action->id,
						)),
						'title' => 'Add a Custom Scope',
					));
			$render .= '</span>';
			
//			$render .= $this->scopeLinkHover();
		} else {
			$render .= '</ul>';
		}
		
		if ($this->displayCurrentScopeDescription) {
			
			if (isset($currentScopeType) && $currentScopeType=='custom') {
				$op = $fields['match'];
				$rules = array();
				
				if ($fields['scopeDescription'] && $fields['scopeDescription']!='') 
					$customScopeDescription = $fields['scopeDescription'];
				else {
					$cs = new NCustomScope;
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
				
				$currentDescription = '<span style="float: left; display: block; margin-right: 15px;">';
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
						'id'=>$currentScopeId,
					))
				));
				$currentDescription .= NHtml::btnLink('', '#', 'icon fam-delete block-icon', array(
					'onclick'=>$this->deleteCustomScope($currentScopeId, $this->gridId),
				));
				$currentDescription .= '</span>';
				
			}
			
			if (isset($currentDescription) && $currentDescription != '')
				$render .= '<div class="scopeDescription" style="clear:both; overflow:hidden;">'.$currentDescription.'</div>';
		}
		
		if ($twipsy==true)
			$render .= "<script>jQuery(function($){ $('.twipsy-button').tooltip({'placement':'below'});	});</script>";

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
		$gridId = $this->gridId;
		$url = CHtml::normalizeUrl(array('/nii/grid/customScopeDialog/', 'gridId'=>$gridId, 'model'=>$params['model']));
		$postUrl = CHtml::normalizeUrl(array('/nii/grid/updateCustomScope/', 'gridId'=>$gridId));
		return '$("#' . $dialog_id . '").dialog({
			open: function(event, ui){
				$("#' . $dialog_id . '").load("' . $url . '");
			},
			minHeight: 100, position: ["center", 100],
			width: 600,
			autoOpen: true,
			title: "Custom Scope",
			modal: true,
			buttons: [
				{
					text: "Save",
					class: "btn btn-primary",
					click: function(){
						$.ajax({
							url: "'.$postUrl.'",
							data: jQuery("#customScopeForm").serialize(),
							dataType: "json",
							type: "post",
							success: function(response){ 
								if (response.success) {
									$("#customScopeDialog").dialog("close");
									$.fn.yiiGridView.update("'.$gridId.'");
									showMessage(response.success);
								}
							},
							error: function() {
								alert ("JSON failed to return a valid response");
							}
						}); 
						return false;
					}
				}
			],
		});
		return false;';
	}
	
	public function editCustomScopeDialog ($params=array()) {
		$dialog_id = 'customScopeDialog';
		$gridId = $this->gridId;
		$url = CHtml::normalizeUrl(array('/nii/grid/customScopeDialog/', 'gridId'=>$gridId, 'id'=>$params['id'], 'model' => $params['model']));
		$postUrl = CHtml::normalizeUrl(array('/nii/grid/updateCustomScope/', 'gridId'=>$gridId, 'scopeId'=>$params['id']));
		return '$("#' . $dialog_id . '").dialog({
			open: function(event, ui){
				$("#' . $dialog_id . '").load("' . $url . '");
			},
			minHeight: 100, position: ["center", 100],
			width: 600,
			autoOpen: true,
			title: "Custom Scope",
			modal: true,
			buttons: [
				{
					text: "Save",
					class: "btn primary",
					click: function(){
						$.ajax({
							url: "'.$postUrl.'",
							data: jQuery("#customScopeForm").serialize(),
							dataType: "json",
							type: "post",
							success: function(response){ 
								if (response.success) {
									$("#customScopeDialog").dialog("close");
									$.fn.yiiGridView.update("'.$gridId.'");
									showMessage(response.success);
								}
							},
							error: function() {
								alert ("JSON failed to return a valid response");
							}
						}); 
						return false;
					}
				}
			],
		});
		return false;';
	}
	
	public function deleteCustomScope ($id, $gridId) {
		$url = CHtml::normalizeUrl(array('/nii/grid/deleteCustomScope/', 'id'=>$id, 'gridId'=>$gridId));
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