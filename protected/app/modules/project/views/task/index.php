<?php

/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
Yii::app()->getClientScript()->registerPackage('backbone');

?>

<div id="task-form" class="field">
	<div class="line input">
		<div class="unit size3of4  ">
			<label for="task" class="inFieldLabel">Add a task...</label>
			<div>
				<input class="task" name="task" id="task" type="text" value="" />
			</div>
		</div>
		<div class="unit size1of10" style="border-left:1px solid #ccc;padding-left:3px;">
			<div class="line">
				<div class="unit sprite project-clock" style="cursor:pointer"></div>
				<div class="lastUnit" style="padding-left:3px;">
					<input name="estimated_time" type="text" />
				</div>
			</div>
		</div>
		<div class="lastUnit" style="border-left:1px solid #ccc;padding-left:3px;">
			<div class="unit sprite project-user" style="cursor:pointer"></div>
			<div class="lastUnit" style="padding-left:3px;">
				<input name="asigned_id" type="text" />
			</div>
		</div>
	</div>
</div>




<script id="quick-select" type="template/text">
	<div style="width:100px;border:1px solid #ccc;">
		<ul>

		</ul>
	</div>
</script>

<script id="task-list-template" type="text/template">
	
</script>

<script id="task-template" type="text/template">
	<div class="line">
		<div class="unit size3of4 task">
			<%= name %>
		</div>
		<div class="unit">
			<%= etsimated_time_nice %>
		</div>
		<div class="lastUnit">
			
		</div>
	</div>
</script>

<script id="task-form-template" type="text/template">
	
</script>
<script>
/** autogrow plugin */
(function($){$.fn.autogrow=function(options){this.filter('textarea').each(function(){var $this=$(this),minHeight=$this.height(),lineHeight=$this.css('lineHeight');var shadow=$('<div></div>').css({position:'absolute',top:-10000,left:-10000,width:$(this).width()-parseInt($this.css('paddingLeft'))-parseInt($this.css('paddingRight')),fontSize:$this.css('fontSize'),fontFamily:$this.css('fontFamily'),lineHeight:$this.css('lineHeight'),resize:'none'}).appendTo(document.body);var update=function(){var times=function(string,number){for(var i=0,r='';i<number;i++)r+=string;return r;};var val=this.value.replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/&/g,'&amp;').replace(/\n$/,'<br/>&nbsp;').replace(/\n/g,'<br/>').replace(/ {2,}/g,function(space){return times('&nbsp;',space.length-1)+' '});shadow.html(val);$(this).css('height',Math.max(shadow.height(),minHeight));}
$(this).change(update).keyup(update).keydown(update);update.apply(this);});return this;}})(jQuery);

/*
 *
 * Copyright (c) 2010 C. F., Wong (<a href="http://cloudgen.w0ng.hk">Cloudgen Examplet Store</a>)
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 */
﻿(function(k,e,i,j){k.fn.caret=function(b,l){var a,c,f=this[0],d=k.browser.msie;if(typeof b==="object"&&typeof b.start==="number"&&typeof b.end==="number"){a=b.start;c=b.end}else if(typeof b==="number"&&typeof l==="number"){a=b;c=l}else if(typeof b==="string")if((a=f.value.indexOf(b))>-1)c=a+b[e];else a=null;else if(Object.prototype.toString.call(b)==="[object RegExp]"){b=b.exec(f.value);if(b!=null){a=b.index;c=a+b[0][e]}}if(typeof a!="undefined"){if(d){d=this[0].createTextRange();d.collapse(true);
d.moveStart("character",a);d.moveEnd("character",c-a);d.select()}else{this[0].selectionStart=a;this[0].selectionEnd=c}this[0].focus();return this}else{if(d){c=document.selection;if(this[0].tagName.toLowerCase()!="textarea"){d=this.val();a=c[i]()[j]();a.moveEnd("character",d[e]);var g=a.text==""?d[e]:d.lastIndexOf(a.text);a=c[i]()[j]();a.moveStart("character",-d[e]);var h=a.text[e]}else{a=c[i]();c=a[j]();c.moveToElementText(this[0]);c.setEndPoint("EndToEnd",a);g=c.text[e]-a.text[e];h=g+a.text[e]}}else{g=
f.selectionStart;h=f.selectionEnd}a=f.value.substring(g,h);return{start:g,end:h,text:a,replace:function(m){return f.value.substring(0,g)+m+f.value.substring(h,f.value[e])}}}}})(jQuery,"length","createRange","duplicate");



$(function(){
	
	
	var CUser = Backbone.Model.extend({
		defaults:{
			name:'',
			image:''
		}
	});
	
	var CUserList = Backbone.Collection.extend({
		model:CUser
	});
	
	var CTask = Backbone.Model.extend({
		defaults:{
			name:'',
			description:'',
			estimated_time_nice:''
		}
	})
	
	var CTaskList = Backbone.Collection.extend({
		model:CTask
	})
	
	
	var CTaskFormView = Backbone.View.extend({
		el:$('#task-form'),
		initialize:function(){
			this.$('textarea').autogrow();
			
		},
		events:{
			'keyup #task':'keyupTask',
			'keyup':'keyup'
		},
		render:function(){
			
		},
		keyup:function(e){
			if(e.which == 13){
				window.niiTask.tasks.add(this.createTask());
				e.preventDefault();
				return false;
			}
		},
		createTask:function(){
			return new CTask({
				name:this.$('[name="task"]').val(),
				estimated_time:this.$('[name="estimated_time"]').val(),
				asigned_id:this.$('[name="asigned_id"]').val()
			});
		},
		keyupTask:function(e){
			var searchwrds = this.$('#task').val().split(" ");
			$.each(searchwrds,function(i,val){
			   //check if its an empty string 
				if($.trim(val) == ""){
					searchwrds.splice(i);
				} else {
					var userMatches = window.niiTask.users.filter(function(u){
						if(val.length>2)
							return u.get('name').toLowerCase().substring(0, val.length) == val;
					});
					if(userMatches.length > 0){
						searchwrds.splice(i); // remove this text from the box
						
						userMatches[0].get('name');
					}
				}
			});	
		}
	});
	
	/**
	 * view responsible for drawing the list of task views 
	 */
	var CTaskListView = Backbone.View.extend({
		el:$('#task-list'),
		template:_.template($('#task-list-template').html()),
		events:{},
		initialize:function(){
		
		},
		render:function(){
		
		}
		
	})
	
	/**
	 * view responsible for drawing the list of task views 
	 */
	var CTaskView = Backbone.View.extend({
		template:_.template($('#task-template').html()),
		events:{},
		initialize:function(){
		
		},
		render:function(){
		
		}
		
	})
	
	var CProjectTask = Backbone.Model.extend({
		run:function(){
			// configure it all biatch
			this.taskForm = new CTaskFormView()
			this.users = new CUserList();
			this.tasks = new CTaskList();
			
			this.tasksView = new CTaskListView({
				collection:this.tasks
			});
			
			this.users.reset([{name:'steve'},{name:'robin'},{name:'luke'},{name:'Dan'},{name:'Matthew'}]);
			this.tasks.reset(<?php echo $tasks; ?>);
		}
	});
	
	
	
	
	// start things up!
	window.niiTask = new CProjectTask();
	window.niiTask.run();
	
});
	
</script>