<div class="newNote">
	<?php if(isset($this->displayUserPic)&&$this->displayUserPic):?>
		<div class="unit profilePic">
			<?php //Yii::app()->user-> ?>
		</div>
	<?php endif;?>
	<div class="unit note lastUnit">
		<div class="markdownInput" style="display:none;">
			<div class="field">
				<?php $this->widget('modules.nii.widgets.markdown.NMarkdownInput',
						array('name'=>$id.'-nnote','htmlOptions'=>array("class"=>"noteInput input", "style"=>"width: 100%")));?>
				<div class="txtR">
					<input type="button" value="Cancel" class="btn nnote-cancel-button">
					<input type="button" value="Add" class="btn primary add add-note-button">
				</div>
			</div>
		</div>
		<div class="newNoteBox">
			<?php echo $this->addNoteButtonHtml; ?>
		</div>
	</div>
</div>