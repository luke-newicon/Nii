<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<style>
	.col{border-left:1px solid #ccc;}
	.col .cbd {padding:5px;height:500px;}

	.thing{padding:5px;border:1px solid #ccc;background-color:#f9f9f9;margin-bottom:5px;}
	.thingDropHover{background-color:#f9f9f9;}



    .place_holder {
        width: 100%;
        height: 20px;
        background: #ddd;
        margin: 0 0 10px 0;
    }
</style>


<div class="line">

	<div class="unit size1of4 col">
		<div class="chd topper">
			Column1
		</div>
		<div class="cbd">
			<div class="thing">
				a
			</div>
			<div class="thing">
				b
			</div>
			<div class="thing">
				c
			</div>
			<div class="thing">
				d
			</div>
			<div class="thing">
				e
			</div>
			<div class="thing">
				f
			</div>
			<div class="thing">
				g
			</div>
			<div class="thing">
				h
			</div>
		</div>
	</div>
	<div class="unit size1of4 col">
		<div class="chd topper">
			Column1
		</div>
		<div class="cbd">
		</div>
	</div>
	<div class="unit size1of4 col">
		<div class="chd topper">
			Column1
		</div>
		<div class="cbd">
		</div>
	</div>
	<div class="lastUnit col">
		<div class="chd topper">
			Column1
		</div>
		<div class="cbd">

		</div>
	</div>
</div>




<script>
$(document).ready(function() {

    // THANKS FOR YOUR HELP :) - Whit

//    $('.pagetab').click(function() {
//        show_page(extract_id($(this).attr('id')));
//    });

    $(".cbd").sortable({
        connectWith: '.cbd',
        opacity: 0.4,
        tolerance: 'pointer',
        placeholder: 'place_holder',
        helper: function(event, el) {
            var myclone = el.clone();
            $('body').append(myclone);
            return myclone;
        }
    }).disableSelection();

// not used but very clever shows a hidden page which can also accept the droppables
//    $(".pagetab").droppable({
//        over: function(event, ui) {
//            $(".pagetab").removeClass('pagetab_drop');
//            $(this).addClass('pagetab_drop')
//            show_page(extract_id($(this).attr('id')));
//        },
//        out: function(event, ui) {
//            $(".pagetab").removeClass('pagetab_drop');
//        },
//        tolerance: 'pointer'
//    });

});

//function show_page(id) {
//    $('.page').removeClass('page_active');
//    $('#page_'+id).addClass('page_active');
//}
//
//function extract_id(str) {
//    return str.substr(str.indexOf('_')+1,str.length+1);
//}

</script>