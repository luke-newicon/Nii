<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<from name="myform">
    
    <input id="contact_0_name" />
    <input id="contact_1_name" />
    
    
</form>
    
<script>
$(function() {
    var attrs = [];
    alert('oi')
        alert($('form').attr('name'))
    $('form').find('input').each(function(i, e) {
        $el = $(e);
        var modelName = $el.attr('id');
        var patrn = '(.*)_[0-9]_(.*)';
        var m = modelName.match(patrn);

        alert('oi')
        if (m.length == 4) {
            //attrs[i] = {'inputID':$el.attr('id'),'errorID':$el.attr('id')+'_em_','model':m[1],'name':m[3]};}
        };
    });
})
       
</script>