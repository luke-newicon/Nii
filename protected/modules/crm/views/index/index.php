
<style>
	.userList li,#groupList li {border-bottom:1px solid #ccc;overflow:hidden;cursor:pointer;background-color:#fff;padding-left:5px;}
	.userList li:hover {background-color:#f9f9f9;}
	#groupList .selected {background:-moz-linear-gradient(center top , #f9f9f9, #e1e1e1) repeat scroll 0 0 transparent;background:-webkit-gradient(center top , #f9f9f9, #e1e1e1) repeat scroll 0 0 transparent;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e1e1e1');}
	.userList li.ui-selecting { background: #FECA40; }
	.userList li.ui-selected {background:-moz-linear-gradient(center top , #f9f9f9, #e1e1e1) repeat scroll 0 0 transparent;background:-webkit-gradient(linear, left top, left bottom, from(#e1e1e1), to(#f9f9f9));filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e1e1e1');}
	
	.editContact{display:none;}
	.userList li.selected .editContact {display:block;/*margin-right:16px;*/}
	.userList .media{margin:5px;}
	.userListScreen{border-right:1px solid #a9a9a9;border-left:1px solid #ccc;background-color:#fff;}
	.contactBook{background-color:#f9f9f9;border-top:1px solid #ccc;}
	.detailsScreen{background-color:#f9f9f9;}

/** mods for inputBox classes **/
	.flashy .focus .brn .inputBox, .flashy .brn .inputBox{border-width:1px 0px 1px 1px;border-radius:4px 0px 0px 4px;-moz-border-radius:4px 0px 0px 4px;}

	.flashy .focus .noHighlight .inputBox{box-shadow:none;-moz-box-shadow:none;-webkit-box-shadow:none;}
	.flashy .focus .topBorderOnly .inputBox, .flashy .topBorderOnly .inputBox {border-width:1px 0px 0px 0px;}
	.flashy .focus .leftBorderOnly .inputBox, .flashy .leftBorderOnly .inputBox{border-width:0px 0px 0px 1px;}
	.flashy .focus .topLeftBorderOnly .inputBox, .flashy .topLeftBorderOnly .inputBox{border-width:1px 0px 0px 1px;}
	.flashy .focus .noBorder .inputBox, .flashy .noBorder .inputBox{border-width:0px;}
	.flashy .focus .noBorder .btn.btnN, .flashy .noBorder .btn.btnN{border-width:0px;}
	
	.flashy .focus .cornerOff .inputBox, .flashy .cornerOff .inputBox{border-radius:0px;-moz-border-radius:0px;}
	.flashy .focus .cornerLeftOff .inputBox, .flashy .cornerLeftOff .inputBox{border-radius:0px 4px 4px 0px;-moz-border-radius:0px 4px 4px 0px;}
	.flashy .focus .cornerRightOff .inputBox, .flashy .cornerRightOff .inputBox{border-radius:4px 0px 0px 4px;-moz-border-radius:4px 0px 0px 4px;}
	.flashy .focus .cornerTopOff .inputBox, .flashy .cornerTopOff .inputBox{border-radius:0px 0px 4px 4px;-moz-border-radius:0px 0px 4px 4px;}
	.flashy .focus .cornerTopBottomLeftOff .inputBox, .flashy .cornerTopBottomLeftOff .inputBox{border-radius:0px 0px 4px 0px;-moz-border-radius:0px 0px 4px 0px;}
	
	.userListScreen .alpha{border:1px solid #fff;-moz-border-radius:8px 8px 8px 8px;border-radius:8px 8px 8px 8px;}
	.userListScreen .alpha a{color:#999;font-size:10px;}
	.userList li.letter {background:-moz-linear-gradient(center top , #f9f9f9, #eee) repeat scroll 0 0 transparent;background:-webkit-gradient(linear, left top, left bottom, from(#eee), to(#f9f9f9));filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#eee');padding:2px 0px 2px 5px;}
	.userList li.letter a {color:#999;text-shadow:0 1px 0 rgba(255, 255, 255, 0.8);}
	#groupList{background-color:#fff;}
	#groupList li{border-bottom:1px solid #ccc;border-left:none;padding:5px 10px;}
	.inputBox{position:relative;}
	.userList{margin-right:-15px;}
	
	/**
	 * css drag styles
	 */
	 .dragging .selected {opacity:0.5;}
</style>
<div id="contactBook" class="line contactBook noBull">
	<div id="groupList" class="unit size2of10" style="width:180px;">
		<div class="topperGreyBar pls line prs" style="height:24px;padding:3px 3px 0px 2px;">
			<div class="unit size4of5 flashy" style="padding-left:2px;">
				<!--
				<div class="inputContainer" style="position:relative;">
					<div class="inputBox line" style="padding:2px;">
						<div class="unit" style="width:20px;"><span class="grey-icon fam-zoom"></span></div>
						<div class="lastUnit"><input id="groupSearch" name="contactSearch" type="text" class="input" /></div>
					</div>
				</div>
				-->
			</div>
			<div class="lastUnit txtR">
				<a id="addGroup" href="" class="btn btnN btnToolbar addGroup btnFlat" data-tip="{gravity:'s'}" title="Add Group"><span class="icon ni-add mrn"></span></a>
			</div>
		</div>
		<ul id="groups" class="man">
			<li data-id="all" class="group selected"><span class="icon fam-vcard"></span> <a href="#">All</a></li>
			<li data-id="people" class="group"><span class="icon fam-user"></span> <a href="#">people</a></li>
			<li data-id="companies" class="group"><span class="icon fam-building"></span> <a href="#">companies</a></li>
			<li data-id="users" class="group"><span class="icon fam-user-gray"></span> <a href="#">Users</a></li>
			<li style="display:none;" id="newGroup" class="groupEdit line" ><div class="icon fam-vcard unit"></div><div class="inputBox lastUnit" style="padding:2px;"><input type="text" id="newGroupInput" name="newGroup" value="<?php echo CrmModule::get()->defaultNewGroupName; ?>" /></div></li>
			<?php foreach($groups as $g): ?>
				<li data-id="<?php echo $g->id; ?>" class="group"><span class="icon fam-vcard"></span> <a href="#"><?php echo $g->name; ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="unit size3of10 userListScreen ">
		<div class="topperGreyBar pls line prs" style="height:24px;padding:3px 3px 0px 2px;">
			<div class="unit">
				<a id="showAlphaSearch" href="#" class="btn btnN btnToolbar btnFlat"><span class="grey-icon fam-font"></span></a>
			</div>
			<div class="unit size3of5 flashy" style="padding-left:2px;">
				<div class="inputContainer">
					<div class="inputBox line" style="padding:2px;">
						<div class="unit size1of10"><span class="grey-icon fam-zoom"></span></div>
						<div class="lastUnit"><input id="contactSearch" name="contactSearch" type="text" class="input" /></div>
					</div>
				</div>
			</div>
			<div class="lastUnit txtR">
				<a href="" class="btn btnN btnToolbar addContact btnFlat" data-tip="{gravity:'s'}" title="Add Contact">&nbsp;<span class="icon ni-add mrn">&nbsp;</span></a>
				<a href="" class="btn btnN btnToolbar addCompany btnFlat" data-tip="{gravity:'s'}" title="Add Company">&nbsp;<span class="icon ni-add mrn">&nbsp;</span></a>
			</div>
		</div>
<!--		<ul id="alphaSearch" class="man" style="float:left;width:20px" >
			<?php foreach(range('A','Z') as $l): ?>
			<li class="txtC alpha"><a href="#<?php echo $l; ?>"><?php echo $l; ?></a></li>
			<?php endforeach; ?>
			<li class="txtC alpha"><a href="#">#</a></li>
		</ul>-->
		<div id="userListScroll" style="overflow-y:auto;">
			<?php echo $this->renderPartial('_user-list',array('contacts'=>$contacts,'term'=>$term)); ?>
		</div> 
	</div>
	<div class="lastUnit detailsScreen">
		<div class="topperGreyBar pll prs txtR" style="height:24px;padding-top:3px;">
			<a id="contactEdit" href="#" class="contactEdit btn btnN btnToolbar btnFlat" style="padding:3px;display:none;"><span class="grey-icon fam-pencil">&nbsp;Edit&nbsp;</span></a>
			<a id="contactDelete" href="#" class="contactDelete btn btnN btnToolbar btnFlat" style="padding:3px;display:none;"><span class="grey-icon fam-delete">&nbsp;Delete&nbsp;</span></a>
			<a id="contactSave" href="#" class="contactSave btn btnN btnToolbar btnFlat" style="padding:3px;display:none;"><span class="grey-icon fam-disk">&nbsp;Save&nbsp;</span></a>
			<a id="contactCancel" href="#" class="contactCancel btn btnN btnToolbar btnFlat" style="padding:3px;display:none;"><span class="grey-icon fam-cross">&nbsp;Cancel&nbsp;</span></a>
		</div>
		<div id="detailsScreen" class="plm prl ptm" style="overflow:auto;" >
			details
		</div>
	</div>
</div>
<script type="text/javascript">

var cBook = {
	userScroll:{},
	init:function(){
		cBook.initUserScroll();
	},
	//initialises the scroll bar for the user list
	initUserScroll:function	(){
		var timer;
		cBook.userScroll = $('#userListScroll')
			.bind('jsp-scroll-y',function(event, scrollPositionY, isAtTop, isAtBottom){
				$('.jspDrag').stop(1,0).css('opacity','0.7').show();
				if (timer) {
					clearTimeout(timer);
				}
				timer = setTimeout( function(){
					timer = null;
					$('.jspDrag').stop(1,0).delay(400).fadeOut(500);
					//scrollStop(scrollPositionY);
				}, 300);
			})
			.jScrollPane({
				verticalDragMinHeight: 20,
				verticalGutter:0,
				hideFocus:1
			})
			.data('jsp');
		$('.jspDrag').hide();
	},
	addGroup:function(){
		$('#newGroup').show();
		$('#newGroupInput').select().bind('keyup blur', function(e){
			if(e.type === 'keyup' && e.keyCode !== 13) return;
			// unbind to prevent calling this function from the blur event
			$('#newGroupInput').unbind('keyup blur');
			// they hit enter or left the text field lets update!
			$.post("<?php echo NHtml::url('/crm/index/addGroup'); ?>", 'group='+$('#newGroupInput').val(), function(r){
				// unbind
				$('#groups').append('<li data-id="'+r.id+'" class="group"><span class="icon fam-vcard"></span> <a href="#">'+r.name+'</a></li>');
				$('#newGroup').hide();
			},'json');
		});
		return false;
	}
}

$(function(){
	
	cBook.init();
	$('#addGroup').click(function(){return cBook.addGroup();});

		
	//$('.jspDrag').hide();
	$('#userListScroll').delegate('.jspContainer','mouseenter',function(){
		$('.jspDrag').stop(1,0).fadeTo(100,0.7).delay(400).fadeOut();
	});
	$('#userListScroll').delegate('.jspContainer','mouseleave',function(){
		$('.jspDrag').stop(1,0).delay(300).fadeOut();
	});



	$('.contactBook').delegate('.userList li.contact','click',function(e){
		// can check event for shiftKey and ctrlKey
		if(e.ctrlKey === true){
			$(this).addClass('selected');
			return;
		}
		if(e.shiftKey === true){
			// do some marginally clever code to figure out which element to highlight
		}
		$(this).parent().find('.selected').removeClass('selected');
		$(this).addClass('selected');
		$('#contactEdit').show();$('#contactDelete').show();$('#contactCancel').hide();$('#contactSave').hide();
		if ($(this).attr('id')){
			var id = $(this).attr('id').replace('cid_','');
			$('#detailsScreen').load('<?php echo NHtml::url("/crm/detail/index"); ?>?id='+id);
		} else {
			$('#detailsScreen').load("<?php echo NHtml::url('/crm/index/getContactForm'); ?>");
		}
	});

	$('#groups').delegate('li', 'click', function(){
		$(this).parent().find('li').removeClass('selected');
		$(this).addClass('selected');
		loadContactList();
		return false;
	});

	$('#showAlphaSearch').click(function(){
		$('#alphaSearch').toggle();
		return false;
	});
	// add
	$('.contactBook').delegate('.addContact','click',function(){ 
		$ul = $('.userList');
		$ul.find('.selected').removeClass('selected');
		$('#contactEdit').hide();$('#contactDelete').hide();$('#contactCancel').show();$('#contactSave').show();
		$('<li class="contact mystery"><div class="media"><a class="img" href="#"><img width="24" alt="Mystery Image" src="http://localhost/newicon/project-manager/app/Nworx/Crm/theme/assets/mistery-img.png"></a><div class="bd"><p>Add</p></div></li>')
			.prependTo($ul).addClass('selected');
		$('#userListScroll').scrollTo(0);
		$('#detailsScreen').load("<?php echo NHtml::url('/crm/index/getContactForm'); ?>");
		return false;
	});
	// save
	$('#detailsScreen').delegate('#contactForm','submit',function(){
		$f = $('#contactForm');
		var data = $f.serialize();
		var $li = $('.userList li.selected');
		var adding = (!$li.attr('id'));
		$.ajax({
			url:$f.attr('action'),
			type:'post',
			dataType:'json',
			data:data,
			success:function(r) {
				if (r.id == false) return;
				$li.attr('id','cid_'+r.id);
				$li.html(r.card).trigger('click');
				$.ajax({
					url:'<?php echo NHtml::url('/crm/index/findContact/'); ?>',
					type:'post',
					success:function(html){
						$('#userListScroll').html(html);
						$('#userListScroll').scrollTo($('#cid_'+r.id).addClass('selected'),{duration:0,axis:'y'});
					}
				});
				if(r.createdCompany){
					// a new company was also created!
					// lets add it to the list
					$('<li class="contact"></li>')
						.attr('id',r.createdCompany.id)
						.html(r.createdCompany.card)
						.insertAfter($li);
				}
			}
		});
		return false;
	});
	// edit 
	$('.contactBook').delegate('.contactEdit','click',function(){
		var $li = $('.userList li.selected');
		var id = $li.attr('id');
		if(!id){alert('nothing to edit');return false;}
		$('#contactEdit').hide();$('#contactDelete').hide();$('#contactCancel').show();$('#contactSave').show();
		$('#detailsScreen').load('<?php echo NHtml::url("/crm/index/getContactForm"); ?>?cid='+id.replace('cid_',''));
		return false;
	});
	// delete
	$('.contactBook').delegate('.contactDelete','click',function(){
		var $li = $('.userList li.selected');
		var id = $li.attr('id');
		if(!confirm('Are you sure you want to delete this contact and all associated data?')) return false;
		if(!id){alert('nothing to delete');return false;}
		$.getJSON("<?php echo NHtml::url('/crm/index/delete'); ?>?cid="+id.replace('cid_',''), function(r){
			if(r){
				deleteLi($li);
			}
		});
		return false;
	});
	$('.contactBook').delegate('.contactCancel','click',function(){
		$li = $('.userList li.selected');
		if($li.is('.mystery'))
			deleteLi($li);
		else
			$li.trigger('click');
		return false;
	});
	$('.contactBook').delegate('.contactSave','click',function(){
		$('#detailsScreen form').submit();
		return false;
	});

	var deleteLi = function($li){
		var $n = $li.next(); var $p = $li.prevUntil('.contact');
		if ($n.is('.letter')) $n = $n.next();
		if ($p.is('.letter')) $p = $p.next();
		$loadLi = ($n.length) ? $n : (($p.length) ? $p : false);
		if ($loadLi) {
			$loadLi.trigger('click');
		} else {
			alert('display default blank screen');
		}
		$li.remove();
	};


	$('#contactSearch').keyup(function(){
		loadContactList();
	});

	var loadContactList = function(){
		var grpId = $('#groups .selected').data('id');
		$.ajax({
			url:'<?php echo NHtml::url('/crm/index/findContact'); ?>?term='+$('#contactSearch').val()+'&group='+grpId,
			type:'post',
			success:function(r){
				$('#userListScroll .userList').replaceWith(r);
				cBook.userScroll.reinitialise();
			}
		});
	};

	$('.alpha a').click(function(){
		var letter = $(this).attr('href').replace('#','');
		var s2el = $('a[name="'+letter+'"]');
		if(s2el.length != 0){
			$('#userListScroll').scrollTo(s2el,'y');
		}else{
			$.ajax({
				url:'<?php echo NHtml::url('/crm/index/find-contact-alpha'); ?>/'+letter,
				type:'post',
				success:function(r){
					$('#userListScroll').html(r);
				}
			})			
		}
		return false;
	});

	//$('.userList').selectable();
	$('#userListScroll .userList li').draggable({
		scope:'group',
		addClasses:false,
		revert:true,
		cursorAt:{left: 0, top: 0},
		cursor:'move',
		start:function(){
			// dragging has started add class to indicate all the draggables that are being dragged
			$('#userListScroll .userList').addClass('dragging');
		},
		stop:function(){
			$('#userListScroll .userList').removeClass('dragging');
		},
		helper:function(){
			var count = $('#userListScroll .userList .selected').length;
			return $('<div>helper '+count+'</div>').appendTo('body').get()
		}
	});
	$('#groups .group').droppable({
		scope:'group',
		over:function(event, ui){
			
		},
		hoverClass:'selected',
		addClasses:false,
		drop: function(event, ui) {
			var contacts = '';
			var groupId = $(this).data('id');
			$('#userListScroll .userList .selected').each(function(i,e){
				contacts += $(e).data('id') + ',';
			});
			$.post("<?php echo NHtml::url('/crm/index/addToGroup'); ?>",{"groupId":groupId,"contacts":contacts},function(r){
				alert('done');
			});
		}
	});

	/**********************
	 * form controls
	 *********************/

	$('body').delegate('.btnDropDown','click',function(){
		$(this).dropButton();
		$(this).trigger('click');
		return false;
	});

	$('#detailsScreen').delegate('.addRow','click',function(){
		var $b = $(this).closest('.fieldState');
		var $el = $b.find('.replicate:first');
		// if the first element is hidden then dont add another
		// just show the existing hidden one with position 0
		if(!$el.is(':visible')){
			$el.show().find('input,textarea').val('');
			return false;
		}
		var $c = $el.clone();
		// remove values
		$c.find('input,textarea').val('');
		var num = $b.find('.replicate').length;
		$c.find('[id*="_0_"]').each(function(i,el){
			var $el = $(el);
			if($el.attr('name') !== undefined)
				$el.attr('name',$el.attr('name').replace('[0]', '['+num+']'));
			$el.attr('id', $el.attr('id').replace('_0_', '_'+num+'_'));
			if($el.has('.errorMessage'))
				$el.html('');
		});
		$c.find('[for]').each(function(i,el){
			$(el).attr('for',$(el).attr('for').replace('_0_', '_'+num+'_'));
		});
		$c.appendTo($b).show();
		// reattach infield labels
		$fLbl = $c.find('.formFieldHint');
		$tEx = $c.find("textarea[class*=expand]");
		if($fLbl.length >= 1)
			$fLbl.css('opacity',1).inFieldLabels().show();
		if($tEx.size() >= 1)
			$tEx.textAreaExpander();
		return false;
	});
	$('#detailsScreen').delegate('.removeRow','click',function(){
		var $r = $(this).closest('.replicate');
		var $b = $r.parent();
		if($b.find('.replicate').length!=1){
			$r.remove();
		}else{
			// last replicate block left so lets just hide it.
			$r.hide();
		}
		// show we ajax remove this
		// if the row has an id field then its in the database so we want to remove it from there
		$('.tipsy').remove();
		return false;
	});
	
	
	
	$('.userListScreen').resizable({
		handles:'e',
		minWidth: 240,
		iframeFix:true,
		alsoResize: '#userListScroll, .jspContainer, .jspPane',
		stop: function(event, ui) {
			//resizer();
		}
	});
	
	$('#groupList').resizable({
		handles:'e',
		minWidth: 150,
		iframeFix:true,
		stop: function(event, ui) {
			//resizer();
		}
	});
	
	
	
	
	// resize window n panes
	var timer;
	var resizer = function(){

		if (timer) {
			clearTimeout(timer);
		}
		timer = setTimeout( function(){
			timer = null;
			var paddingBottom = $('.main').padding().bottom;
			var minHeight = 200;
			var winHeight = $(window).height();
			if(!((winHeight-$('#contactBook').position().top-paddingBottom) <= minHeight)){
				var border = $('#contactBook').border();
				borderHeight = border.top + border.bottom;
				$('#contactBook').css('height',((winHeight - $('#contactBook').offset().top - paddingBottom) - borderHeight) + 'px');
				$('.userListScreen').css('height',(winHeight - $('.userListScreen').offset().top - paddingBottom) + 'px');
				$('#userListScroll').css('height',(winHeight - $('#userListScroll').offset().top - paddingBottom) + 'px');
				//$('#userListScroll').css('height',$('#contactBook').height()-30 + 'px');
				$('#detailsScreen').css('height',$('#contactBook').height()-40 + 'px');
				//$('#messageScroll').css('height',(winHeight-$('#messageScroll').position().top-paddingBottom)+'px');
				//$('#email').css('height',(winHeight-$('#email').position().top-paddingBottom)+'px');
				//$('#messageFolders').css('height',(winHeight-$('#messageFolders').position().top-paddingBottom)+'px');
			}
			cBook.userScroll.reinitialise();
		}, 150);
	}
	
	
	resizer();
	
	$(window).stop().resize(function(){
		resizer();
	});

});



/*
 * Used to determine border pixel sizes for resizing panes
 * e.g. $('selector').border().bottom ( = integer size in pixels )
 * 
 * JSizes - JQuery plugin v0.33
 *
 * Licensed under the revised BSD License.
 * Copyright 2008-2010 Bram Stein
 * All rights reserved.
 */
(function(b){var a=function(c){return parseInt(c,10)||0};b.each(["min","max"],function(d,c){b.fn[c+"Size"]=function(g){var f,e;if(g){if(g.width!==undefined){this.css(c+"-width",g.width)}if(g.height!==undefined){this.css(c+"-height",g.height)}return this}else{f=this.css(c+"-width");e=this.css(c+"-height");return{width:(c==="max"&&(f===undefined||f==="none"||a(f)===-1)&&Number.MAX_VALUE)||a(f),height:(c==="max"&&(e===undefined||e==="none"||a(e)===-1)&&Number.MAX_VALUE)||a(e)}}}});b.fn.isVisible=function(){return this.is(":visible")};b.each(["border","margin","padding"],function(d,c){b.fn[c]=function(e){if(e){if(e.top!==undefined){this.css(c+"-top"+(c==="border"?"-width":""),e.top)}if(e.bottom!==undefined){this.css(c+"-bottom"+(c==="border"?"-width":""),e.bottom)}if(e.left!==undefined){this.css(c+"-left"+(c==="border"?"-width":""),e.left)}if(e.right!==undefined){this.css(c+"-right"+(c==="border"?"-width":""),e.right)}return this}else{return{top:a(this.css(c+"-top"+(c==="border"?"-width":""))),bottom:a(this.css(c+"-bottom"+(c==="border"?"-width":""))),left:a(this.css(c+"-left"+(c==="border"?"-width":""))),right:a(this.css(c+"-right"+(c==="border"?"-width":"")))}}}})})(jQuery);


</script>