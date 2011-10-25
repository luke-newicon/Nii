<div id="settings-tabs" class="ui-tabs-vertical">
	<ul>
		<?php foreach ($settings->tabs as $id => $tab) : ?>
			<li data-id="<?php echo $id ?>" title="<?php echo $id ?>"><?php echo CHtml::link($tab['name'], $tab['url']) ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<div id="user"></div>
<script>
	$(function() {
		$("#settings-tabs").tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html("Error loading tab. Please try again.");
				}
			},
			cache: true,
			tabTemplate: '<li><a href="#{href}"><span>#{label}</span></a></li>'
		});
	});
</script>