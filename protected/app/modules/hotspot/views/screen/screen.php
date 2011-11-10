<style type="text/css" media="screen">
	body{overflow:hidden;}
	#canvas{margin: 0 auto;position:relative;cursor:crosshair;}
	.hotspot .ui-resizable-se{bottom:-5px;right:-5px;}
	.hotspot .ui-icon-gripsmall-diagonal-se{background-position: -68px -229px;}
	.viewspots .hotspot {background-color:#75ff4b;border-radius:5px; opacity:0.6;filter: alpha(opacity=50);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";}
	.disabled .icon {opacity:0.5;}
	.share-link{padding:5px;border:1px solid #ccc;background-color:#f9f9f9;border-radius:5px;}
	.blackpopMessage{background-color: rgba(0, 0, 0, 0.7);border: 1px solid #CCCCCC;border-radius: 20px;box-shadow: 0 0 10px 0px #000000;color: #FFFFFF;display: none;font-size: 19px; opacity: 1;padding: 10px; position: absolute;width: 281px;}
	#canvas-start{text-align:center;}
</style>

<div id="hotspot">

	<div id="mainToolbar" class="toolbar" style="width:100%;">
		<div class="line plm">
			<div class="unit titleBarText">
				<span class="hotspot-logo"><a style="width:auto;padding-left:20px;" class="icon hotspot-logo" href="<?php echo NHtml::url('/project/index/index'); ?>"><strong>HOT</strong>SPOT</a></span>
			</div>
			<div class="unit toolbarArrow"></div>
			<div class="unit titleBarText">
				<?php echo $project->name; ?>
			</div>
		</div>
		<div id="titleBarRightMenu" class="menu"></div>
	</div>

	<div id="drop" class="dropzone" style="display:none;"></div>

	<div id="progress" class="pam blackpop">
		<div class="bar"></div>
		<div class="qty">Uploading <span class="current" style="font-weight:bold;"></span> of <span class="total" style="font-weight:bold;"></span> - <span class="percent"></span> <span class="size"></span></div>
	</div>

	<div id="screen-list" style="position:absolute; width:200px; top:48px;height:400px;border-right:1px solid #000;"></div>
	<div id="canvas-wrap" style="position:absolute; top:47px; overflow: auto; left:200px; height: 400px;"></div>

	<div id="template-form" class="spotForm toolbarForm" style="position:fixed;display:none;"></div>
	<div id="share-form" class="spotForm toolbarForm" style="width:320px;position:fixed;display:none;"></div>

</div>

<?php $this->renderPartial('_templates'); ?>

<div id="flash-escape-message" class="txtC blackpopMessage">
	Press escape to exit preview
</div>





<script>
	
	$(function(){
		
		
		
		/**
		 * **********************
		 * Backbone awesomeness!!
		 * **********************
		 */
		var CRouter = Backbone.Router.extend({

			routes: {
				"s:query": "screen",  // screen/<screen-id>
				"s:query/preview": "preview"  // screen/<screen-id>/<preview>
			},
			initialize:function(){
				// bind the event so that when the url changes to the screen the screen updates
				this.bind('s:query', this.screen, this);
				this.bind('s:query/preview', this.preview, this);
				
			},
			// set the canvas to display the screen given by screenId parameter
			screen: function(screenId) {
				if(window.canvas.get('mode') == window.canvas.modes.preview){
					// we are trying to go back to a screen in edit or comment mode
					// so lets escape preview
					window.canvas.set({mode:window.canvas.modes.edit});
				}
				var s = window.screenList.get(screenId);
				window.canvas.set({screen:s});
				
			},
			preview:function(screenId){
				var s = window.screenList.get(screenId);
				window.canvas.set({screen:s});
				if(window.canvas.mode != window.canvas.modes.preview)
					window.canvas.set({mode:window.canvas.modes.preview});
			},
			// convienience function to be called by the app to navigate to the correct screen. And apply the scroll
			// position appropriately. The router then calls the screen function.
			// @param screenId the id of the screen to load
			// @param scrollTop whether to reset the scroll position to the top of the screen
			// @param escapePreview if true preview mode will be escaped
			actionScreen:function(screenId, scrollTop, escapePreview){
				if(scrollTop)
					$('#canvas-wrap').scrollTo(0);
				if(window.canvas.get('mode') == window.canvas.modes.preview && !escapePreview){
					window.router.navigate('s'+screenId+'/preview',true);
				}else{
					window.router.navigate('s'+screenId,true);
				}
			},
			actionPreview:function(){
				if(window.canvas.get('screen') === null)
					return false
				var screenId = window.canvas.get('screen').get('id');
				window.router.navigate('s'+screenId+'/preview',true);
			}

		});
		
		// create a new router object to handle the application urls
		// create this now as it doesnt have any other dependancies
		window.router = new CRouter;
		
		/**
		 * CCanvas
		 * -------
		 * 
		 * Our top  level application model
		 * Controls the active screen model (CScreen) being edited
		 * as well as the active CHotspot.
		 * This is also responsible for maintaining the application state.
		 * For example: comment mode/ edit mode etc.
		 */
		window.CCanvas = Backbone.Model.extend({
			// the position of the canvas screen
			modes:{edit:'edit',comment:'comment',preview:'preview'},
			defaults:{
				// the canvas edit, comment or preview mode
				mode:'edit',
				// the screen model
				screen:null,
				// the active hotspot being edited
				hotspot:null
			},
			initialize: function(){},
			/**
			 * set the hotspot that is in edit mode
			 * will display the hotspotFormView
			 */
			editHotspot: function(hs,options){
				this.set({'hotspot':hs},options);
			},
			screenExists: function(){
				return (this.get('screen') != null);
			},
			screenCount: function(){
				return window.screenList.length;
			}
		});
		
		
		/**
		 * CHotspot Model
		 * --------------
		 * 
		 * Corresponds to HotspotHotspot model
		 */
		window.CHotspot = Backbone.Model.extend({
			defaults:{
				screen_id_link:0,
				fixed_scroll:0,
				template_id:0,
				project_id:<?php echo $project->id ?>
			},
			destroy:function(options){
				Backbone.Model.prototype.destroy.call(this,options);
			},
			followLink:function(){
				var scrollTop = (this.get('fixed_scroll')==1)?false:true;
				if(this.get('screen_id_link')==0)
					return;
				window.router.actionScreen(this.get('screen_id_link'), scrollTop);
			},
			isTemplate:function(){
				return (this.get('template_id') != 0);
			}
		});
		
		/**
		 * CHotspotList Collection
		 * -----------------------
		 * 
		 * Stores a collection of all CHotspot models across all screens
		 */
		window.CHotspotList = Backbone.Collection.extend({
			model:CHotspot,
			url:'<?php echo NHtml::url(); ?>/api/project/<?php echo $project->id; ?>/hotspot',
			// return the number of hotspots on this screen
			hotspotScreenCount:function(){
				return this.getScreenHotspots().length;
			},
			// return a list of hotspots for the current canvas screen
			getScreenHotspots:function(){
				if(window.canvas.get('screen') == null) return [];
				
				return this.filter(function(h){
					// if we are in preview mode we do not want to display hotspots that have no link
					if (window.canvas.get('mode') == window.canvas.modes.preview)
						return (window.canvas.get('screen').get('id') == h.get('screen_id') && h.get('template_id') == 0 && h.get('screen_id_link') > 0);
					else
						return (window.canvas.get('screen').get('id') == h.get('screen_id') && h.get('template_id') == 0);
				});
			}
		})
		
		
		/**
		 *
		 */
		window.CProject = Backbone.Model.extend({
			
		});
		
		
		/**
		 * CScreen Model
		 * -------------
		 * 
		 * Corosponds to ProjectScreen
		 */
		window.CScreen = Backbone.Model.extend({
			// Default attributes for the todo.
			positions:{left:'left',center:'center',right:'right'},
			defaults: {
				position:'center',
				name: "",
				file_id:null,
				home_page:null,
				width:null,
				height:null,
				image_url:'',
				image_url_thumb:'',
				image_url_thumb_select:'',
				id:null,
				name:'new screen',
				project_id:null,
				sort:0,
				// property to determin if the screen is currently being uploaded
				uploading:false
			},
			initialze:function(){
				// create hotspots collection?
			},
			/**
			 * gets the name and formats it to highlight the last search string
			 * @return string html
			 */
			getNameSearchHighlight:function(){
				return this.getNameHighlight(window.screenList.nameSearchFilter)
			},
			/**
			 * return a string with the filter text highlighted in a strong tag
			 * @param string filterName
			 * @return string html
			 */
			getNameHighlight:function(highlight){
				return this.get('name').replace(
					new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(highlight) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>"
				);
			},
			/**
			 * update the image individual progress
			 * @param progress
			 */
			imageProgress:function(progress){
				// get the view
				this.view.uploadProgress(progress);
			},
			getHotspots:function(){
				
			},
			// when the screen is deleted!
			destroy:function(options){
				var next = window.screenList.next(this);
				var prev = window.screenList.prev(this);
				
				// so you want to remove this screen.
				// we want the next screen in the list to become selected (if one exists)
				// first it will look to see if one exists below. If not, select the one above, 
				// if no screens, then default to the start screen (empty canvas message)
				
				// select the next one by default
				if (next != undefined){
					window.router.actionScreen(next.get('id'));
				} 
				// select the previous one
				else if (prev != undefined) {
					window.router.actionScreen(prev.get('id'));
				}
				// no screens left so show empty canvas message
				else{
					window.canvas.set({screen:null});
				}
				
				// reload the hotspot list.
				// this fixes any problems with hotspots linking to the deleted screen
				window.hotspotList.fetch();
				
				Backbone.Model.prototype.destroy.call(this, options);
			}
		});
		
		
		/**
		 * CScreenList Collection
		 * ----------------------
		 * 
		 * stores a collection of CScreen Models
		 */
		window.CScreenList = Backbone.Collection.extend({
			url:'<?php echo NHtml::url(array('api/screen/')) ?>',
			// Reference to this collection's model.
			model: CScreen,
			/**
			 * store the last name search filter string. as passed to this.filterByNameSearch
			 */
			nameSearchFilter:'',
			/**
			 * function to filter screens by a partial string name match
			 * @param string screenNameSearch the search string to look up screens by name
			 * @return array
			 */
			filterByScreenName:function(nameSearchFilter){
				this.nameSearchFilter = nameSearchFilter;
				var matcher = new RegExp($.ui.autocomplete.escapeRegex(nameSearchFilter), "i");
				var filtered = this.filter(function(screen) {
					return (screen.get('id') && (!nameSearchFilter || matcher.test(screen.get('name'))));
				});
				return _.sortBy(filtered, function(s){
					return s.get('sort');
				});
			},
			updateOrder:function(){
				var order = {};
				this.forEach(function(screen){
					screen.set({sort:$(screen.view.el).index()});
					order[screen.get('id')] = screen.get('sort');
				}, this);
				// sync to server
				$.post("<?php echo NHtml::url('/project/screen/order') ?>",{order:order});
				window.hotspotFormView.renderTemplate();
			},
			comparator:function(screen){
				return screen.get('sort');
			},
			next:function(model){
				return this.at(this.indexOf(model) + 1)
			},
			prev:function(model){
				return this.at(this.indexOf(model) - 1);
			}			
		});
		
		/**
		 * CTemplate Model
		 * ----------------------
		 * 
		 */
		CTemplate = Backbone.Model.extend({
			urlRoot:'<?php echo NHtml::url(array('/api/ProjectTemplate/')) ?>',
			defaults:{
				name:'new template',
				project_id:<?php echo $project->id; ?>
			},
			validate:function(attrs){
				if(attrs.name == ''){
					return 'a template must have a name'
				}
			}
		});
		
		/**
		 * CTemplateList Collection
		 * ----------------------
		 * 
		 * represents a collection of CTemplate Models
		 */
		CTemplateList = Backbone.Collection.extend({
			model:CTemplate,
			url:'<?php echo NHtml::url(array('/api/ProjectTemplate/')) ?>'
		});
		
		
		/**
		 * CScreenTemplate Model
		 * ----------------------
		 * 
		 * represents templates applied to the screen
		 */
		CScreenTemplate = Backbone.Model.extend({
			urlRoot:'<?php echo NHtml::url(array('/api/ProjectScreenTemplate/')) ?>',
			defaults:{
				screen_id:null,
				template_id:null
			},
			destroy:function(){
				$.post("<?php echo NHtml::url(array('/project/screen/deleteScreenTemplate')) ?>",{
					template_id:this.get('template_id'),
					screen_id:this.get('screen_id')
				});
			}
		});
		

		/**
		 * CScreenTemplateList Collection
		 * ----------------------
		 * 
		 * represents templates applied to the screen
		 */
		CScreenTemplateList = Backbone.Collection.extend({
			model:CScreenTemplate,
			url:'<?php echo NHtml::url(array('/api/ProjectScreenTemplate/')) ?>',
			// returns true 
			getScreenTemplates:function(screenId){
				return this.filter(function(t){
					return (t.get('screen_id')==window.canvas.get('screen').get('id'))
				}, this);
			},
			// returns true if the template is applied to the current screen
			isScreenTemplate:function(templateId){
				if (window.canvas.get('screen') == null)
					return false;
				return this.any(function(t){
					return (t.get('template_id') == templateId && t.get('screen_id')== window.canvas.get('screen').get('id'))
				}, this);
			},
			getScreenTemplateHotspots:function(){
				// get all applied templates
				var appliedTemplates = this.getScreenTemplates();
				// get all hotspots which have a template_id matching any 
				// template_id's in the applied hotspot list
				templateHotspots = window.hotspotList.filter(function(h){
					return _.any(appliedTemplates,function(at){
						if (window.canvas.get('mode') == window.canvas.modes.preview)
							return (h.get('screen_id_link') > 0 && h.get('template_id') == at.get('template_id'));
						else
							return (h.get('template_id') == at.get('template_id'));
					}, this)
				},this);
				return templateHotspots;
			},
			// apply the template to the current screen
			applyTemplate:function(templateId){
				// link this template to the screen
				// by adding a new ScreenTemplate record which stores the template id to the screen id.
				if(!this.isScreenTemplate(templateId)){
					st = new CScreenTemplate({
						template_id:templateId,
						screen_id:window.canvas.get('screen').get('id')
					});
					st.save()
					window.screenTemplateList.add(st);
				}
			}
		});
		
		
		/**
		 * CLink Model
		 * -----------
		 * 
		 * represents a ProjectLink model
		 *
		 */
		CLink = Backbone.Model.extend({
			idAttribute:'link',
			urlRoot:'<?php echo NHtml::url(array('api/link')); ?>',
			defaults:{
				password:''
			}
		});
				
		window.link = new CLink();
		window.link.set(<?php echo $linkJson; ?>)
		
		
		
		/**
		 * CShareFormView View
		 * ---------------
		 * 
		 * Must pass in a CLink 
		 */
		window.CShareFormView = Backbone.View.extend({
			el:$('#share-form'),
			template:_.template($('#share-form-template').html()),
			initialize:function(){
				this.model = window.link;
				this.model.view = this;
				this.render();
			},
			events:{
				'click .ok':'close',
				'change #share-password':'save'
			},
			isVisible:function(){
				return $(this.el).is(':visible');
			},
			render:function(){
				$(this.el).html(this.template(this.model.toJSON()));
				$.fn.nii.form();
			},
			open:function(e){
				this.render();
				$('#mainToolbar .share').addClass('selected');
				if (this.el.is(':visible')){
					this.close();
					e.stopPropagation();
				}
				this.el.show().position({'my':'center top','at':'center bottom','of':$('#mainToolbar .share'),'offset':'0px 12px','collision':'none'});
				this.el.click(function(e){
					e.stopPropagation();
				});
				$('body').bind('click.shareForm',_.bind(function(){
					this.close();
				},this));
				e.stopPropagation();
			},
			close:function(){
				$('#mainToolbar .share').removeClass('selected')
				$('body').unbind('click.shareForm');
				this.el.hide();
				return false;
			},
			save:function(){
				this.model.save({
					password:$('#share-password').val()
				});
			}
			
		});
		

		/**
		 * CUploaderView View 
		 * -----------------
		 * 
		 * plupload view wrapper
		 */
		window.CUploaderView = Backbone.View.extend({
			// store the plupload instance
			uploader:null,
			totalPercent:0,
			currentImage:0,
			totalImages:0,
			url:'<?php echo NHtml::url(array('/project/details/upload/','projectId'=>$project->id)) ?>',
			initialize:function(){
                // create the pluploader instance
				this.uploader = new plupload.Uploader({
					runtimes : "html5,flash",
					browse_button : "pickfiles",
					//container : 'container',
					max_file_size : '10mb',
                    drop_element:"drop",
					url : this.url,
					flash_swf_url:"<?php echo $pluploadUrl = $this->createWidget('nii.widgets.plupload.PluploadWidget')->getAssetsUrl(); ?>/plupload.flash.swf",
                    filters: [
                        {
                            title: "Image files",
                            extensions: "jpg,jpeg,png,gif"
                        }
                    ]
				});
				this.uploader.init();
                if(!this.browserSupportsDragDrop()){
                    alert('Your browser does not support drag and drop uploading.')
                }
				this.uploader.bind('FilesAdded',	_.bind(this.filesAdded, this));
				this.uploader.bind('UploadProgress',_.bind(this.uploadProgress,this));
				this.uploader.bind('FileUploaded',	_.bind(this.fileUploaded,this));
				this.uploader.bind('UploadComplete',_.bind(this.uploadComplete,this));
				this.uploader.bind('Error',			_.bind(this.error,this));
			},
            browserSupportsDragDrop:function(){
				var support = true;
				
				// Disable internet explorer
				if ($.browser.msie) {
					support = false;
				}
				
				// Disable Opera
				if ($.browser.opera) {
					support = false;
				}
				
				// Disable mozilla under 3.6
				if ($.browser.mozilla && $.browser.version < 1.9) {
					support = false;
				}
				
				return support;	
            },
			filesAdded:function(up, files){
				$('#no-screens-info').fadeOut();
				if(!$('#progress').is(':visible'))
					$('#progress').fadeIn().position({'my':'center','at':'center','of':$(window)});
       
				_.each(files, function(file){

					screenName = file.name.replace(/\.[^\.]*$/, '');
					screenName = screenName.replace(/-/g, " ");
					screenName = screenName.replace(/_/g, " ");

					// if the screen for this file already exists in the collection return it
					var screen = window.screenList.find(function(s){
						return s.get('name') == screenName;
					},this);
					// if we have found the screen
					if(screen == undefined){
						// A screen for this file does not already exist
						// so lets create a new screen
						screen = new window.CScreen({
							name:screenName,
							// make the screen append to the end of the collection
							sort:window.screenList.length
						});
						// ...and add it to the collection
						window.screenList.add(screen);
					}
					screen.set({'uploading':true});
					// store the unique cid of the model in the file object for reference later during upload progress
					file.screen_cid = screen.cid;
					// instruct the model that it has not yet got a file uploaded
					screen.loadMode = true;
				},this);

				this.totalPercent = 0;
				this.currentImage = 0;
				this.totalImages = files.length;
				//doPercent();
				up.refresh(); // Reposition Flash/Silverlight
				if(up.files.length > 0) this.uploader.start();
			},
			uploadProgress:function(up, file){
				var screen = window.screenList.getByCid(file.screen_cid);
				screen.imageProgress(file.percent);

				this.currentPercent = file.percent;
				// work out total upload progress
				this.totalPercent = this.uploader.total.percent;
				this.totalProgress();
			},
			// this function handles the plupload uploader events and attaches the plupload upload button to the pickfiles button
			totalProgress:function(){
				//$('#progress .percent').html(totalPercent+'%');
				if(this.currentImage+1 <= this.totalImages)
				$('#progress .current').html(this.currentImage+1);
				$('#progress .total').html(this.totalImages);
				$("#progress .bar").progressbar({value: this.totalPercent});
				$("#progress .percent").html(this.totalPercent + '% complete');
			},
			fileUploaded:function(up,file,info){
				var screen = window.screenList.getByCid(file.screen_cid);
				this.currentImage = this.currentImage + 1;
				this.totalProgress();

				var r = $.parseJSON(info.response);
				if(r.error != undefined){
					alert(r.error.message);
				}
				
				screen.set({uploading:false});
				// populate the model with all the data from the server.
				screen.set(r.result.screen);
				// load the new image in
				screen.view.loadImage();
				
				// check if the uploaded image is currently in the canvas. 
				// if it is then we need to reload the canvas image
				if (window.canvas.get('screen') != null && screen.get('id') == window.canvas.get('screen').get('id')) {
					window.canvasView.render();
				}
			},
			uploadComplete:function(up,file,info){
				$('#progress').fadeOut();
				window.screenList.updateOrder();
			},
			error:function(up, err){
				$('#filelist').append("<div>Error: " + err.code +
					", Message: " + err.message +
					(err.file ? ", File: " + err.file.name : "") +
					"</div>"
				);

				up.refresh(); // Reposition Flash/Silverlight
			}
		});
		
		
		/**
		 * CToolbarView View
		 * ------------
		 * 
		 * View to manage the toolbar
		 */
		window.CToolbarView = Backbone.View.extend({
			el:$('#titleBarRightMenu'),
			template:_.template($('#toolbar-template').html()),
			// store the instanciated uploaderView (CUploaderView)
			uploaderView:null,
			// store the instanciated CTemplateFormView
			templateFormView:null,
			shareFormView:null,
			events:{
				'click .del':'deleteScreenClick',
				'click .template':'templateClick',
				'click .comments':'commentsClick',
				'click .edit':'editClick',
				'click .preview':'previewClick',
				'click .share':'shareClick'
			},
			initialize:function(){
				this.model = window.canvas;
				this.model.bind('change:mode', this.render, this);
				this.model.bind('change:screen', this.render, this);
				this.render();
				this.uploaderView = new CUploaderView();
				this.templateFormView = new CTemplateFormView();
				this.shareFormView = new CShareFormView();
			},
			render:function(){
				this.el.html(this.template(this.model.toJSON()));
//				$('.tipsy').remove();
//				$.fn.nii.tipsy();
			},
			deleteScreenClick:function(e){
				if(!this.$('.del').is('.disabled')){
					if(confirm('Are you sure you want to delete this screen? \n\nThis will delete all hotspots and comments for this screen too.' )){
						window.canvas.get('screen').destroy();
					}
				}
				return false;
			},
			templateClick:function(e){
				if(!this.$('.template').is('.disabled'))
					this.templateFormView.open(e);
				return false;
			},
			commentsClick:function(e){
				if(!this.$('.comments').is('.disabled'))
					window.canvas.set({mode:window.canvas.modes.comment});
				return false;
			},
			editClick:function(){
				if(!this.$('.edit').is('.disabled'))
					window.canvas.set({mode:window.canvas.modes.edit});
				return false;
			},
			previewClick:function(){
				if(!this.$('.preview').is('.disabled'))
					window.router.actionPreview();
				return false;
			},			
			shareClick:function(e){
                if(!this.$('.share').is('.disabled'))
                    this.shareFormView.open(e);
				return false;
			}
		});
		
		/**
		 * CTemplateFormView View
		 * ----------------------
		 * 
		 */
		window.CTemplateFormView = Backbone.View.extend({
			el:$('#template-form'),
			template:_.template($('#template-form-template').html()),
			
			initialize:function(){
				this.collection = window.templateList;
				this.collection.bind('add', this.addOne, this);
				this.collection.bind('add', this.templateItemChanged, this);
				this.collection.bind('remove', this.templateItemChanged, this);
				this.collection.bind('reset', this.render, this);
				window.canvas.bind('change:screen', this.render, this);
				// this.collection.bind('reset', this.addAll, this);
				//this.render();
			},
			events:{
				'click .new-template-save'	: 'newTemplate',
				'click .templateOk'			: 'close',
				'keypress #newTemplate'		: 'inputKeyPress'
			},
			isVisible:function(){
				return $(this.el).is(':visible');
			},
			render:function(){
				$(this.el).html(this.template());
					
				// when first loading in the form lets add all the templates that
				// are currently in the template list
				this.addAll();
				this.drawHint();
				$.fn.nii.form();
			},
			open:function(e){
				this.render();
				$('#mainToolbar .template').addClass('selected');
				if(this.el.is(':visible')){
					this.close();
					e.stopPropagation();
				}
				// this.toggleInfo();
				this.el.show().position({'my':'center top','at':'center bottom','of':$('#mainToolbar .template'),'offset':'0px 12px','collision':'none'});
				$('#newTemplate').focus();
				this.el.click(function(e){
					e.stopPropagation();
				});
				$('body').bind('click.templateForm',_.bind(function(){
					this.close();
				},this));
				this.drawHint();
				e.stopPropagation();
			},
			close:function(){
				//toolbar.$btnTemplate.removeClass('selected');
				$('#mainToolbar .template').removeClass('selected')
				$('body').unbind('click.templateForm');
				this.el.hide();
			},
			newTemplate:function(e){
				var name = $('#newTemplate').val();
				if(name == '')
					return false;
				
				var t = new CTemplate();
				t.save({"name":name},{success:_.bind(function(model, response){
					this.collection.add(model);
				},this)});
				
				
				return false;
			},
			// add one template to the template list
			_addOne:function(template){
				$tItem = new CTemplateItemView({
					model:template
				});
				$('#template-form li.addTemplate').after($tItem.render().el);
				return $tItem;
			},
			// this is the same as addOne but swishes it in
			addOne:function(template){
				$(this._addOne(template).el).hide().show(500);
				$('#newTemplate').val('').focus();
			},
			addAll:function(){
				window.templateList.forEach(this._addOne,this);
			},
			inputKeyPress:function(e){
				if(e.keyCode == 13){
					this.newTemplate();
				}
			},
			// called when a template item is added or removed
			templateItemChanged:function(){
				this.drawHint();
			},
			drawHint:function(){
				if(this.collection.length == 0) {
					this.$('#templateFormHint').fadeIn();
				} else {
					this.$('#templateFormHint').hide();
				}
			}
		
		});


		/**
		 * CTemplateItemView View
		 * ----------------
		 * 
		 * Reresents a single template item in the list on the template form
		 * 
		 */
		window.CTemplateItemView = Backbone.View.extend({
			tagName:'li',
			className:'template line',
			template:_.template($('#template-form-item').html()),
			events:{
				'mouseover'				: 'mouseover',
				'mouseout'				: 'mouseout',
				'click .edit'			: 'edit',
				'click .delete'			: 'destroy',
				'change .checkbox'		: 'checked',
				'click .saveTemplate'	: 'save',
				'keypress input.rename'	: 'renameKeypress'
			},
			initialize:function(){
				this.model.bind('change', this.render, this);
			},
			render:function(){
				$(this.el).html(this.template(this.model.toJSON()));
				return this;
			},
			mouseover:function(){
				$(this.el).addClass('hover');
			},
			mouseout:function(){
				$(this.el).removeClass('hover')
			},
			edit:function(){
				this.$('.editForm').show();
				this.$('input.rename').focus().select();
				this.$('.display').hide();
				
				return false;
			},
			destroy : function(){
				$tpl = $(this.el);
				$('#deleteOverlay').width($tpl.width()-10).height($tpl.height()).fadeTo(0,0.1,function(){
					$(this).position({'my':'left top','at':'left top','of':$tpl,'offset':'0 -1px'}).fadeTo(250,1);
				});
				$('#deleteOverlay .delete').one('click',_.bind(function(){
					// need to remove all hotspots referencing this template
					window.hotspotList.forEach(function(h){
						if(h.get('template_id')==this.model.get('id')){
							h.destroy();
						}
					},this);
					// now destroy the template
					this.model.destroy();
					$('#deleteOverlay').fadeOut();
					$tpl.fadeOut().remove();
				},this));
				return false;
			},
			// apply or un-apply this template to the current screen
			checked : function(){
				if(this.$('.checkbox').is(':checked')){
					window.screenTemplateList.applyTemplate(this.model.get('id'));
				}else{
					// we need to remove the screenTemplate record
					var st = window.screenTemplateList.find(function(st){
						return (st.get('template_id')==this.model.get('id') && st.get('screen_id')==window.canvas.get('screen').get('id'));
					}, this);
					window.screenTemplateList.remove(st);
					st.destroy();
				}
			},
			// save edit
			save : function(){
				this.model.save({name:this.$('input.rename').val()},{error:function(model,error){
					alert(error);
				}});
			},
			renameKeypress:function(e){
				if(e.keyCode == 13)
					this.save();
			}
		});
		
		
		
		
		/**
		 * CScreenView View
		 * ----------------
		 * 
		 * Reresents a CScreenModel object in the sidebar window
		 * 
		 */
		window.CScreenView = Backbone.View.extend({

			//... is a list tag.
			tagName: "div",
			
			className: "sidebarImg txtC",

			// Cache the template function for a single item.
			template: _.template($('#screen-template').html()),

			// The DOM events specific to an item.
			events: {
				"click" : "screenClick"
			},
			// The ScreenListView listens for changes to its model, re-rendering. Since there's
			// a one-to-one correspondence between a **Screen** and a **ScreenView** in this
			// app, we set a direct reference on the model for convenience.
			initialize: function() {
				this.model.bind('change:image_url', this.renderAndLoad, this);
				this.model.bind('change:uploading', this.uploading, this);
				window.canvas.bind('change:screen', this.setSelected, this);
				// store a pointer to the view in the model
				this.model.view = this;
			},
			renderAndLoad:function(){
				this.render();
				this.loadImage();
			},
			// Re-render the contents of the screen.
			render: function() {
				$(this.el).html(this.template(this.model.toJSON()));
				//this.loadImage();
				return this;
			},
			setSelected: function(){
				if(window.canvas.get('screen') == null)
					return;
				if(this.model.get('id') == window.canvas.get('screen').get('id')){
					$(this.el).addClass('selected');
				}else{
					$(this.el).removeClass('selected');
				}
			},
			// the img element to load in
			img:null,
			// lazy load the side image
			loadImage:function(){
				// don't load in the image if we are currently being uploaded
				if(this.model.get('uploading')==true)
					return;
				if(this.$('.screen .sideImg img').length != 1) {
					// if the progress bar is visible fade it out
					this.$('.sideImg').addClass('loading loading-spin');
					this.img = $('<img>').hide();
					if(this.img.get(0).complete){
						
					}
					this.img.bind("load",_.bind(function(){
						var sideImg = this.$('.sideImg');
						this.img.width(sideImg.width()).appendTo(this.$('.sideImg'));
						
						// animate the height of the div to match the height of the thumbnail image
						var h = this.img.height()+'px';
						var img = this.img;
						
						
						//sideImg.animate({height:h},0,'swing',function(){
							sideImg.css('height','');
							img.show();
							//img.fadeIn(100);
							sideImg.removeClass('loading loading-spin loading-fb');
							
							// because this changes the height of the images the scroll window may have shrunk moving 
							// additional images in that need to be loaded
							window.screenListView.scroll();
							//resizer();
						//});
					},this));
					this.img.attr('src', this.model.get('image_url_thumb'));
				}
			},
			isScrolledIntoView:function() {
				var listWinHeight = $(window).height() - $("#screen-list").offset().top;
				return ($(this.el).offset().top < listWinHeight);
			},
			// load this clicked screen into the canvas
			screenClick:function(e) {
				if (this.model.get('uploading') != true)
					window.router.actionScreen(this.model.get('id'));
				return false;
			},
			uploadProgress:function(progress) {
				$(this.el).find('.progress').fadeIn();
				$(this.el).find('.progress').progressbar({value:progress});
			},
			// this function prepares the view for uploading when thescreen model is put into an uploading state
			uploading:function(){
			//	this.$('.sideImg').height(this.$('.sideImg').height())
				this.$('.sideImg img').remove();
				this.$('.sideImg').addClass('loading loading-fb');
			}
		});
		

		/**
		 * CScreenListView View
		 * --------------------
		 * 
		 * You must provide a CScreenList collection object on instantiation
		 * collection: CScreenList
		 * 
		 */
		window.CScreenListView = Backbone.View.extend({
			el:$('#screen-list'),
			screenViews: {}, // view cache for further reuse
			template:_.template($('#screen-pane-template').html()),
			views:[],
			events:{
				'click .sidebarClose' : 'close',
				'click .sidebarOpen'  : 'open'
			},
			initialize: function()
			{
				this.collection.bind('add',   this.addOne, this);
				this.collection.bind('remove',   this.remove, this);
				this.collection.bind('reset', this.addAll, this);
				this.render();
				
				// attach the jquery ui resizable
				$('#screen-list').resizable({
					handles:'e',
					minWidth:100,
					maxWidth:400,
					alsoResize:'#screen-pane',
					resize:function(){
						window.canvasView.resizer();
					},
					stop:_.bind(function(){
						this.prevWidth = null;
						this.open();
					},this)
				});
				
				// add all screens currently in the collection
				this.addAll();
			},
			render: function()
			{
				this.el.html(this.template)
				$('#screen-pane').scroll(_.bind(function(){this.scroll();},this));
				$('#screen-pane').sortable({
					update:function(event, ui){
						window.screenList.updateOrder();
					}
				});
				return this;
			},
			scroll:function(){
				_.each(this.views,function(view){
					if(view.isScrolledIntoView()){
						view.loadImage();
					}
				});
			},
			addOne : function(screen) {
				var view = new CScreenView({model: screen});
				$('#screen-pane').append(view.render().el);
				if(view.isScrolledIntoView())
					view.loadImage();
				this.views[screen.get('id')] = view;
			},
			// Add all items in the **ScreenList** collection at once.
			addAll : function() {
				window.screenList.forEach(this.addOne, this);
			},
			remove : function(screen){			
				$(screen.view.el).fadeTo(300, 0).slideUp(300, function(){
					screen.view.remove();
					window.screenListView.scroll();
					window.canvasView.resizer();
				})
			},
			prevWidth:null,
			close:function(){
				this.prevWidth = this.el.width();
				$('#screen-pane').width(1);
				this.el.width(1);
				this.$('.sidebarClose').hide();
				this.$('.sidebarOpen').show();
				window.canvasView.resizer();
			},
			open:function(){
				if(this.prevWidth != null){
					$('#screen-pane').width(this.prevWidth);
					this.el.width(this.prevWidth);
				}
				this.$('.sidebarClose').show();
				this.$('.sidebarOpen').hide();
				window.canvasView.resizer();
			}
		});
		
		
		/**
		 * CCanvasView View
		 * ----------------
		 * 
		 * The canvas view has hotspots and the hotspot forms and well as the screen html
		 * 
		 */
		window.CCanvasView = Backbone.View.extend({
			// Instead of generating a new element, bind to the existing skeleton of
			// the App already present in the HTML.
			el: $("#canvas-wrap"),
			template:_.template($('#canvas-template').html()),
			// Delegated events for creating new items, and clearing completed ones.
			initialize: function() {
				// bind the canvas view to the canvas model
				// when a scren is changed the canvas will update
				this.el.html(this.template(this.model.toJSON()));
				
				this.model.bind('change:screen', this.render, this);
				this.model.bind('change:mode', this.render, this);
				
				$(window).resize(function(){
					window.canvasView.resizer();
				});
			},
			render: function() {
				
				// set up the node / element
				$imgs = this.$('#canvasImage')
				// loading in the image
				_im = $('<img id="canvasImage">').hide().bind("load",_.bind(function(e){
					$imgs.remove(); 
					this.position();
					window.hotspotListView.render();
					$(e.target).show();
				},this));			
				
				// append img to target node / element
				$('#canvas').append(_im);
				
				// set the img src attribute now, after insertion to the DOM
				if (this.model.get('screen') != null) {
					_im.attr('src',this.model.get('screen').get('image_url'));
				}
				
				// remove the hotspot "boxer" drawing plugin
				$('#canvas').boxer('destroy');
				
				// work out which mode to render.
				switch (this.model.get('mode')) {
					// comment mode
					case this.model.modes.comment:
						this.renderCommentMode();
					break;
					// preview mode
					case this.model.modes.preview:
						this.renderPreviewMode();
					break;
					// edit mode
					default:
						this.renderEditMode();
					break;
				}
				
				// prevent being able to drag the canvas image
				if (this.model.get('mode') != this.model.modes.edit) {
					$('#canvas').mousedown(function(e){
						e.preventDefault();
					});
				}
				
				// if the screen is empty lets display  no screen
				if (this.model.get('screen') == null)
					$('#canvasImage').fadeOut(function(){$(this).remove();});
				
				this.cursor();
				this.background();
			},
			renderCommentMode:function(){
				$('#canvas-hotspots').hide();
			},
			renderPreviewMode:function(){
				if(this.model.previousAttributes().mode != this.model.modes.preview){
					$('#hotspot').delay(100).fadeOut(300,_.bind(function(){
						$('#mainToolbar').hide();
						$('#screen-list').hide();
						this.resizer();
						$('#hotspot').delay(200).fadeIn(300);
						this.background();
						setTimeout(function(){
							// flash up the escape message
							$('#flash-escape-message').fadeTo(0,0.1)
								.css('borderRadius','15px')
								.position({my:'center', at:'center', of:$(window)})
								.fadeTo(300,1).delay(2000).fadeOut()
						},700)
					},this));
				}
			},
			escapePreviewMode:function(){
				// go back to the previous mode!
				window.canvas.set({mode:this.model.modes.edit});
				$('#canvas-hotspots').hide();
				$('#hotspot').fadeOut(300,_.bind(function(){
					//$('html').css('background','');
					$('#mainToolbar').show();
					$('#screen-list').show();
					$('#canvas-wrap').show();
					this.resizer();
					$('#canvas-hotspots').show();
					$('#hotspot').fadeIn(300,function(){
						window.canvasView.resizer();
					});
					this.resizer();
				},this));
			},
			renderEditMode:function(){
				if(window.canvas.previousAttributes().mode == window.canvas.modes.preview){
					this.escapePreviewMode();
				}
				if(!$('#canvas-hotspots').is(':visible')){
					$('#canvas-hotspots').show();
				}
				var $canvas = $('#canvas');
				$canvas.boxer({
					appendTo:$('#canvas-hotspots'),
					stop:_.bind(function(event, ui) {
						// if a box is too small its likely to be a mouse user mistake
						if(ui.box.width()<5 && ui.box.height()<5){
							ui.box.remove()
							return
						}
						ui.box.addClass('hotspot');
						var hs = new CHotspot({
							left:ui.box.position().left,
							top:ui.box.position().top,
							width:ui.box.width(),
							height:ui.box.height(),
							screen_id:this.model.get('screen').get('id')
						});
						window.hotspotList.add(hs);
						ui.box.remove();
						hs.save();
						// show the hotspot form
						window.canvas.set({hotspot:hs});
					},this)
				})
				// attaches a droppable event to the canvas for acepting sidebar images being dropped.
				$canvas.droppable({
					accept:'.sidebarImg',
					drop: function(event, ui) {
						var hs = new CHotspot({
							left:event.clientX-$('#canvas').offset().left-75,
							top:event.clientY-$('#canvas').offset().top-15,
							width:150, height:30,
							screen_id_link:$(ui.draggable).find('[data-id]').attr('data-id'),
							screen_id:window.canvas.get('screen').get('id')
						});
						window.hotspotList.add(hs);
						hs.save();
						hs.view.el.click();
					}
				});
			},
			// draw the canvas page background (configurable in the config form (soon))
			background:function(){
				// this can be called when a screen has been deleted so it should return the background to linen
				if(window.canvas.get('screen') != null){
					var rgb = window.canvas.get('screen').get('background').split(',');
					if(rgb[0] != undefined && rgb[1] != undefined && rgb[2] != undefined){
						$('#canvas-wrap').css('background','rgb('+rgb[0]+', '+rgb[1]+', '+rgb[2]+' )');
					}else{
						$('#canvas-wrap').css('background','');
					}
				} else {
					$('#canvas-wrap').css('background','');
				}
				
				
			},
			// positions the image within the canvas
			// acording to the canvas model position property (left, center, right)
			// this is to be later added as a configuration option but for now it defaults to center
			position:function(){
				var screen = this.model.get('screen');
				switch(screen.get('position')){
					case screen.positions.center:
						var width = screen.get('width');
						// if a width isn't set (which it should be when the image is uploaded) then just set it to 980
						if(width==null){
							width = 980;
							// we don't want the screen to redraw
							screen.set({"width":width},{silent:true});
						}
						$('#canvas').css('margin', '0px auto').width(width);
					break;
				}
			},
			cursor:function(){
				$c = $('#canvas');
				switch(this.model.get('mode')){
					case this.model.modes.edit:
						$c.css('cursor','crosshair');
					break;
					case this.model.modes.comment:
						$c.css('cursor','help');
					break;
					case this.model.modes.preview:
						$c.css('cursor','default');
					break;
				}
			},
			// resizes the windows to maintain scroll positions and sidebar etc
			resizer:function(){
				if(this.model.get('mode')==this.model.modes.preview){
					$('#canvas-wrap').css('left','');
					$('#canvas-wrap').css('top','0px');
					$('#canvas-wrap').snappy({'snap':$(window)});
					$('#canvas-wrap').css('width',$(window).width());
				}else{
					$('#canvas-wrap').css('top','47px');
					$('#canvas-wrap').snappy({'snap':$(window)});
					$('#screen-list').snappy({'snap':$(window)});
					$('#screen-pane').snappy({'snap':'#screen-list'});
					$('#canvas-wrap').css('width',($('body').width()-$('#screen-list').width()+$('#screen-list').border().right-2) + 'px');
					$('#canvas-wrap').css('left',$('#screen-list').width()+$('#screen-list').border().right);
					$('.sideImg').width($('#screen-pane .screen').width())
					
					$('#screen-pane img').width($('#screen-pane .sideImg').width());
					$('#screen-pane .sideImg').width($('#screen-pane .sideImg img').width())
					// reposition the plupload uploader
					$('body div.plupload').position({my:'center',at:'center',of:$('#pickfiles')});
								
					window.canvasStart.position();
				}
			}
		});
		
		
				
		
		/**
		 * CHotspotView View
		 * -----------------
		 * 
		 * View to represent one hotspot
		 * 
		 */
		window.CHotspotView = Backbone.View.extend({
			//template:_.template($('#hotspot-template').html()),
			tagName:'a',
			className:'hotspot',
			initialize:function(){
				this.model.bind('change', this.render, this);
				
				//window.canvas.bind('change:mode', this.render, this);
				
				// link the hotspot model to its view
				// this is useful for the displaying the hotspot form
				this.model.view = this;
				this.el = $(this.el).html('<br/>');
				this.draggable();
				this.resizable();
				this.el.click(_.bind(this.click, this));
			},
			click:function(e){
				if (e.shiftKey || window.canvas.get('mode') == window.canvas.modes.preview) {
					// if the shift key is held down lets navigate to that screen
					this.model.followLink();
				}else{
					// set the canvas currently active hotspot
					window.canvas.set({hotspot:this.model});
					
					// if the hotspot has been dragged whilst the hotspotForm is not visible, the above function (setting
					// the active hotspot model on the canvas) will not trigger the form to display. 
					// As the hotspot has been dragged the canvas's active hotspot model is
					// already set to this hotspot and so backbone does not trigger the hotspot change event.
					// we have to check manually
					if(!window.hotspotFormView.isVisible())
						window.hotspotFormView.render();
				}
			},
			render:function(){
				// draw the hotspot, set the style and attributes
				$(this.el).css({
					'left':this.model.get('left')+'px',
					'top':this.model.get('top')+'px',
					'width':this.model.get('width')+'px',
					'height':this.model.get('height')+'px',
					'position':'absolute'
				});
				if(this.model.get('screen_id_link') != 0){
					this.el.attr('data-screen',this.model.get('screen_id_link'));
				}
				if(this.model.get('template_id') != 0){
					this.el.attr('data-template',this.model.get('template_id'));
				}else{
					this.el.removeAttr('data-template');
				}
				this.mode();
				return this;
			},
			mode:function(){
				if (window.canvas.get('mode') == window.canvas.modes.preview){
					$(this.el).addClass('link').resizable('destroy');
				}
				else if (window.canvas.get('mode') == window.canvas.modes.edit){
					$(this.el).removeClass('link');
				}
			},
			resizable:function(){
				this.el.resizable({
					handles:'all',
					resize:function(){
						window.hotspotFormView.position();
					},
					stop:_.bind(function(){
						this.updateModel();
					},this)
				})
			},
			draggable:function(){
				this.el.draggable({
					cancel:'.link',
					drag:_.bind(function(event, ui){
						// TODO: should raise another event here really that the form view can bind to
						window.hotspotFormView.position();
						if (event.shiftKey) {
							this.el.draggable('option','grid',[15,15]);
						}else{
							this.el.draggable('option','grid',false);
						}
					},this),
					start:_.bind(function(event, ui){
						
						// very cool if dragging with alt key pressed will copy the current spot.
						if(event.altKey){
							// you wana copy spot? okie dokie then..
							// we are still going to drag the original and we put the copy in its place
							newHs = this.model.clone();
							// set the id to null so backbone understands this is a new model
							newHs.set({id:null});
							this.collection.add(newHs);
							newHs.save();
						};
						// if the shift key is held down 
						if (event.shiftKey) {
							this.el.draggable('option','grid',[15,15]);
						}else{
							this.el.draggable('option','grid',false);
						}
						//ui.helper.bind("click.prevent",function(event) { event.preventDefault(); });
						window.hotspotFormView.hotspotStartDrag(this.model);
					},this),
					stop:_.bind(function(e){
						//setTimeout(function(){ui.item.unbind("click.prevent");}, 300);
						// TODO: should raise another event here really that the form view can bind to
						window.hotspotFormView.hotspotStopDrag(this.model);
						this.updateModel();
					},this)
				});
			},
			updateModel:function(){
				var pos = this.el.position();
				this.model.set({
					left:pos.left,
					top:pos.top,
					height:this.el.height(),
					width:this.el.width()
				});
				this.model.save();
			}
		});
		
		
		/**
		 * CHotspotListView View
		 * ---------------------
		 * 
		 * View to represent our list of hotspots. This view is the parent of CHotspotView
		 * and is responsible for drawing the individual hotspots
		 * it also filters the CHotspotList (window.hotspotList) to produce an array of hotspots specific to the
		 * active screen, defined in the CCanvas Model (window.canvas)
		 * 
		 * @param collection CHotspotList
		 * 
		 */
		window.CHotspotListView = Backbone.View.extend({
			// Instead of generating a new element, bind to the existing skeleton of
			// the App already present in the HTML.
			el: $("#canvas-hotspots"),
			// store a list of the filtered hotspots for this screen only
			filteredHotspots:[],
			// store an array of all active hotspot views
			activeHotspots:[],
			hotspotViewPointers:[],
			initialize: function() {
				// bind the canvas view to the canvas model
				// when a screen is changed the canvas will update
				// this.collection.bind('change', this.render, this);
				// lets bind the refresh to the screen change
				this.collection.bind('add',this.addHotspot, this);
				this.collection.bind('change', this.updateCount, this);
				this.collection.bind('remove', this.updateCount, this);
				this.collection.bind('remove', this.removeHotspot, this);
				this.collection.bind('reset', this.render, this);
				window.screenTemplateList.bind('remove', this.renderTemplateSpots, this);
				window.screenTemplateList.bind('add', this.renderTemplateSpots, this);
				//this.render(this);
			},
			// renders all hotspots
			render: function() {
				this.renderHotspots();
				
				// lets do template hotspot here too.
				this.renderTemplateSpots();

				this.updateCount();
			},
			addHotspot:function(hotspot){
				var view = new CHotspotView({model: hotspot, collection: this.collection});
				this.activeHotspots.push(view);
				this.hotspotViewPointers[hotspot.cid] = view;
				$("#canvas-hotspots").append(view.render().el);
			},
			updateCount:function(){
				$('.hotspot-number').html(window.hotspotList.hotspotScreenCount());
			},
			// remove all standard hotspots, does not remove template hotspots
			removeHotspots:function(){
				_.each(window.hotspotListView.activeHotspots, function(view){
					if(!view.model.isTemplate())
						view.remove();
				});
			},
			// remove only template hotspots
			removeTemplateHotspots:function(){
				_.each(this.activeHotspots, function(view){
					if(view.model.isTemplate())
						view.remove();
				})
			},
			renderHotspots:function(){
				// filter the results to only include hotspots for this screen
				// this.collection holds an array of all project hotspots
				this.removeHotspots();
				this.filteredHotspots = this.collection.getScreenHotspots();
				this.filteredHotspots.forEach(this.addHotspot,this);
			},
			renderTemplateSpots:function(){
				this.removeTemplateHotspots();
				var tSpots = window.screenTemplateList.getScreenTemplateHotspots();
				_.each(tSpots, this.addHotspot, this);
			},
			removeHotspot:function(hotspot){
				this.hotspotViewPointers[hotspot.cid].remove();
			}
		});
		
		/**
		 * CHotspotFormView View
		 * ---------------------
		 * 
		 * Hotspot Form View
		 * 
		 */
		window.CHotspotFormView = Backbone.View.extend({
			className:'spotForm',
			id:'hotspot-form',
			// stores whether the form is in visible or hidden mode
			// it is possible for the form element to be hidden(for example in preview mode) but the state of the form is
			// visible, so when returning from review mode it should be shown again.
			hidden:true,
			template:_.template($('#hotspot-form-template').html()),
			templateSelectItem:_.template($('#hotspot-form-select-item-template').html()),
			// this hold a reference to the hotspot view object
			events:{
				'click #okSpot'	: 'close',
				'click #screenList input, #screenList a' : 'autocompleteDropDown',
				'click #fixedScroll' : 'fixedScrollChecked',
				'click #deleteSpot' : 'destroy',
				'click .follow-link' : 'follow',
				'click #add-new-template' : 'addNewTemplate',
				'change #hotspotTemplate' : 'templateSelect',
				'keyup #screenListInput' : 'keyupStopPropagation',
				'keyup #hotspotTemplate' : 'keyupStopPropagation'
			},
			keyupStopPropagation:function(e){
				e.stopPropagation();
			},
			initialize:function(){
				// the spot form listens to the active canvas hotspot model
				window.canvas.bind('change:hotspot', this.onHotspotChange, this);
				window.canvas.bind('change:screen', this.close, this);
				window.canvas.bind('change:mode', this.mode, this);
				
				window.templateList.bind('add', this.renderTemplate, this);
				window.templateList.bind('remove', this.renderTemplate, this);
				// re-position the hotspot form when the window is resizing
				$(window).resize(_.bind(function(){if(this.isVisible()){this.position();}},this));
				
			},
			// function called each time a hotspot is attached to the form
			// this view is a singleton so the above initialize function is only called once
			init:function(){
				this.model = window.canvas.get('hotspot');
				this.model.unbind("change", this.renderTemplate);
				this.model.bind("change", this.renderTemplate, this);
			},
			
			onHotspotChange:function(){
				this.init();
				this.render();
			},
			// function called when the canvas mode is changed
			mode: function(){
				// want to hide the form in preview and comment mode
				if(window.canvas.get('mode') != window.canvas.modes.edit){
					$(this.el).hide();
				} else {
					if(!this.hidden){
						$(this.el).show();
					}
				}
			},
			
			// Updates the template but does not force visibility.
			renderTemplate:function(){
				if (this.model == null)
					return
				$(this.el).html(this.template(this.model.toJSON()));
				$(this.el).insertAfter($('#canvas'))
				this.autocomplete();
				this.updateTemplatesSelect();
				this.position();
			},
			
			// Renders the form and makes it visible
			render:function(){
				// if the view does not have a hotspot asssociated model lets close the form and hide it
				if(this.model == null){
					this.close();
					return;
				}
				this.renderTemplate();
				$(this.el).show();
				this.hidden = false;
				this.position();
			},
			updateTemplatesSelect:function(){
				var $select = $('#hotspotTemplate').html('');
				$select.append('<option value="0">- select template -</option>');
				window.templateList.forEach(function(t){
					$select.append('<option value="'+t.get('id')+'">'+t.get('name')+'</option>');
				},this)
				if(this.model.get('template_id')!=0)
					$select.val(this.model.get('template_id'));
			},
			// attach the autocomplete widget to the input box
			autocomplete:function(){
				$('#screenList a').attr("tabIndex", -1).attr("title", "Show All Items")
				// load the initial state of the drop down
				var selectedModel = window.screenList.get(this.model.get('screen_id_link'));
				if(selectedModel != undefined) {
					// spot is already linked to a screen
					$("#screenList input").val(selectedModel.get('name'));
				} else {
					$("#screenList input").val('');
				}
				$("#screenListInput").autocomplete('destroy');
				$("#screenListInput").autocomplete({
					minLength: 0,
					appendTo:$('#canvas-wrap'),
					source: function(request, response) {
						response(window.screenList.filterByScreenName(request.term));
					},
					focus: function(event, ui) {
						$("#screenList input").val(ui.item.get('name'));
						return false;
					},
					select:_.bind(function(event, ui) {
						this.model.set({'screen_id_link':ui.item.get('id')});
						this.model.save();
						return false;
					},this),
					position:{'my':'left top','at':'left bottom','of':'#screenList','collision':'flip'}
				})
				.data("autocomplete")._renderItem = _.bind(function(ul, item) {
					return $(this.templateSelectItem({screen:item}))
						.data("item.autocomplete", item)
						.appendTo(ul);
				},this);
			},
			// function called when the drop down button of the combo box is clicked
			autocompleteDropDown:function(){
				// close if already visible
				if ($("#screenList input").autocomplete("widget").is(":visible")) {
					$("#screenList input").autocomplete("close");
					return false;
				}
				// work around a bug (likely same cause as #5265)
				$(this).blur();
				// pass empty string as value to search for, displaying all results
				$("#screenList input").autocomplete("search", "");
				$("#screenList input").focus();
				return false;
			},
			fixedScrollChecked:function(){
				this.model.set({fixed_scroll:($('#fixedScroll').is(':checked'))?1:0});
				this.model.save();
			},
			close:function(){
				// disasociate the active model
				window.canvas.set({'hotspot':null},{silent:true});
				this._hide();
			},
			_hide:function(){
				$("#screenListInput").autocomplete('close');
				this.hidden = true;
				$(this.el).hide();
			},
			position:function(){
				$("#screenList input").autocomplete("close");
				if($(this.el).is(':visible'))
					$(this.el).position({my:'left top',at:'right top',of:this.model.view.el,offset:"18 -10", collision:'none'});
			},
			isVisible:function(){
				return $(this.el).is(':visible');
			},
			// when clicking to follow the hotspot link
			follow:function(){
				this.model.followLink()
				return false;
			},
			hotspotStartDrag:function(hotspot){
				// if a hotspot form is visible then make it appear on the new hotspot being dragged
				if(this.isVisible()){
					window.canvas.set({hotspot:hotspot});		
				}
				// if it is not visible, update the form but do not show the form
				else {
					window.canvas.set({hotspot:hotspot},{silent:true});
					this.init();
				}
			},
			hotspotStopDrag:function(hotspot){
				this.model = hotspot;
				this.init();
				this.position();
			},
			destroy:function(){
				this.model.destroy();
				this.close();
			},
			// function to make a hotspot a template hotspot based on the selected template value
			templateSelect:function(){
				// save this hotspot as a template
				tId = $('#hotspotTemplate').val();
				// ensure this template is aslo applied to the screen to avoid the 
				// hotspot from disapearing. 
				// If you select a hotspot to belong to a template that is not currently activated for the current screen
				// then it disapears (as it should do) but this is confusing for the user. So we automatically apply the template too.
				window.screenTemplateList.applyTemplate(tId);
				this.model.save({'template_id':tId});
			},
			addNewTemplate:function(e){
				window.toolbarView.templateFormView.open(e);
				return false;
			}
		});
		
		
		window.CCanvasStartView = Backbone.View.extend({
			id:'canvas-start',
			template:_.template($('#canvas-start-template').html()),
			initialize: function(){
				window.screenList.bind('add',	 this.noScreensCheck, this);
				window.screenList.bind('remove', this.noScreensCheck, this);
				window.screenList.bind('reset',	 this.noScreensCheck, this);
				this.render();
			},
			render: function(){
				$(this.el).html(this.template());
				$('body').append($(this.el));
				$(this.el).dialog({
					autoOpen:false,
					width:800,
					height:300,
					resizable:false,
					draggable:false,
					zIndex:10000
				});
				$(this.el).parent().find('.ui-dialog-titlebar').remove();
				//window.canvasView.el.prepend(this.el);
				this.noScreensCheck();
			},
			// check if there are no screens.  
			// If there are no screens then display the no screens message/view
			noScreensCheck:function(){
				if (window.screenList.length != 0){
					// hide myself if i am visible
					//$(this.el).hide();
					$('#canvas-start').dialog('close');
				} else {
					// we have zero screens lets display
					$('#canvas-start').dialog('open');
					this.position();
				}
			},
			position:function(){
				if($('#canvas-start').dialog('widget').is(':visible'))
					$('#canvas-start').dialog('widget').position({'my':'center top','at':'center top','of':'#canvas-wrap', 'offset':'0 100', collision:'none'});
			}
		});
		
		//
		// set up the models
		// ----------------
		//
		window.screenList = new CScreenList;
		window.hotspotList = new CHotspotList;
		window.canvas = new CCanvas;
		window.templateList = new CTemplateList;
		window.screenTemplateList = new CScreenTemplateList;
		
		// populate model collections with initial data
		window.hotspotList.reset(<?php echo $hotspotsJson; ?>);
		window.screenList.reset(<?php echo $screensJson; ?>);
		window.templateList.reset(<?php echo $templatesJson; ?>);
		// this collection holds a list of template id's that are applied to each screen
		window.screenTemplateList.reset(<?php echo $screenTemplatesJson; ?>);
		
		//
		// set up the views
		// ----------------
		//
		
		// load the canvas view and screen
		window.canvasView = new CCanvasView({
			model:window.canvas
		});
		
		// draw the list of screens
		window.screenListView = new CScreenListView({
			collection:window.screenList
		});
		
		window.hotspotFormView = new CHotspotFormView;
		
		window.hotspotListView = new CHotspotListView({
			collection:window.hotspotList
		});
		
		window.toolbarView = new CToolbarView();
		
		window.canvasStart = new CCanvasStartView();
		
		// the state is pushed here which triggers the event to fire to match the url
		// thus starting the ball rolling by navigating to the url see CRouter.actionScreen
		Backbone.history.start({pushState: true, root: "<?php echo NHtml::url(array('project/screen/screen','project'=>$project->id)); ?>/"})
		

		// resize the window components
		window.canvasView.resizer();
		
		window.key = {left: 37, up: 38, right: 39, down: 40, del: 46, escape: 27, shift: 16};
		
		$(window).keyup(function(e){
			// detect and handle key press
			var keyCode = e.keyCode;
			
			
			// do we have an active hotspot?
			if (window.canvas.get('hotspot') != null && window.hotspotFormView.isVisible()){
				var hs = window.canvas.get('hotspot');
				var shiftAmount = 1;
				if(e.shiftKey)
					shiftAmount = 10;
				switch (keyCode) {
					case key.up:
						// i dont want the view to rerender after save as if you go mental on the arrow keys
						// the update becomes jerky
						hs.save({top:parseInt(hs.get('top'))-shiftAmount},{silent:true});
						hs.view.render();
						window.hotspotFormView.position();
						e.preventDefault();
						return false;
					break;
					
					case key.down:
						hs.save({top:parseInt(hs.get('top'))+shiftAmount},{silent:true});
						hs.view.render();
						window.hotspotFormView.position();
						e.preventDefault();
						return false;
					break;
					
					case key.left:
						hs.save({left:parseInt(hs.get('left'))-shiftAmount},{silent:true});
						hs.view.render();
						window.hotspotFormView.position();
						e.preventDefault();
						return false;
					break;
					
					case key.right:
						hs.save({left:parseInt(hs.get('left'))+shiftAmount},{silent:true});
						hs.view.render();
						window.hotspotFormView.position();
						e.preventDefault();
						return false;
					break;
						
					// delete key on the hotspot... deletes it
					case key.del:
						window.hotspotFormView.destroy();
					break;
				}
			}
			
			// Preview mode key events!
			if (window.canvas.get('mode') == window.canvas.modes.preview){
				switch (keyCode) {
					// hit escape in preview mode returns you to previous (edit / comment) mode
					case key.escape:
						window.router.actionScreen(window.canvas.get('screen').get('id'), true, true);
					break;
				}
				
				if(keyCode == key.shift){
					$('#canvas-hotspots').removeClass('viewspots');
				}
			}
			
		});
		
		$(window).keydown(function(e){
			if(e.shiftKey){
				if (window.canvas.get('mode') == window.canvas.modes.preview){
					// show hotspots
					$('#canvas-hotspots').addClass('viewspots');
				}
			}
		});
		
		
		/**
		 * TODO: add to canvas view?
		 *
		 * Display drag/drop message on file drag over the window
		 * -------------
		 */
        if(window.toolbarView.uploaderView.browserSupportsDragDrop()){
            var timer = {};
            window.addEventListener("dragenter", function(e){
                //$('#dropzone').show();
                clearTimeout(timer);
                $('#dropzone').addClass('dragging');
                $('#drop').show().addClass('dragging').width($(window).width()-40).height($(window).height()-40)
                    .position({'my':'center','at':'center','of':$(window)})
            }, false);

            window.addEventListener('dragover', function(e){
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
        }
		

	});
	



/**
 * snappy plugin
 */
(function($){

	function _padHeight($el){
		padding = $el.padding();
		return padding.top + padding.bottom;
	}
	function _padWidth($el){
		padding = $el.padding();
		return padding.left + padding.right;
	}
	var methods = {
		init : function( options ) {
			return this.each(function(){
				$this = $(this);
				//options
				var minHeight = 200;
				$snapTo = $(options.snap);
				
				var winHeight = $snapTo.height();
				
				if(!((winHeight-$this.position().top) <= minHeight)){
					$this.css('height',(winHeight - $this.position().top - _padHeight($this)) + 'px');
				}
			});
		}
	};
	$.fn.snappy = function( method ) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
		}    
	};
})(jQuery);

/**
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



//
// Boxer plugin
// ----------------
// to draw hotspots
$.widget("ui.boxer", $.ui.mouse, {
	_init: function() {
		this.element.addClass("ui-boxer");
		this.dragged = false;
		this._mouseInit();
		this.helper = $(document.createElement('a')).addClass('hotspot helper ui-boxer-helper')
		this.appendTo = (this.options.appendTo==undefined)?this.element:this.options.appendTo;
	},
	destroy: function() {
		this.element
		.removeClass("ui-boxer ui-boxer-disabled")
		.removeData("boxer")
		.unbind(".boxer");
		this._mouseDestroy();
		return this;
	},
	_mouseStart: function(event) {
		this.opos = [event.pageX, event.pageY];
		if (this.options.disabled)
			return;
		this._trigger("start", event);
		this.appendTo.append(this.helper);
		this.helper.css({
			"z-index": 100,
			"position": "absolute",
			"left": event.clientX,
			"top": event.clientY,
			"width": 0,
			"height": 0
		});
	},
	_mouseDrag: function(event) {
		//var self = this;
		this.dragged = true;
		if (this.options.disabled)
			return;
		var x1 = this.opos[0], y1 = this.opos[1], x2 = event.pageX, y2 = event.pageY;
		if (x1 > x2) { var tmp = x2; x2 = x1; x1 = tmp; }
		if (y1 > y2) { var tmp = y2; y2 = y1; y1 = tmp; }
		this.helper.css({left: x1-this.element.offset().left, top: y1-this.element.offset().top, width: x2-x1, height: y2-y1});
		this._trigger("drag", event);
		return false;
	},
	_mouseStop: function(event) {
		//var self = this;
		this.dragged = false;
		var clone = this.helper.clone()
		.removeClass('ui-boxer-helper').appendTo(this.appendTo);
		this._trigger("stop", event, { box: clone });
		this.helper.remove();
		return false;
	}
});
	
	
	
</script>

<?php $this->renderPartial('/index/account'); ?>