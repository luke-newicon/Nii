<div id="<?php echo $id; ?>" class="NNotes" data-model-id="<?php echo $modelId; ?>">
	<div class="NNotes-input">
		<?php if($canAdd): ?>
			<?php $this->render(
				'_newItem',array(
					'displayUserPic'=>$displayUserPic,
					'profilePic'=>$profilePic,
					'id'=>$id)
				);
			?>
		<?php endif; ?>
	</div>
	<div>
		<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_line',
				'id'=>$id.'-notelist',
				'afterAjaxUpdate'=>'function(){$("#'.$id.'-notelist").NNotes("highlightNote");}',
				'emptyText'=>$this->emptyText,
				'htmlOptions'=>array('class'=>'list-view NNotes-list'),
				'summaryText'=>'',
				'viewData'=>array(
					'canEdit'=>$canEdit,
					'canDelete'=>$canDelete,
					'displayUserPic'=>$displayUserPic
				)
			));
		?>
	</div>
</div>