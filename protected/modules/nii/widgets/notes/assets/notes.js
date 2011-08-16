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
		'noteNumber'    : '',
		'listId'		: ''
	};
	var methods={
		// run when the application starts
		init : function(options){
			
			// INITIATION ------------------------------------------------------
			
			// Do not delete, this overides the default settings with those
			// supplied when setting up the plugin.
			if(options)
				$.extend(settings,options);
			this.data(options);
			// If the ajax location is not set by this stage then display an 
			// error.
			if(settings.ajaxLocation==''){
				alert("You need to specify a location to ajax to");
			}
			
			// Discovers the id of the instance of the object and stores as a 
			// setting.
			var $NNotes = this;
			settings.itemId=$NNotes.attr('id');
			
			$('#'+settings.itemId+' .line.note').hover(
			  function () {
				var did=$(this).data('noteid');
				$('#'+settings.itemId+' .note'+did+' .nnote-controls').fadeIn("medium");
			  },
			  function () {
				  var did=$(this).data('noteid');
				  $('#'+settings.itemId+' .note'+did+' .nnote-controls').fadeOut("medium");
			  }
			);

			// The id of the list view
			settings.listId=$('#'+settings.itemId+' .NNotes-list').attr('id');
			
			// BUTTON CLICKS ---------------------------------------------------
			
			// Add note button
			$NNotes.find(".add-note-button").click(function(){
				$NNotes.NNotes("addNote");
			});
			
			// Delete note button
			$NNotes.delegate(".nnote-delete", "click", function(){
				var noteId = $(this).parent().parent().data("noteid");
				$NNotes.NNotes("deleteNote",noteId);
			});
			
			// Edit note button
			$NNotes.delegate(".nnote-edit", "click", function(){
				var noteId = $(this).parent().parent().data("noteid");
				$NNotes.NNotes("editNote",noteId);
			});
			
			// Clicking in the textbox
			$NNotes.find(".newNoteBox").click(function(){
				$(this).hide();
				$(this).parent().children(".markdownInput").fadeIn(
				"medium",function(){
					$(this).find('textarea').focus();
				 });
			});
		},
		
		// PREVIEW A NOTE ------------------------------------------------------
		previewNoteSwitch : function(){
			$('#'+settings.itemId+' .markdownInput').markdown("preview");
		},
		
		
		// SWITCH TO EDIT ------------------------------------------------------
		editNoteSwitch : function(){
			$('#'+settings.itemId+' .markdownInput').markdown("edit");
		},
		
		// CLOSE EDIT VIEW
		closeEditView : function(){
			var fakeBox = $(this).find("#"+settings.itemId+" .fakeBox");
			
			//$(this).fadeOut();
			$(fakeBox).fadeIn("medium");
		},
		
		// EDIT A NOTE ---------------------------------------------------------
		editNote: function(noteId){
			var item = $('#'+settings.itemId+' .note'+noteId + ' .note');
			var text = item.html();
			
			$.ajax({
					url: settings.ajaxLocation,
					type: "POST",
					data: ({noteId:noteId,action:'editNote'}),
					success: function(note){
						$('#'+settings.itemId +' .note.note'+noteId+' .nnote-edit').hide();
						$('#'+settings.itemId +' .note.note'+noteId+' .nnote-cancel').show();
						item.html(
						"<div><textarea rows=\"2\" cols=\"160\">"+note+"</textarea></div><div><input type=\"button\" class=\"btn btnN\" value=\"Update\"/></div>");
					}
				});
			
		},
		
		
		// DELETE A NOTE -------------------------------------------------------
		deleteNote: function(noteId){
			if(confirm("Are you sure you want to delete the note?")){
				$.ajax({
					url: settings.ajaxLocation,
					type: "POST",
					data: ({noteId:noteId,action:'deleteNote'}),
					success: function(){
						$(this).NNotes("refreshNote");
					}
				});
			}
		},
		
		
		// REFRESH A NOTE ------------------------------------------------------
		refreshNote: function(){
			var listId = settings.listId;
			$.fn.yiiListView.update(listId);
		},
		
		
		// ADD A NOTE ----------------------------------------------------------
		addNote: function(){
			var dItemId = settings.itemId;
			var dModel = settings.model;
			var	dNote = $('#'+settings.itemId + ' .noteInput').val();

			$.ajax({
				url: settings.ajaxLocation,
				type: "POST",
				data: ({
					noteNumber:$(this).data('notenumber'),
					model:dModel,
					note:dNote,
					action:'addNote'}),
				success: function(){
					$('#'+settings.itemId+' .noteInput').val('');
					$(this).NNotes("refreshNote");
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
