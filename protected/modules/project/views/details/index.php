<style>
	.uploading{width:50px;height:100px;border:1px solid #ccc;float:left;background:#fff;}
	
	
	
	.projList li{display:inline-block;float:left;margin:15px;}
	.projImg{border:1px solid #ccc; height:158px;margin-bottom:15px;display:block;background-color:#f1f1f1;}
	
	.projName{height:40px;}
	.projName .name,a.addProject{font-size:120%;font-weight:bold;width:200px;overflow:hidden;}
	
	.plupload input{cursor:pointer;}
	
	
	
	#dropzone{border:1px solid #555;background-color:#909090;}
	#dropzone.miniDrop{display:none;}
	#dropzone.dragging{background-color:#666;display:block;}
	
	
	.projectBox{background-color:#fff;position:relative;background-color:#fff;border:1px solid #ccc;width:200px;height:240px;padding:10px;border-radius:8px;}
	.projectBox.details{box-shadow:none;border:2px dashed #ccc;}
	.projectBox:hover,.projectBox.details:hover{box-shadow:0px 0px 10px #aaa;background-color:#fff;}
	.functions{visibility: hidden;padding:3px;position:absolute;bottom:8px;right:10px;}
	.hover .functions{visibility:visible;}
	.main{background-color:#f9f9f9;}
	
	
	.pending{border-style: dashed;background-color:#f1f1f1;}
	.uploading{border-style:solid;background-color:#f1f1f1;}

	.sortablePlaceholder{background-color:#f1f1f1;border:1px dotted #ccc;}
	
	.plupload{cursor:pointer;}
	
	#progress{position:fixed;display:none;z-index:10;width:300px;border-radius:5px;opacity:0.9;color:#fff;text-shadow:0 -1px 0 #000;box-shadow:0px 0px 5px #444, inset 0px 1px 0px #ccc;background:-moz-linear-gradient(center top , #999999, #333333) repeat scroll 0 0 transparent;border:1px solid #333;}
	.ui-progressbar{background:-moz-linear-gradient(center top,#666, #aaa);border:1px solid #bbb;height:22px;}
	
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
		<div class="unit plm">
			<a href="#" class="delete" style="padding-top:14px;display:block;" ><img src="<?php echo ProjectModule::get()->getAssetsUrl().'/trash.png'; ?>"/></a>
		</div>
		<div class="unit plm">
			<div id="container" style="cursor:pointer;">
				<a style="cursor:pointer;" class="btn aristo" id="pickfiles" href="#">Browse files...</a>
			</div>
		</div>
		<div class="unit plm">
			<a href="#" class="upload" style="padding-top:14px;display:block;" >Comments</a>
		</div>
		<div class="lastUnit plm">
			<a href="#" class="upload" style="padding-top:14px;display:block;" >Collaborator</a>
		</div>
	</div>
</div>
<div id="drop" class="dropzone" style="display:none;">
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
<div class="" style="margin:10px;padding:20px;height:100px;">Upload screens to start! </div>
<?php endif; ?>


<div id="progress" class="pam" style="">
	<div class="bar"></div>
	<div class="qty">Uploading <span class="current" style="font-weight:bold;"></span> of <span class="total" style="font-weight:bold;"></span> - <span class="percent"></span></div>
</div>

<ul class="noBull projList">
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
	window.addEventListener("dragenter", function(e){
		//$('#dropzone').show();
		clearTimeout(timer);
		$('#dropzone').addClass('dragging');
		$('#drop').show().addClass('dragging').width($(window).width()-40).height($(window).height()-40)
			.position({'my':'center','at':'center','of':$(window)})
	}, false);
	
	window.addEventListener( 'dragover', function(){
		clearTimeout(timer);
		timer = setTimeout(function(){
			$('#drop').fadeOut('fast');
			$('#dropzone').removeClass('dragging');
		},150);
		$('#dropzone').addClass('dragging');
		$('#drop').show();
	}, true );
	
	window.addEventListener("dragleave", function(e){
		if(timer)
			clearTimeout(timer);
		timer = setTimeout(function(){
			$('#drop').fadeOut('fast');
			$('#dropzone').removeClass('dragging');
		},150);
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
		drop_element:'drop'
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

	var totalPercent;
	var totalImages;
	var currentImage;
	var doPercent = function(){
		//$('#progress .percent').html(totalPercent+'%');
		if(currentImage+1 <= totalImages)
			$('#progress .current').html(currentImage+1);
		$('#progress .total').html(totalImages);
		$("#progress .bar").progressbar({value: totalPercent});
		$("#progress .percent").html(totalPercent + '% complete');
	};
	
	uploader.bind('FilesAdded', function(up, files) {
		//if (up.files.length > $max_file_number) up.splice($max_file_number, up.files.length-$max_file_number)
		if(!$('#progress').is(':visible'))
			$('#progress').fadeIn().position({'my':'center','at':'center','of':$(window)});
		$.each(files.reverse(), function(i, file) {
			screenName = file.name.replace(/\.[^\.]*$/, '');
			screenName = screenName.replace(/-/g, " ");
			screenName = screenName.replace(/_/g, " ");
			var content = '<li><div class="projectBox pending" id="' + file.id + '">' +
				'<a class="projImg loading-fb" href="#"></a>' +
				'<div class="projName"><div class="name">'+screenName+'</div></div>' +
				'<div class="progress" style="height:10px;position:absolute;bottom:10px;width:180px;left:10px;"></div>' +
			'</div></li>';
			
			// lookup the name
			// remove the file name
			
			$exists = $('.projectBox[data-name="'+screenName+'"]');
			if($exists.length!=0){
				$exists.closest('li').replaceWith(content);
			}else{
				$('.projList').prepend(content);
			}
		});
		totalPercent = 0;
		currentImage = 0;
		totalImages = files.length;
		//doPercent();
		up.refresh(); // Reposition Flash/Silverlight
		if(up.files.length > 0) uploader.start();
	});

	uploader.bind('UploadProgress', function(up, file) {
		//alert(file.percent);
		var $box = $('#' + file.id);
		if(!$box.is('uploading')){
			$box.removeClass('pending').addClass('uploading');
			$box.animate({backgroundColor: "#fff"});
		}
			
		//	$box.removeClass('pending').addClass('uploading');
		$('#'+file.id+' .progress').progressbar({value:file.percent});
		currentPercent = file.percent;
		// work out total upload progress
		console.log(uploader);
		totalPercent = uploader.total.percent;
		doPercent();
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
		currentImage = currentImage + 1;
		doPercent();
		
		
		console.log(info);
		var r = $.parseJSON(info.response);
		if(r.error != undefined){
			alert(r.error.message);
		}
		
		if(r.replacement){
			$('.projectBox[data-id="'+r.id+'"]').closest('li').hide('normal', function(){$(this).remove();});
		}
		var $box = $(r.result);
		$('#' + file.id).replaceWith($box);
		$box.addClass('uploaded');
		$box.find('.projImg').addClass('loading');
		// check to see if it is a replacement
		
		// when the DOM is ready
		var img = new Image();
		// wrap our new image in jQuery, then:
		$(img).load(function () {
			// set the image hidden by default    
			$(this).hide();
			$box.find('.projImg')
			// remove the loading class (so no background spinner), 
			.removeClass('loading')
			// then insert our image
			.append(this);
			 $(this).fadeIn();
		})
		.error(function () {
			// show broken image graphic here
			alert('oops broken image');
		})
		.attr('src', r.src);
		//$('#' + file.id).remove();
		//$('.projList').append('<li>'+r.result+'</li>')
		
	});
	uploader.bind('UploadComplete', function(up, file, info) {
		$('#progress').fadeOut();
	});
	
	// delete the images
	$('.projList').delegate('.deleteScreen','click',function(){
		$projectBox = $(this).closest('.projectBox');
		//if(confirm('Are you sure you want to delete the "'+$projectBox.find('.projName .name').text()+'" screen?')){
			$projectBox.closest('li').hide('normal', function(){
				$(this).remove();
			});
			$.post("<?php echo NHtml::url('/project/details/deleteScreen') ?>",{screenId:$projectBox.data('id')},function(){});
		//}
		return false;
	})
	.sortable({
		cancel:'.btn,.addScreen',
		items:'li:not(.addScreen)',
		revert:100,
		placeholder:'projectBox sortablePlaceholder',
		opacity:0.8,
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
	
	$('.upload').click(function(){
		$('.droppy').slideToggle(200);
	});
});
</script>