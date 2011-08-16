<div id="NNotes<?php echo $id;?>" class="NNotes" data-noteNumber="<?php echo $id;?>">
	<div class="NNotes-input">
			<?php if($canAdd): ?>
				<?php $this->render(
						'_newItem',array(
							'displayUserPic'=>$displayUserPic,
							'profilePic'=>$profilePic,
							'area'=>$area,
							'id'=>$id));?>
			<?php endif;?>
	</div>
	<div>
		<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'_line',
				'id'=>$id.'_notelist',
				'emptyText'=>'None',
				'htmlOptions'=>array('class'=>'list-view NNotes-list'),
				'viewData'=>array(
					'canEdit'=>$canEdit,
					'canDelete'=>$canDelete,
					'displayUserPic'=>$displayUserPic)));
		?>
	</div>
</div>