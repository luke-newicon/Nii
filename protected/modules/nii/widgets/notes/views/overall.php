<div class="NNotes">
	<div class="NNotes-input">
		<h2><?php echo $title ?></h2>
			<?php if($canAdd): ?>
				<?php $this->render('_newItem',array('displayUserPic'=>$displayUserPic,'profilePic'=>$profilePic,'area'=>$area,'id'=>$id,'ajaxController'=>$ajaxController)) ?>
			<?php endif;?>
		<?php if(count($data)==0): ?>
			<p class="noItems"><?php echo $emptyText ?></p>
		<?php endif; ?>
	</div>
	<div class="NNotes-list">
		<?php foreach ($data as $line): ?>
			<?php $this->render('_line',array('line'=>$line,'profilePic'=>$profilePic)) ?>
		<?php endforeach; ?>
	</div>
</div>