<style>
	.uploading{width:100px;height:100px;border:1px solid #ccc;float:left;background:#fff;}
	#dropzone{border:1px solid #999;border-radius:10px;background-color:#ccc;width:400px;height:150px;}
</style>
<h1 class="project"><?php echo $project->name; ?></h1>


<?php $this->widget('nii.widgets.plupload.PluploadWidget', array(
    'config' => array(
        'runtimes' => 'flash,gears,html5,silverlight,browserplus',
        'url' => NHtml::url('/project/details/upload/'),
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
<h3>Custom example</h3>
<div id="container">
	<div id="filelist">No runtime found.</div>
	<br />
	<a id="pickfiles" href="#">[Select files]</a>
	<a id="uploadfiles" href="#">[Upload files]</a>
</div>

<style>
	.projectBox{border:2px solid #ccc;width:200px;height:240px;padding:10px;border-radius:8px;box-shadow:0px 0px 3px #ccc;}
	.projectBox.details{box-shadow:none;border:2px dashed #ccc;}
	.projectBox:hover,.projectBox.details:hover{box-shadow:0px 0px 10px #aaa;}
	.projList li{display:inline-block;float:left;margin:15px;}
	.projImg{border:1px solid #ccc; height:158px;margin-bottom:20px;display:block;}
	.projName .name,a.addProject{font-size:120%;font-weight:bold;}
	
</style>

<ul class="noBull projList">
	<li>
		<div class="projectBox details">
			<div class="norm">
				<div class="projImg">
				<h2>Add A New Project</h2>
				</div>
				<a href="" class="addProject">Create new project</a>
			</div>
			<div class="create" style="display:none;">
				<h2>New Project</h2>
				<div class="field">
					<span class="formGuide">Enter the new project name</span>
					<div class="inputBox">
						<input id="projectInput" name="project" type="text" placeholder="Project Name" />
					</div>
				</div>
				<div class="field">
					<button class="btn btnN createProject">Create</button><a class="cancelNewProject mll" href="#">Cancel</a>
				</div>
			</div>
		</div>
	</li>
</ul>


<script>
// Custom example logic
$(function() {
	var uploader = new plupload.Uploader({
		runtimes : 'html5,gears,flash,silverlight,browserplus',
		browse_button : 'pickfiles',
		container : 'container',
		max_file_size : '10mb',
		url : '<?php echo NHtml::url('/project/details/upload/') ?>',
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
});
</script>