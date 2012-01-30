<div class="page-header">
	<h2><?php echo $model->name ?></h2>
	<div class="action-buttons">
		<?php echo NHtml::link($this->t('Back to Projects'), array("index"),array('class'=>'btn'));?>
		<?php echo NHtml::link($this->t('Edit'), array("edit","id"=>$model->id),array('id'=>'project-edit-button', 'class'=>'btn primary'));?>
	</div>
</div>

<div class="container pull-left mbm">
	
	<div class="line detailRow mbm">
		<div class="unit size1of2">
			<div class="unit size1of3 detailLabel"><?=$this->t('Description')?></div>
			<div class="lastUnit"><?php echo $model->description; ?></div>
		</div>
		<div class="lastUnit">

		</div>
	</div>
	
	<div class="row">
		<div class="span4">
			<p class="hint">Customer:</p>
			<?php //echo $model->customerLink ?>
		</div>
		<div class="span2">
			<p class="hint">Manager:</p>
			<!-- widgetise into contact card thingyum -->
			<ul class="media-grid">
				<li><a href="#" title="Luke Spencer" data-content="Contact details?" rel="popover" id="spencagay" style="padding:3px;"><?php $this->widget('nii.widgets.Gravatar',array('email'=>'luke.spencer@newicon.net', 'size'=>36)); ?></a></li>
			</ul>
			<!-- fin -->
		</div>
		<div class="span3">
			<p class="hint">Members:</p>
			<ul class="media-grid">
				<li><a id="dandecock" href="#" title="Dan De Luca" data-content="Contact details?" rel="popover" style="padding:3px;" ><?php $this->widget('nii.widgets.Gravatar',array('email'=>'dan.deluca@newicon.net', 'size'=>36)); ?></a></li>
				<li><a id="robinwill" href="#" title="Robin Williams" data-content="Contact details?" rel="popover" style="padding:3px;"><?php $this->widget('nii.widgets.Gravatar',array('email'=>'robin.williams@newicon.net', 'size'=>36)); ?></a></li>
			</ul>
		</div>
		<div class="span3">
			<p class="hint">Shared:</p>
			<ul class="media-grid">
				<li><a id="steveo" href="#" title="Steve O'Brien" data-content="Contact details?" rel="popover" style="padding:3px;" ><?php $this->widget('nii.widgets.Gravatar',array('email'=>'steve@newicon.net', 'size'=>36)); ?></a></li>
			</ul>
		</div>
	</div>

</div>

	<?php 
	
	$this->widget('nii.widgets.NTabs', 
		array(
			'tabs' => array(
	//			'Relationships'=>array('ajax'=>array('generalInfo','id'=>$model->id), 'id'=>'relationships'),
				'Tasks'=>array('ajax'=>array('tasks','id'=>$model->id), 'id'=>'tasks', 'count'=>$model->countProjectTasks()),
				'Milestones'=>array('ajax'=>array('milestones','id'=>$model->id), 'id'=>'milestones'),
				'Files'=>array('ajax'=>array('files','id'=>$model->id), 'id'=>'files', 'count'=>NAttachment::countAttachments(get_class($model), $model->id)),
			),
			'options' => array(
//				'cache' => true,
			),
			'htmlOptions' => array(
				'id' => 'tabs',
//				'class' => 'vertical',
			)
		)
	); 
	
//	echo '<h3>Testing estimated time functions...</h3><br />' . 
//		'1 day = ' . NTime::setTimeInMinutes('1d') . '<br />' . 
//		'1 hour = ' . NTime::setTimeInMinutes('1') . '<br />' . 
//		'4 hours = ' . NTime::setTimeInMinutes('4 hours') . '<br />' . 
//		'900 hours (2 days) = ' . NTime::getTimeInMinutes(900);
	?>