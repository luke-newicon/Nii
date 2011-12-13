<div class="page-header">
	<h2>Preview Your Email</h2>
	<div class="action-buttons">
		<?php echo NHtml::link('Send', array('send','id'=>$model->id), array('class'=>'btn primary')) . '&nbsp;'; ?>		
	</div>
</div>
<div class="email-campaign-details">
	<div class="container pull-left">
		<div class="line field">
			<div class="unit w140">Recipients</div>
			<div class="lastUnit w500">
				<?php echo $model->listRecipients(); ?>
			</div>
		</div>
		<div class="line field">
			<div class="unit w140">Subject</div>
			<div class="lastUnit w500">
				<div class="input">
					<?php echo $model->subject; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="line field">
		<div class="lbl">Email Content</div>
		<div class="line">
			<div class="input">
				<?php echo $model->content; ?>
			</div>
		</div>
	</div>
	<div class="actions">
		<?php echo NHtml::link('Send', array('send','id'=>$model->id), array('class'=>'btn primary')) . '&nbsp;'; ?>		
	</div>
</div>