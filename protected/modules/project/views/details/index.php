<style>
	.uploading{width:50px;height:100px;border:1px solid #ccc;float:left;background:#fff;}
	
	
	.projectBox{background-color:#fff;border:2px solid #ccc;width:200px;height:240px;padding:10px;border-radius:8px;box-shadow:0px 0px 3px #ccc;}
	.projectBox.details{box-shadow:none;border:2px dashed #ccc;}
	.projectBox:hover,.projectBox.details:hover{box-shadow:0px 0px 10px #aaa;}
	.projList li{display:inline-block;float:left;margin:15px;}
	.projImg{border:1px solid #ccc; height:158px;margin-bottom:20px;display:block;background-color:#f1f1f1;}
	
	.projName{height:40px;}
	.projName .name,a.addProject{font-size:120%;font-weight:bold;}
	
	.plupload input{cursor:pointer;}
	
	
	
	#dropzone{border:1px solid #999;border-radius:10px;background-color:#ccc;width:400px;min-height:150px;}
	#dropzone.miniDrop{display:none;}
	#dropzone.dragging{background-color:#000;display:block;}
	
	
	.functions{visibility: hidden;}
	.hover .functions{visibility:visible;}
	
</style>
<h1 class="project"><?php echo $project->name; ?></h1>


<div class="toolbar">
	<a href="" class="btn btnN">Delete</a>
</div>

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



<div id="dropzone" class="mll miniDrop">
	
</div>
<div id="container">
	<a class="btn btnN" id="pickfiles" href="#">Select files...</a>
<!--	<a id="uploadfiles" href="#">[Upload files]</a>-->
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
$(function(){
	
	var timer = {};
	window.ondragenter = function(e){
		//$('#dropzone').show();
		clearTimeout(timer);
		$('#dropzone').addClass('dragging');
	};
	window.addEventListener( 'dragover', function(){
		clearTimeout(timer);
		$('#dropzone').addClass('dragging');
	}, true );
	
	window.addEventListener("dragleave", function(){
		if(timer)
			clearTimeout(timer);
		timer = setTimeout(function(){
			$('#dropzone').removeClass('dragging');
		},300);
		
	}, false);
	
	
	
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
		drop_element:'dropzone'
		//resize : {width : 320, height : 240, quality : 90}
	});
	

	uploader.bind('Init', function(up, params) {
		//$('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
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
				file.name + ' (' + plupload.formatSize(file.size) + ')' +
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
	
	// add hover class when hovering over a screen
	$('.projList').delegate('.projectBox','mouseenter',function(){$(this).addClass("hover");});
	$('.projList').delegate('.projectBox','mouseleave',function(){$(this).removeClass("hover");});
});
</script>