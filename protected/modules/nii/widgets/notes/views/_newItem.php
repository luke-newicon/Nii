<div class="line newNote" data-model="<?php echo $area; ?>" data-id="<?php echo $id; ?>" data-ajaxLoc="<?php echo $ajaxController ?>">
	<?php if($this->displayUserPic): ?>
		<div class="unit profilePic">
			<img src="<?php echo $profilePic ?>"/>
		</div>
	<?php endif; ?>
	<div class="unit userInformation">
		<p>Now</p>
		<p><?php echo yii::app()->getUser()->name ?></p>
	</div>
	<div class="unit note">
		<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('name'=>$area.'_nnote')); ?>
		<input type="text" class="newNoteBox" value="New Note..." />
	</div>
	<div class="unit lastUnit buttons">
		<input type="button" value="Add" class="btn btnN add">
	</div>
</div>
<hr/>