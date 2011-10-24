<?php

$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id' => 'settings-tabs',
	'tabs' => $settings->tabs,
));
?>
<style type="text/css">
/* Vertical Tabs
----------------------------------*/
.ui-tabs-vertical{}
.ui-tabs-vertical .ui-widget-header{background:none;border:none}
.ui-tabs-vertical .ui-tabs-nav{padding:.2em .1em .2em .2em;float:left;width:12em;border-radius:0;border-right:1px solid #AAAAAA}
.ui-tabs-vertical .ui-tabs-nav li{clear:left;width:100%;border:1px solid #AAAAAA !important;border-bottom-width:1px !important;border-right-width:0 !important;margin:0 -1px .2em 0}
.ui-tabs-vertical .ui-tabs-nav li a{display:block;float:none}
.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-selected{padding-bottom:0;padding-right:.1em;border-right-width:1px;border-right-width:1px;margin:0 -1px .2em 0}
.ui-tabs-vertical .ui-tabs-panel{padding:1em;float:left}
</style> 

<script>
    $(document).ready(function() {
        $("#settings-tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
        $("#settings-tabs li").removeClass('ui-corner-top').addClass('ui-corner-left');
    });
</script>