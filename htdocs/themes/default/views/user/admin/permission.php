<?php $this->widget('ext.bootstrap.widgets.grid.BootGridView', array(
	'id' => $id,
	'template' => '{items}',
	'dataProvider' => $dataProvider,
	'enableSorting' => false,
	'enablePagination' => false,
	'columns' => $columns,
)); ?>
<script>
	jQuery(function($){
		$('.grid-view input[type=checkbox]').change(function(){
			var $checkbox = $(this);
			if($(this).is(':checked')){
				var data = $checkbox.attr('name') + '=1';
			} else {
				var data = $checkbox.attr('name') + '=0';
			}
			$.ajax({
				url: '<?php echo CHtml::normalizeUrl(array('/user/admin/updatePermission')) ?>',
				data: data,
				dataType: 'json',
				type: 'post'
				// TODO: Create repsonse action to show user if update was successful
			});
		});
	});
</script>