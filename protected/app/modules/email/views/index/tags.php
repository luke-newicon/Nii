<h4 class="ptn mts">Smart Tags</h4>
<div class="line lbl pbs">
	<div class="unit size1of3">Tag</div>
	<div class="lastUnit">Description</div>
</div>

<?php $t = new StringTags;
$tags = $t->getTagsArray();
foreach($tags as $tag) : ?>
	<div class="line pbs">
		<div class="unit size1of3"><?php echo $tag['name'] ?></div>
		<div class="lastUnit"><?php echo $tag['description'] ?></div>
	</div>
<?php endforeach; ?>