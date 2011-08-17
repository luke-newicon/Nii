<div class="line newNote">
	<?php if(isset($this->displayUserPic)&&$this->displayUserPic):?>
		<div class="unit profilePic">
			<img src="<?php //echo $profilePic;?>" width="50"/>
		</div>
	<?php endif;?>
	<div class="unit note lastUnit">
		<p class="userInformation man">
			<?php echo yii::app()->getUser()->name;?>
		</p>
		<div class="markdownInput" style="display:none;">
			<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',
					array('name'=>$area.'_nnote','htmlOptions'=>array("class"=>"noteInput")));?>
			<div class="txtR">
				<input type="button" value="Cancel" class="btn btnN nnote-cancel-button">
				<input type="button" value="Add" class="btn btnN add add-note-button">
			</div>
		</div>
		<div class="newNoteBox">
			<div class="fakebox">New Note...</div>
		</div>
	</div>
</div>
<hr/>