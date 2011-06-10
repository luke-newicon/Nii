<h1 class="project"><?php echo $project->name; ?></h1>


<?php $this->widget('nii.widgets.plupload.PluploadWidget', array(
    'config' => array(
        'runtimes' => 'html5,flash,silverlight,browserplus',
        'url' => NHtml::url('/project/details/upload/'),
		'filters'=>array(
			array('title'=>'Image files', 'extensions'=>"jpg,gif,png")
		),
		'autostart'=>true,
		'callbacks'=>array(
			'FileUploaded' => 'function(up,file,response){alert(\'oi\');}',
		)
	),
	
    'id' => 'uploader'
 )); ?>
<div id="uploader2"></div>
<script>
	
$(function(){
});


//uploader.bind('FileUploaded', function(up, file, r) {
//	if(__Debug === true) console.console.log(r);
//
//	var json = JSON.parse(r.response);
//
//	__Total -= file.size;
//	__Files -= 1;
//
//	status;
//
//	if(json.error) {
//		if(__Debug === true) console.console.log(json.error.code + ': ' + json.error.message);
//	} else {
//		if(__Debug === true) console.console.log('Upload was successful: ' + json.result.s3url);
//	}
//});
</script>