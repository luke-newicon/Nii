<style>
	.uploading{width:50px;height:100px;border:1px solid #ccc;float:left;background:#fff;}
	
	
	
	.projList li{display:inline-block;float:left;margin:15px;}
	.projImg{border:1px solid #ccc; height:158px;margin-bottom:15px;display:block;background-color:#f1f1f1;}
	
	.projName{height:40px;}
	.projName .name,a.addProject{font-size:120%;font-weight:bold;width:200px;overflow:hidden;}
	
	.plupload input{cursor:pointer;}
	
	
	
	#dropzone{border:1px solid #555;background-color:#909090;min-height:150px;}
	#dropzone.miniDrop{display:none;}
	#dropzone.dragging{background-color:#666;display:block;}
	
	
	.projectBox{background-color:#fff;position:relative;background-color:#fff;border:1px solid #ccc;width:200px;height:240px;padding:10px;border-radius:8px;}
	.projectBox.details{box-shadow:none;border:2px dashed #ccc;}
	.projectBox:hover,.projectBox.details:hover{box-shadow:0px 0px 10px #aaa;background-color:#fff;}
	.functions{visibility: hidden;padding:3px;position:absolute;bottom:8px;right:10px;}
	.hover .functions{visibility:visible;}
	.main{background-color:#f9f9f9;}
	
	


	
	
	
	
</style>

<div class="toolbar line plm" style="margin-top:-1px;">
	<div class="line">
		<div class="unit toolbarArrow mrm">
			<a style="display:block;" class="titleBarText" href="<?php echo NHtml::url('/project/index/index'); ?>">Projects</a>
		</div>
		<div class="unit prm">
			<h1 class="man titleBarText"><?php echo $project->name; ?></h1>
		</div>
		<div class="unit">
			<div style="margin:2px 5px 2px 5px;width:0px;height:44px;border-left:1px solid #ababab;border-right:1px solid #fff;"></div>
			
		</div>
		<div class="lastUnit plm">
			<a href="#" class="delete" style="padding-top:14px;display:block;" ><img src="<?php echo ProjectModule::get()->getAssetsUrl().'/trash.png'; ?>"/></a>
		</div>
	</div>
</div>
<div id="dropzone">
	
</div>
<br />
<br />

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


<?php if(count($screens) === 0): ?>
<p>Upload screens to start! </p>
<?php endif; ?>

<div id="container">
	<a class="btn btnN" id="pickfiles" href="#">Select files...</a>
<!--	<a id="uploadfiles" href="#">[Upload files]</a>-->
</div>



<ul class="noBull projList">
	<li><div class="projectBox addScreen" data-id="0">add screens n stuff...
		<div id="dropzone" class="mll miniDrop">
	
		</div>
	</div></li>
	<?php foreach($screens as $screen): ?>
	<li>
		<?php $this->renderPartial('_project-screen',array('screen'=>$screen)); ?>
	</li>
	<?php endforeach; ?>
</ul>


<script>
// Custom example logic
$(function(){
	
	
	$('.toolbar').delegate('.delete','click',function(){
		$projectBox = $(this).closest('.projectBox');
		if(confirm('Are you sure you want to delete this project?')){
			$.post("<?php echo NHtml::url('/project/index/delete') ?>",{id:<?php echo $project->id; ?>},function(){
				location.href = "<?php echo NHtml::url('/project/index/index'); ?>";
			});
		}
	});
	
	
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
			console.log(file);
			$('.projList').prepend(
				'<li><div class="projectBox" id="' + file.id + '">'+
					'<a class="projImg" href="#"><img src=""></a>'+
					'<div class="projName"><span class="name">'+file.name+'</span></div>' +
				'</div></li>'
			)
			$('#dropzone').append(
				'<div class="uploading" id2="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ')' +
			'</div>');
		});
		up.refresh(); // Reposition Flash/Silverlight
		if(up.files.length > 0) uploader.start();
	});

	uploader.bind('UploadProgress', function(up, file) {
		console.log(file);
		//alert(file.percent);
		$('#' + file.id).html(file.percent+'%');
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
		$('#' + file.id).replaceWith(r.result);
		//$('#' + file.id).remove();
		//$('.projList').append('<li>'+r.result+'</li>')
		
	});
	
	
	// delete the images
	$('.projList').delegate('.deleteScreen','click',function(){
		$projectBox = $(this).closest('.projectBox');
		if(confirm('Are you sure you want to delete the "'+$projectBox.find('.projName .name').text()+'" screen?')){
			$projectBox.closest('li').hide('normal', function(){
				$(this).remove();
			});
			$.post("<?php echo NHtml::url('/project/details/deleteScreen') ?>",{screenId:$projectBox.data('id')},function(){});
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