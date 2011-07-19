<div id="commentsForm"  class="spotForm" style="width:300px;display:none;" >
	<div style="position:relative;">
		<div class="triangle" style="left: -19px; top: 12px;position:absolute;"></div>
		<div class="form pas">
			<div id="commentForm">
				<div class="field" style="padding-bottom:0px;">
					<?php $this->widget('nii.widgets.markdown.NMarkdownInput',array('name'=>'comments','editButtonAttrs'=>array('class'=>'','style'=>'margin-right:5px;'), 'previewButtonAttrs'=>array('class'=>'','style'=>'margin-right:5px;'))); ?>
				</div>
				<div class="field">
					<button class="btn aristo primary save disabled">Save</button>
					<button class="btn aristo cancel">Cancel</button>
					<button class="btn aristo delete" >Delete</button>
				</div>
			</div>
			<div id="commentViewWrap" style="display:none;">
				<div id="commentView">
				</div>
				<div class="field">
					<button class="btn aristo edit">Edit</button>
					<button class="btn aristo close">Ok</button>
				</div>
			</div>
		</div>
	</div>
</div>