<?php
/**
 * UserSelect class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */


/**
 * create a nice user select input
 *
 * @author steve
 */
class UserSelect extends CInputWidget
{
	public function run()
	{
		list($name, $id) = $this->resolveNameID();
		
//		
		$users = User::model()->findAll();
		$data = CHtml::listData($users, 'id', 'name');
		echo CHtml::activeDropDownList($this->model, $this->attribute, array_merge(array(''=>'select a user'),$data));
		
		// for now shows a simple drop down.
		// future should be a combo box that also shows users gravatar
//		$data = $this->listData();
//		echo CHtml::textField($name.'_select');
//		echo CHtml::hiddenField($name);
//		$js = '$("#'.$id.'_select")
//					.autocomplete({
//							delay: 0,
//							minLength: 0,
//							source: function( request, response ) {
//								var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
//								response( $.each('.json_encode($data).', function(i,d) {
//									console.log(d);
//									var text = d.name;
//									if ( this.id && ( !request.term || matcher.test(text) ) ){
//										return {
//											name: text.replace(
//												new RegExp(
//													"(?![^&;]+;)(?!<[^<>]*)(" +
//													$.ui.autocomplete.escapeRegex(request.term) +
//													")(?![^<>]*>)(?![^&;]+;)", "gi"
//												), "<strong>$1</strong>" ),
//											id: d.id,
//											image:d.image
//										};
//									}
//								}));
//							},
//							select: function( event, ui ) {
//								// ui.item.option.selected = true;
//								//self._trigger( "selected", event, {
//								//	item: ui.item.option
//								//});
//							},
//							change: function( event, ui ) {
////								
//							}
//						})
//						.data("autocomplete")._renderItem = function(ul, item) {
//							return $("<li></li>")
//								.data("item.autocomplete", item)
//								.append(\'<a><div class="media man"><div class="img txtC"><img src="\'+item.image+\'" style="display: inline;"></div><div class="bd pls">\'+item.name+\'</div></div></a>\')
//								.appendTo(ul);
//						};
//
//					//this.button = $( \'<button type="button">&nbsp;</button>\' )
//					//	.attr( "tabIndex", -1 )
//					//	.attr( "title", "Show All Items" )
//					//	.insertAfter( input )
//					//	.button({
//					//		icons: {
//					//			primary: "ui-icon-triangle-1-s"
//					//		},
//					//		text: false
//					//	})
//					//	.removeClass( "ui-corner-all" )
//					//	.addClass( "ui-corner-right ui-button-icon" )
//					//	.click(function() {
//					//		// close if already visible
//					//		if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
//					//			input.autocomplete( "close" );
//					//			return;
//					//		}
////
////							// work around a bug (likely same cause as #5265)
////							$( this ).blur();
////
////							// pass empty string as value to search for, displaying all results
////							input.autocomplete( "search", "" );
////							input.focus();
////						});
//				';
//		$cs = Yii::app()->getClientScript();
//		$cs->registerScript(__CLASS__.'#'.$id, $js);
	}
	
	
	public function listData()
	{
		$users = User::model()->findAll();
		$data = array();
		foreach($users as $u){
			$data[] = array('name'=>$u->name, 'id'=>$u->id(), 'image'=>$u->profileImage);
		}
		return $data;
	}
}
