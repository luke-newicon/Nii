<style>
	.uploading{width:100px;height:100px;border:1px solid #ccc;float:left;background:#fff;}
	#dropzone{border:1px solid #999;border-radius:10px;background-color:#ccc;width:400px;height:150px;}

	.projectBox{background-color:#fff;border:2px solid #ccc;width:200px;height:240px;padding:10px;border-radius:8px;box-shadow:0px 0px 3px #ccc;}
	.projectBox.details{box-shadow:none;border:2px dashed #ccc;}
	.projectBox:hover,.projectBox.details:hover{box-shadow:0px 0px 10px #aaa;}
	.projList li{display:inline-block;float:left;margin:15px;}
	.projImg{border:1px solid #ccc; height:158px;margin-bottom:20px;display:block;background-color:#f1f1f1;}
	.projName .name,a.addProject{font-size:120%;font-weight:bold;}
	
</style>
<h1 class="project"><?php echo $project->name; ?></h1>


<?php $this->widget('nii.widgets.plupload.PluploadWidget', array(
    'config' => array(
        'runtimes' => 'html5,flash,silverlight,browserplus',
        'url' => NHtml::url(array('/project/details/upload/','projectId'=>$project->id)),
		'filters'=>array(
			array('title'=>'Image files', 'extensions'=>"jpg,gif,png")
		),
		'autostart'=>true,
		'callbacks'=>array(
			'UploadProgress'=>'js:function(){alert(\'oi\');}'
		)
	),
    'id' => 'uploader'
 )); ?>


<div id="dropzone" class="mll">
	
</div>



</script>
<div id="container">
	<div id="filelist">No runtime found.</div>
	<br />
	<a id="pickfiles" href="#">[Select files]</a>
	<a id="uploadfiles" href="#">[Upload files]</a>
</div>



<ul class="noBull projList">
	<?php foreach($project->getScreens() as $screen): ?>
	<li>
		<?php $this->renderPartial('_project-screen',array('screen'=>$screen)); ?>
	</li>
	<?php endforeach; ?>
</ul>


<script>
// Custom example logic
$(function() {
	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash,silverlight,browserplus',
		browse_button : 'pickfiles',
		container : 'container',
		max_file_size : '10mb',
		url : '<?php echo NHtml::url(array('/project/details/upload/','projectId'=>$project->id)) ?>',
		flash_swf_url:"/newicon/Nii/assets/79029962/plupload.flash.swf",
		silverlight_xap_url:"/newicon/Nii/assets/79029962/plupload.silverlight.xap",
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		],
		drop_element:'dropzone',
		//resize : {width : 320, height : 240, quality : 90}
	});
	

	uploader.bind('Init', function(up, params) {
		$('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
	});

	$('#uploadfiles').click(function(e) {
		uploader.start();
		e.preventDefault();
	});

	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {
		//if (up.files.length > $max_file_number) up.splice($max_file_number, up.files.length-$max_file_number);
		
		$.each(files, function(i, file) {
			$('#dropzone').append(
				'<div class="uploading" id="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <strong></strong>' +
			'</div>');
		});
		up.refresh(); // Reposition Flash/Silverlight
		if(up.files.length > 0) uploader.start();
	});

	uploader.bind('UploadProgress', function(up, file) {
		//alert(file.percent);
		$('#' + file.id + " strong").html(file.percent + "%");
	});

	uploader.bind('Error', function(up, err) {
		$('#filelist').append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		);

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file, info) {
		console.log(info);
		var r = $.parseJSON(info.response);
		if(r.error != undefined){
			alert(r.error.message);
		}
		$('#' + file.id + " strong").html("100%");
		$('#' + file.id).remove();
		$('.projList').append('<li>'+r.result+'</li>')
		
	});
	
	
	// delete the images
	$('.projList').delegate('.deleteScreen','click',function(){
		$projectBox = $(this).closest('.projectBox');
		if(confirm('Are you sure you want to delete the "'+$projectBox.find('.projName .name').text()+'" screen?')){
			$projectBox.closest('li').hide('normal', function(){
				$(this).remove();
			});
			$.post("<?php echo NHtml::url('/project/details/deleteScreen') ?>",{screenId:$projectBox.data('id')},function(){
			});
		}
		return false;
	})
	.sortable({
		stop:function(){
			var order = {};
			$('.projList li').each(function(i,el){
				$li = $(el);
				//var id = $li.find('.projectBox').attr('data-id');
				//console.log($li.find('.projectBox').attr('data-id') + ' index: ' + $li.index());
				order[$li.find('.projectBox').attr('data-id')] = $li.index();
			});
			$.post("<?php echo NHtml::url('/project/details/order') ?>",{order:order})
			//console.log(order);
		}
	});
	
	
});
</script>