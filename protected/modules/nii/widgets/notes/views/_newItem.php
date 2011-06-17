<div class="line newNote">
	<?php if($this->displayUserPic): ?>
		<div class="unit profilePic">
			<img src="<?php echo $profilePic ?>" width="50"/>
		</div>
	<?php endif; ?>
	<div class="unit note lastUnit">
		<div class="markdownInput" style="display:none;">
			<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',array('name'=>$area.'_nnote')); ?>
			<div class="txtR"><input type="button" value="Add" class="btn btnN add"></div>
		</div>
		
		<div class="newNoteBox">
			<div class="fakebox">
				New Note...
			</div>
			<p class="userInformation man"><?php echo yii::app()->getUser()->name ?></p>
		</div>
	</div>
</div>
<hr/>