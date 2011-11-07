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
		$('#<?php echo $id; ?> input[type=checkbox]').change(function(){
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
				type: 'post',
				success: function(response){
					if(response.success){
						$checkbox.parent().addClass('success').delay(1000).removeClass('success',1000);
					} else if(response.error){
						alert(response.error);
					} else {
						alert(response);
					}
				}
			});
		});
		
		$('#<?php echo $id; ?> thead a').click(function(){
			$('#modal-edit-role').modal('show');
			return false;
		});
	});
</script>