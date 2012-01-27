<div class="page-header">
	<h2><?php echo $this->t('Holidays') ?></h2>
	<div class="action-buttons">
		<a href="#" id="addNewHoliday" class="btn primary" data-controls-modal="modal-holiday-add" data-backdrop="static">Add new holiday</a>
	</div>
</div>
<style>
	#addNewHolidayBox .form label {
		display: block;
		float: left;
		padding-right: 8px;
		padding-top: 4px;
		text-align: right;
		width: 113px;
	}
	
	#addNewHolidayBox .row {
		margin:10px 0px;
	}
	
</style>
<?php 
	$this->widget(
		'ext.bootstrap.widgets.grid.BootGridView', 
		array(
			'id'=>'timesheet-holiday-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'columns'=>array(
				array('name'=>'date_start'),
				'date_end',
				'status',
				'authorised_by',
				array(
					'class'=>'CButtonColumn',
					'template'=>'{delete}'
				),
			),
		)
	); 
?>
<div class="modal hide fade" id="modal-holiday-add">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>Add Holiday</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="holiday-add-cancel" class="btn" href="#">Cancel</a>
		<a id="holiday-add-save" class="btn primary" href="#">Save</a>
	</div>
</div>
<script type="text/javascript">
	jQuery(function($){
		$('#modal-holiday-add').bind('show', function() {
			$('#modal-holiday-add .modal-body').load('<?php echo CHtml::normalizeUrl(array('/timesheet/holiday/create')) ?>');
		});
		
		$('#holiday-add-save').click(function(){
			$('#timesheet-holiday-form').submit();
			return false;
		});
		
		$('#holiday-add-cancel').click(function(){
			$('#modal-holiday-add').modal('hide');
			return false;
		});
		
		$('#modal-holiday-add').delegate('#timesheet-holiday-form','submit',function(){
			$.ajax({
				url: "<?php echo CHtml::normalizeUrl(array('/timesheet/holiday/create')) ?>",
				data: jQuery('#timesheet-holiday-form').serialize(),
				dataType: "json",
				type: "post",
				success: function(response){ 
					if (response.success) {
						$('#modal-holiday-add').modal('hide');
						$.fn.yiiGridView.update('timesheet-holiday-grid');
					} else {
						alert(response.error);
					}
				},
				error: function() {
					alert("JSON failed to return a valid response");
				}
			});
			return false;
		});
		
	});
</script>