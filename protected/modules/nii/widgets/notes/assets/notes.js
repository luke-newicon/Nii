/*
 * The Notes Javascript
 * 
 * @author Matt Turner
 * @version 0.1
 */
(function($){
	
	var settings={
		'itemId'           : null,
		'ajaxLocation'     : '',
		'model' : ''
	};
		
	var methods={
		// run when the application starts
		init : function(options){
			var $NNotes = this;
			
			// bind events
			$NNotes.find(".newNoteBox").click(function(){
				$(this).hide();
				$(this).parent().children(".markdownInput").fadeIn("medium",function() {
					$(this).find('textarea').focus();
				 });
			});
			
			$NNotes.find(".add-note-button").click(function(){
				$NNotes.NNotes("addNote");
			});
			
			// Do not delete, this overides the default settings.
			if(options){ 
				$.extend(settings,options);
			}
			
			// If the ajax location is not set by this stage then display an 
			// error.
			if(settings.ajaxLocation == ''){
				alert("You need to specify a location for the notes plugin to ajax to");
			}
		},
		
		// Preview a note
		previewNote : function(options){
			//$().markdown("preview");
		},
		
		// Edit a note
		editNote: function(options){
			//$().markdown("edit");
		},
		
		// Delete a note
		deleteNote: function(options){
			alert("delete a note");
		},
		
		// Refresh a note
		refreshNote: function(options){
			location.reload();
		},
		
		// Add a note
		// Note: A value must be present in the text field for it to send
		addNote: function(options){
			var dItemId = settings.itemId;
			var dModel = settings.model;
			var	dNote = $('#NFile_nnote').val();

			// If value is blank then exit function
			$.ajax({
				url: settings.ajaxLocation,
				type: "POST",
				data: ({itemId:dItemId,model:dModel,note:dNote,action:'addNote'}),
				success: function(){
					$(this).NNotes("refreshNote");
				}
			});
		}
	};
	
	$.fn.NNotes = function(method){
		// Runs methods on the object
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
		}   
	};
})(jQuery);
