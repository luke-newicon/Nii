<div id="<?php echo $this->ID; ?>"><p>File uploader failed to load.</p></div>
<script type="text/javascript">
jQuery(function($) {
    $("#<?php echo $this->ID; ?>").uploadify(<?php echo $config; ?>);
});
</script>