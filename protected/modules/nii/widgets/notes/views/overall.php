<div class="NNotes"
	 data-area="<?php echo $area; ?>" 
	 data-id="<?php echo $id; ?>">
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
	<div class="NNotes-list">
		<?php
		
		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_line',
			'viewData'=>array(
				'canEdit'=>$canEdit,
				'emptyText'=>'None',
				'canDelete'=>$canDelete,
				'displayUserPic'=>$displayUserPic)));
		?>
	</div>
</div>