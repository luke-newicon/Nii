<div id="message"></div>
<div class="head">
	<?php if (!Yii::app()->user->isGuest) { ?>
	<div class="menu">
		<?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu,'id'=>'mainMenu')); ?>
		<?php 
		/**
		 * Display the 'Actions' drop-down menu if items have been specified in the controller action
		 */
//		if ($this->actionsMenu) {
//			$s = '<span class="icon fam-bullet-arrow-down" style="float: right"></span>'.$this->t('Actions');
//			$actionsMenu =  array(
//				array('label' => $s, 'url' => '#', 'items'=>$this->actionsMenu, 'linkOptions' => array(
//						'class' => 'actionsTitle',
//						'onclick'=>'return false;',
//					),
//				),
//			);
//			$this->widget('zii.widgets.CMenu', array('items' => $actionsMenu, 'htmlOptions'=>array('class'=>'actionsMenu'), 'encodeLabel'=>false));
//		}
		?>
	</div>
	<div class="subMenu"></div>
	<?php } ?>
</div>