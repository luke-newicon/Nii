<div class="line note note<?php echo $data->id; ?>" data-noteid="<?php echo $data->id; ?>" data-model="<?php echo $data->model;?>" data-modelid="<?php echo $data->model_id;?>">
	<?php if($displayUserPic):?>
		<div class="unit profilePic prm">
			<?php echo User::model()->getProfileImage($data->user_id);?>
		</div>
	<?php endif;?>
	<div class="lastUnit">
		<div class="nnote-text">
		<?php
		$markdown = new NMarkdown();
		echo $markdown->transform($data->note);?>
		</div>
		
		<p class="hint">
			<?php echo $data->name . ', ' . NTime::timeAgoInWordsShort($data->added);?>
		</p>
		<div>
			<div class="nnote-controls" style="display:none;">
				<?php if($canEdit):?>
					<a href="#" class="nnote-edit nnote-button icon fam-pencil"><a/>
				<?php endif; ?>
				 <?php if($canDelete):?>
					<a href="#" class="nnote-delete nnote-button icon fam-delete"></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>