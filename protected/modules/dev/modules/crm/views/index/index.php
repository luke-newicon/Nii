
<style>
	.userList li,#groupList li {border-bottom:1px solid #bbb;overflow:hidden;cursor:pointer;background-color:#fff;padding-left:5px;}
	.userList li:hover {background-color:#f9f9f9;}
	#groupList .selected {background:-moz-linear-gradient(center top , #f9f9f9, #e1e1e1) repeat scroll 0 0 transparent;background:-webkit-gradient(linear, left top ,left bottom, from(#f9f9f9), to(#e1e1e1));filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e1e1e1');}
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
	.userList li.letter {cursor:default;background:-moz-linear-gradient(center top , #f4f4f4, #ddd) repeat scroll 0 0 transparent;background:-webkit-gradient(linear, left top, left bottom, from(#f4f4f4), to(#ddd));filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f4f4f4', endColorstr='#ddd');padding:0px 0px 1px 5px;border-top:1px solid #fff;border-bottom:1px solid #aaa;}
	.userList li.letter a {color:#666;text-shadow:0 1px 0 rgba(255, 255, 255, 0.8);cursor:default;}
	#groupList{background-color:#fff;}
	#groupList li{border-bottom:1px solid #ccc;border-left:none;padding:5px 10px;}
	.inputBox{position:relative;}
	.userList{margin-right:-15px;}
	#groups{margin-right:-15px;}
	/**
	 * css drag styles
	 */
	 .dragging .selected {opacity:0.5;}
	 a.group-delete{display:none;float:right;color:#ffcccc;margin-right:7px;}
	 .group:hover a.group-delete{display:block;}
	 .group:hover a.group-delete:hover{color:#990000;text-decoration:none;}
	 .main-toolbar{position:absolute;top:3px;left:600px;}
	
	 /**
	  * classes used for the drag helper image
	  */
	 .dragHelper{position:relative;}
	 .bigNumber{position:absolute;top:15px;left:40px;background-color:#aa0000;color:#fff;text-shadow:1px 1px 0px #000;border-radius:10px;padding:2px 5px;}
	 
	 .inputBox input {width:100%;padding:0px;border:none;}
</style>
<div class="main-toolbar">
	<div class="delete">
		delete
	</div>
</div>
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
		<div id="groupListScroll" style="overflow:auto;">
			<ul id="groups" class="man">
				<li data-id="all" class="group selected"><span class="icon fam-vcard"></span> <a href="#">All</a></li>
				<li data-id="people" class="group"><span class="icon fam-user"></span> <a href="#">people</a></li>
				<li data-id="companies" class="group"><span class="icon fam-building"></span> <a href="#">companies</a></li>
				<li data-id="users" class="group"><span class="icon fam-user-gray"></span> <a href="#">Users</a></li>
				<li style="display:none;" id="newGroup" class="groupEdit line" ><div class="icon fam-vcard unit"></div><div class="inputBox lastUnit" style="padding:2px;"><input type="text" class="input" id="newGroupInput" name="newGroup" value="<?php echo CrmModule::get()->defaultNewGroupName; ?>" /></div></li>
				<?php foreach($groups as $g): ?>
					<li data-id="<?php echo $g->id; ?>" class="group"><span class="icon fam-vcard"></span>&nbsp;<a href="#" class="group-name"><?php echo $g->name; ?></a><a class="group-delete" href="#">x</a></li>
				<?php endforeach; ?>
			</ul>
		</div>
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
	groupScroll:{},
	init:function(){
		cBook.initUserScroll();
		cBook.initGroupScroll();
		cBook.initUserDrag();
	},
	reinit:function(){
		cBook.userScroll.reinitialise();
		cBook.groupScroll.reinitialise();
		cBook.initUserDrag();
	},
	//initialises the scroll bar for the user list
	initUserScroll:function(){
		var timer;
		cBook.userScroll = $('#userListScroll')
			.bind('jsp-scroll-y',function(event, scrollPositionY, isAtTop, isAtBottom){
				$('#userListScroll .jspDrag').stop(1,0).css('opacity','0.7').show();
				if (timer) {
					clearTimeout(timer);
				}
				timer = setTimeout( function(){
					timer = null;
					$('#userListScroll .jspDrag').stop(1,0).delay(400).fadeOut(500);
					//scrollStop(scrollPositionY);
				}, 300);
			})
			.jScrollPane({
				verticalDragMinHeight: 20,
				verticalGutter:0,
				hideFocus:1,
				autoReinitialise:true
			})
			.data('jsp');
		$('#userListScroll .jspDrag').hide();
		$('#userListScroll').delegate('.jspContainer','mouseenter',function(){
			$('#userListScroll .jspDrag').stop(1,0).fadeTo(100,0.7).delay(400).fadeOut();
		});
		$('#userListScroll').delegate('.jspContainer','mouseleave',function(){
			$('#userListScroll .jspDrag').stop(1,0).delay(300).fadeOut();
		});
	},
	//initialises the scroll bar for the user list
	initGroupScroll:function(){
		var timer;
		cBook.groupScroll = $('#groupListScroll')
			.bind('jsp-scroll-y',function(event, scrollPositionY, isAtTop, isAtBottom){
				$('#groupListScroll .jspDrag').stop(1,0).css('opacity','0.7').show();
				if (timer) {
					clearTimeout(timer);
				}
				timer = setTimeout( function(){
					timer = null;
					$('#groupListScroll .jspDrag').stop(1,0).delay(400).fadeOut(500);
					//scrollStop(scrollPositionY);
				}, 300);
			})
			.jScrollPane({
				verticalDragMinHeight: 20,
				verticalGutter:0,
				hideFocus:1
			})
			.data('jsp');
		$('#groupListScroll .jspDrag').hide();
		$('#groupListScroll').delegate('.jspContainer','mouseenter',function(){
			$('#groupListScroll .jspDrag').stop(1,0).fadeTo(100,0.7).delay(400).fadeOut();
		});
		$('#groupListScroll').delegate('.jspContainer','mouseleave',function(){
			$('#groupListScroll .jspDrag').stop(1,0).delay(300).fadeOut();
		});
	},
	// initialises the abaility to drag contacts from the contact list
	// into groups
	initUserDrag:function(){
		$('#userListScroll .userList li').draggable({
			scope:'group',
			addClasses:false,
			revert:'invalid', //reverts the helper to original position if not dropped
			cursorAt:{left: 0, top: 15},
			start:function(event, ui){
				// dragging has started add class to indicate all the draggables that are being dragged
				// this refers to the element being dragged (not the helper the actual element)
				$(this).addClass('selected');
				$('#userListScroll .userList').addClass('dragging');
			},
			stop:function(){
				$('#userListScroll .userList').removeClass('dragging');
			},
			helper:function(){
				$(this).addClass('selected');
				var count = $('#userListScroll .userList .selected').length;
				// select a nice image
				// be very cool to use actual images...
				var img = 'drag-contact-5';
				if(count>0 && count<6){
					img = 'drag-contact-'+count;
				}
				var helperHtml = '<div class="dragHelper"><img class="img" src="<?php echo CrmModule::get()->getAssetsUrl(); ?>/images/'+img+'.png" />';
				helperHtml += '<span class="bg bigNumber">'+count+'</span></div>';
				return $(helperHtml).appendTo('body').get()
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
				var $group = $(this);
				var groupId = $group.data('id');
				$('#userListScroll .userList .selected').each(function(i,e){
					contacts += $(e).data('id') + ',';
				});
				$group.find('.icon.fam-vcard').removeClass('fam-vcard').addClass('fam-hourglass');
				$.post("<?php echo NHtml::url('/crm/index/addToGroup'); ?>",{"groupId":groupId,"contacts":contacts},function(r){
					$group.effect("highlight", {}, 1500);
					$group.find('.icon').removeClass('fam-hourglass').addClass('fam-vcard');
				});
			}
		});
	},
	// enables the user to add a group to the group list
	addGroup:function(){
		$('#newGroup').show();
		$('#newGroupInput').val("<?php echo CrmModule::get()->defaultNewGroupName; ?>");
		$('#newGroupInput').select().bind('keyup blur', function(e){
			// escaped
			if(e.type === 'keyup' && e.keyCode === 27){
				$('#newGroup').hide();
				$('#newGroupInput').unbind('keyup blur');
				return;
			}
			if(e.type === 'keyup' && e.keyCode !== 13) return;
			// unbind to prevent calling this function from the blur event
			$('#newGroupInput').unbind('keyup blur');
			// they hit enter or left the text field lets update!
			$.post("<?php echo NHtml::url('/crm/index/addGroup'); ?>", 'group='+$('#newGroupInput').val(), function(r){
				// unbind
				$('#groups').append('<li data-id="'+r.id+'" class="group"><span class="icon fam-vcard"></span> <a href="#">'+r.name+'</a><a class="group-delete" href="#">x</a></li>');
				$('#newGroup').hide();
				cBook.reinit();
			},'json');
		});
		return false;
	},
	loadContactList:function(selectContactId){
		var grpId = $('#groups .selected').data('id');
		$.ajax({
			url:'<?php echo NHtml::url('/crm/index/findContact'); ?>?term='+$('#contactSearch').val()+'&group='+grpId,
			type:'post',
			success:function(r){
				$('#userListScroll .userList').replaceWith(r);
				cBook.reinit();
				if(selectContactId == undefined){
					$firstContact = $('#userListScroll .userList .contact:first');
					$firstContact.trigger('click');
				}else{
					$('#cid_'+selectContactId).trigger('click');
					cBook.userScroll.scrollToElement($('#cid_'+selectContactId));
				}
			}
		});
	}
}

$(function(){
	
	cBook.init();
	$('#addGroup').click(function(){return cBook.addGroup();});
	$('#groups').delegate('li', 'click', function(e){
		var $grpLi = $(this);
		if($(e.target).is('.group-delete')){
			// clicked on delete this group!
			if(confirm('Are you sure you want to delete the "'+$(this).find('.group-name').html()+'" group?')){
				$.post("<?php echo NHtml::url('/crm/index/deleteGroup/') ?>","group="+$grpLi.data('id'),function(){
					// deleted, lets remove it.
					$grpLi.slideUp(250, function(){$grpLi.remove();});
				});
			};
			return false;
		}
		if($grpLi.is('.selected')) return false;
		$(this).parent().find('li').removeClass('selected');
		$(this).addClass('selected');
		cBook.loadContactList();
		return false;
	});
	$('#groups').delegate('li', 'dblclick', function(e){
		var $grpLi = $(this);
		var $grpName = $grpLi.find('.group-name');
		var $inlineEdit = $('<div id="inlineEdit" class="inputBox" style="padding:0px;"><input type="text" value="'+$grpName.html()+'" /></div>')
			.appendTo('body')
			.width(($grpLi.width()-28))
			.position({'my':'top left','at':'top left','of':$grpLi,'offset':'8 0'})
		var $input = $inlineEdit.find('input')
		$input.select().bind('keyup blur',function(e){
			if(e.type === 'keyup' && e.keyCode === 27){
				// escape, ignore changes
				$inlineEdit.remove();$grpLi.find('.group-delete').css('display','');$grpName.show();
			}
			if(e.type === 'keyup' && e.keyCode !== 13) return;
			$input.unbind('keyup blur');
			// change name
			if($grpName.html() == $input.val()){
				// no change don't bother
				$inlineEdit.remove();$grpLi.find('.group-delete').css('display','');$grpName.show();
			}else{
				$.post("<?php echo NHtml::url('/crm/index/groupRename'); ?>",{"gid":$grpLi.data('id'),"groupName":$input.val()},function(r){
					$grpName.html(r.name);
					$inlineEdit.remove();$grpLi.find('.group-delete').css('display','');$grpName.show();
				},'json')
			}
		});
		$grpLi.find('.group-delete').hide();
		$grpName.hide();
	});
		
	//$('.jspDrag').hide();
	


	var lastContactClicked = {};
	$('.contactBook').delegate('.userList li.contact','click',function(e){
		// can check event for shiftKey and ctrlKey
		var $contact = $(this);
		if(e.ctrlKey === true){
			if($contact.is('.selected')){
				$contact.removeClass('selected');
			}else{
				$contact.addClass('selected');
			}
		} else if(e.shiftKey === true){
			var start = $('.userList li.contact').index(this);
			var end = $('.userList li.contact').index(lastContactClicked);
			for(i=Math.min(start,end);i<=Math.max(start,end);i++) {
				$('.userList li.contact').eq(i).addClass('selected');
			}
		} else {
			$(this).parent().find('.selected').removeClass('selected');
			$(this).addClass('selected');
			$('#contactEdit').show();$('#contactDelete').show();$('#contactCancel').hide();$('#contactSave').hide();
			if ($(this).attr('id')){
				var id = $(this).attr('id').replace('cid_','');
				$('#detailsScreen').load('<?php echo NHtml::url("/crm/detail/index"); ?>?id='+id);
			} else {
				$('#detailsScreen').load("<?php echo NHtml::url('/crm/index/getContactForm'); ?>");
			}
		}
		lastContactClicked = this;
		cBook.reinit();
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
		$('<li class="contact mystery"><div class="media"><a class="img" href="#"><img width="24" alt="Mystery Image" src="http://localhost/newicon/project-manager/app/Nworx/Crm/theme/assets/mistery-img.png"></a><div class="bd"><p class="mlm">Add</p></div></li>')
			.prependTo($ul).addClass('selected');
		cBook.userScroll.scrollTo(0,0);
		$('#detailsScreen').load("<?php echo NHtml::url('/crm/index/getContactForm'); ?>");
		cBook.reinit();
		return false;
	});
	// save
	$('#detailsScreen').delegate('#contactForm','submit',function(){
		$f = $('#contactForm');
		var data = $f.serialize();
		var $li = $('.userList li.selected');
		$.ajax({
			url:$f.attr('action'),
			type:'post',
			dataType:'json',
			data:data,
			success:function(r) {
				if (r.id == false) return;
				// refresh user list
				cBook.loadContactList(r.id);
				cBook.reinit();
				if(r.createdCompany){
					// a new company was also created!
					// lets add it to the list
					$('<li class="contact"></li>')
						.attr('id',r.createdCompany.id)
						.html(r.createdCompany.card)
						.insertAfter($li);
					cBook.reinit();
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
		cBook.loadContactList();
	});

	$('.alpha a').click(function(){
		var letter = $(this).attr('href').replace('#','');
		var s2el = $('a[name="'+letter+'"]');
		if(s2el.length != 0){
			cBook.userScroll.scrollToElement(s2el);
		}else{
			$.ajax({
				url:'<?php echo NHtml::url('/crm/index/find-contact-alpha'); ?>/'+letter,
				type:'post',
				success:function(r){
					$('#userListScroll').html(r);
					cBook.reinit();
				}
			})			
		}
		return false;
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
			resizer();
			//$('#groupList').css('height','');
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
				$('#groupList').css('height',(winHeight - $('#groupList').offset().top - paddingBottom) + 'px');
				$('#groupListScroll').css('height',(winHeight - $('#groupListScroll').offset().top - paddingBottom) + 'px');
				//$('#messageScroll').css('height',(winHeight-$('#messageScroll').position().top-paddingBottom)+'px');
				//$('#email').css('height',(winHeight-$('#email').position().top-paddingBottom)+'px');
				//$('#messageFolders').css('height',(winHeight-$('#messageFolders').position().top-paddingBottom)+'px');
			}
			cBook.reinit();
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
