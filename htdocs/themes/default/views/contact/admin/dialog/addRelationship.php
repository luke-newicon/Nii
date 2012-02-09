<div class="line">
	<div class="unit size1of3"><?php echo$this->t('Relationship Type')?></div>
	<div class="lastUnit">
		<?php
			$data = $c->getContactTypePairs($c->contact_type,true);
			echo NHtml::dropDownList('type', '', $data, array('class'=>'inputInline', 'prompt' => 'select...'));
		?>
	</div>
</div>
<div class="line" id="addRelButton">
	<div class="unit size1of3">&nbsp;</div>
	<div class="lastUnit">
		<?php echo NHtml::btnLink($this->t('Add and Continue'), '#', 'icon fam-tick', array('class' => 'btn btnN addRelContinue', 'id' => 'addRelContinue', 'style' => 'padding: 3px 5px;')); ?>
	</div>
</div>
<?php echo NHtml::hiddenField('rel_contact_id', $c->id); ?>
<script>
$(function(){
	
	// Fix a bug in jQuery UI tabs where the add function wrongly counts the index and creates an extra blank tab
	$("#tabs").data('tabs').add = function(url, label, index) {
        if ( index === undefined ) {
            index = this.anchors.length;
        }

        var self = this,
            o = this.options,
            $li = $( o.tabTemplate.replace( /#\{href\}/g, url ).replace( /#\{label\}/g, label ) );

        $li.addClass( "ui-state-default ui-corner-top" ).data( "destroy.tabs", true );

        if ( index >= this.lis.length ) {
            $li.appendTo( this.list );
        } else {
            $li.insertBefore( this.lis[ index ] );
        }

        o.disabled = $.map( o.disabled, function( n, i ) {
            return n >= index ? ++n : n;
        });

        this._tabify();

        if ( this.anchors.length == 1 ) {
            o.selected = 0;
            $li.addClass( "ui-tabs-selected ui-state-active" );
            $panel.removeClass( "ui-tabs-hide" );
            this.element.queue( "tabs", function() {
                self._trigger( "show", null, self._ui( self.anchors[ 0 ], self.panels[ 0 ] ) );
            });

            this.load( 0 );
        }

        this._trigger( "add", null, this._ui( this.anchors[ index ], this.panels[ index ] ) );
        return this;
	}
	
	$('#addRelButton').delegate('.addRelContinue','click',function(){
		var type = $('#type option:selected').text();
		var url = '<?php echo Yii::app()->baseUrl ?>/index.php/contact/'+$('#type').val()+'Details/cid/'+$('#rel_contact_id').val();
		$('#tabs').tabs("add", url, type);
		$('#tabs').tabs("select", $('#tabs').tabs("length")-1);
		$('#addRelationshipDialog').dialog('close');
		return false;
	}); 
});
</script>