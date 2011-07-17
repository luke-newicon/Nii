<div class="line field" style="padding-bottom:0px;">
	<div class="unit"><?php $this->widget('nii.widgets.Gravatar',array('email'=>Yii::app()->user->record->email)); ?></div>
	<div class="lastUnit"></div>
</div>
<div class="field">
	<button class="btn aristo primary save disabled">Save</button>
	<button class="btn aristo cancel">Cancel</button>
	<button class="btn aristo delete" >Delete</button>
</div>