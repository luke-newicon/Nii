/*
 * The Notes Javascript
 * 
 * @author Matt Turner
 * @version 0.1
 */
(function($){
	var settings={
		'itemId'        : null,
		'ajaxLocation'  : '',
		'model'         : '',
		'model-id'    : '',
		'listId'		: ''
	};
	var methods={
		// run when the application starts
		init : function(options){
			
			// INITIATION ------------------------------------------------------
			
			// Do not delete, this overides the default settings with those
			// supplied when setting up the plugin.
			// These are then stored as data options on the base tag.
			if(options)
				$.extend(settings,options);
			this.data(options);
			
			var id = this.attr('id');
			
			// If the ajax location is not set by this stage then display an 
			// error.
			if(this.attr("ajaxLocation")==''){
				alert("You need to specify a location to ajax to");
			}
			
			$('#'+id).delegate('#'+id+' .line.note', 'mouseover', function(){
				var did=$(this).data('noteid');
				$('#'+id+' .note'+did+' .nnote-controls').show();
			});
			
			$('#'+id).delegate('#'+id+' .line.note', 'mouseout', function(){
				 var did=$(this).data('noteid');
				 $('#'+id+' .note'+did+' .nnote-controls').hide();
			});
			
			// Edit note button
			$('#'+id).delegate('#'+id+' .noteInput', "keyup", function(){
				value = $(this).val();
				if(value==""){
					$('#'+id+' .add-note-button').attr('disabled','disabled');
				}else{
					$('#'+id+' .add-note-button').removeAttr('disabled');
				}
			});
				
			// BUTTON CLICKS ---------------------------------------------------
			
			// Add note button
			this.find(".add-note-button").click(function(){
				$('#'+id).NNotes("addNote");
				return false;
			});
			
			// Delete note button
			this.delegate(".nnote-delete", "click", function(){
				var noteId = $(this).parent().parent().parent().parent().data('noteid');
				var model = $(this).parent().parent().parent().parent().data('model');
				var modelId = $(this).parent().parent().parent().parent().data('modelid');
				$('#'+id).NNotes("deleteNote",noteId,model,modelId);
				return false;
			});
			
			// Edit note button
			this.delegate(".nnote-edit", "click", function(){
				var noteId = $(this).parent().parent().parent().parent().data('noteid');
				$('#'+id).NNotes("editNote",noteId);
				return false;
			});
			
			// Cancel note button
			this.delegate(".nnote-cancel-button", "click", function(){
				$('#'+id).NNotes("closeEditView");
				return false;
			});
			
			// Cancel note button
			this.delegate(".noteInput", "focusout", function(){
				if($(this).val()==""){
					$('#'+id).NNotes("closeEditView");
				}
			});
			
			// Updates a note
			this.delegate(".nnote-edit-note", "click", function(){
				var noteId = $(this).parent().parent().parent().parent().parent().data('noteid');
				var noteText = $(this).parent().parent().find('.nnote-update-note').val();
				
				$.ajax({
					url: settings.ajaxLocation,
					type: "POST",
					data: ({noteId:noteId,action:'updateNote',noteText:noteText}),
					success: function(){
						$('#'+id).NNotes("refreshNote");
					}
				});
				return false;
			});
			
			// Cancels editing a note
			this.delegate(".nnote-edit-note-cancel", "click", function(){
				$('#'+id).NNotes("refreshNote");
			});
			
			// Clicking in the textbox
			this.find(".newNoteBox").click(function(){
				$('#'+id).NNotes("addNewNoteSwitch");
			});
		},
		
		// Switches to the add new note text entry screen
		addNewNoteSwitch : function(){
			var $newNoteBox = $(this).find(".newNoteBox");
			$newNoteBox.hide();
				
			var $addNoteButton = $(this).find('.add-note-button');
			$addNoteButton.attr('disabled','disabled');

			$(this).find(".markdownInput").fadeTo(0,0.1);
			$(this).find(".markdownInput").fadeTo(500,1);
			$(this).find('textarea').focus();
			return false;
		},
		
		// PREVIEW A NOTE ------------------------------------------------------
		previewNoteSwitch : function(){
			var id = this.attr('id');
			$('#'+id+' .markdownInput').markdown("preview");
		},
		
		
		// SWITCH TO EDIT ------------------------------------------------------
		// Switches the markdown area to edit mode. Note the area needs to be
		// active for the change to be visible.
		editNoteSwitch : function(){
			var id = this.attr('id');
			$('#'+id+' .markdownInput').markdown("edit");
		},
		
		// CLOSE EDIT VIEW
		closeEditView : function(){
			var id = this.attr('id');
			$("#"+id+" .newNoteBox").show();
			$("#"+id+" .noteInput").val('');
			$("#"+id+" .markdownInput").hide();
		},
		
		// EDIT A NOTE ---------------------------------------------------------
		editNote: function(noteId){
			var id = this.attr('id');
			var $item = $('#'+id+' .note'+noteId+'.note .nnote-text');
			
			$.ajax({
					url: settings.ajaxLocation,
					type: "POST",
					data: ({noteId:noteId,action:'editNote'}),
					success: function(note){
						$item.html(
						"<div class=\"field\"><div class=\"input\"><textarea class=\"nnote-update-note\" rows=\"2\">"+note+"</textarea></div><div class=\"txtR\" style=\"margin:10px 0px;\"><input type=\"button\" class=\"btn nnote-edit-note-cancel\" value=\"Cancel\"/><input type=\"button\" style=\"margin-left:4px;\" class=\"btn primary nnote-edit-note\" value=\"Update\"/></div></div>");
					}
				});
		},
		
		
		// DELETE A NOTE -------------------------------------------------------
		deleteNote: function(noteId,model,modelId){
			var id = this.attr('id');
			if(confirm("Are you sure you want to delete the note?")){
				$.ajax({
					url: this.data('ajaxLocation'),
					type: "POST",
				dataType: "json",
					data: ({noteId:noteId,action:'deleteNote',note_model:model,model_id:modelId}),
					success: function(response){
						$('.notes_count').html(response.count);
						$('#'+id).NNotes("refreshNote");
					}
				});
			}
		},
		
		
		// REFRESH A NOTE ------------------------------------------------------
		refreshNote: function(){
			var id = this.attr('id');
			//finds the id of the list view
			var listId = $('#'+id).find('.list-view.NNotes-list').attr('id');
			$.fn.yiiListView.update(listId);
		},
		
		// HIGHLIGHT A NOTE
		highlightNote: function(){
			var id = this.attr('id');
			var $object = $('#'+id).parent().parent();
			if($object.data('addedItem')){
				$('#'+$object.attr('id')+ ' .note'+$object.data('addedItem')).effect("highlight",2000);
				$object.data('addedItem','');
			}
		},
		
		
		// ADD A NOTE ----------------------------------------------------------
		addNote: function(){
			var id = this.attr('id');
			var dModel = this.data('model');
			var	dNote = $('#'+id + ' .noteInput').val();
			
			// if no note text then exit
			if(dNote==""|| dNote == null){
				return false;
			}

			$.ajax({
				url: settings.ajaxLocation,
				type: "POST",
				dataType: "json",
				data: ({
					model_id:$(this).data('model-id'),
					model:dModel,
					note:dNote,
					action:'addNote'}),
				success: function(response){
					newNoteId = response.id;
					$('#'+id+' .noteInput').val('');
					$('.notes_count').html(response.count);
					$('#'+id).data('addedItem',newNoteId);
					$('#'+id).NNotes("refreshNote");
					$('#'+id).NNotes("closeEditView");
					$('.line.note.note'+newNoteId).effect("highlight");
				}
			});
		}
	};
	$.fn.NNotes = function(method){
		if (methods[method]){
			return methods[method].apply(
				this,
				Array.prototype.slice.call(
					arguments,
					1));
		}else if (typeof method === 'object' || ! method)
			return methods.init.apply(this,arguments);
		else
			$.error('Method '+method+' does not exist on jQuery.tooltip');
	};
})(jQuery);
