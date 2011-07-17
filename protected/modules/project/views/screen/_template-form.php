<div id="templateForm" class="spotForm toolbarForm" style="position:fixed;display:none;">
	<div class="spotFormContainer" style="position:relative;">
		<div class="triangle-verticle"></div>
		<p id="templateFormNoTemplate">You don't have any templates, why not add a new one?</p>
		<ul class="noBull man">
			<li class="addTemplate">
				<label>
					<div class="line">
						<div class="unit size3of4">
							<div class="inputBox" style="position:relative;">
								<input id="newTemplate" name="newTemplate" type="text" autocomplete="off" />
								<label id="newTemplate-hint" style="position:absolute;left:8px;top:4px;color:#aaa;" for="newTemplate">Enter a new template name</label>
							</div>
						</div>
						<div class="lastUnit">
							<input id="newTemplateSubmit" style="width:62px;padding-bottom:4px;" type="submit" class="btn aristo btnToolbarRight" value="save"/>
						</div>
					</div>
				</label>
			</li>
			<?php foreach($screen->getTemplates() as $template): ?>
				<?php $this->renderPartial('/screen/_template-item', array('template'=>$template, 'screenId'=>$screen->id)); ?>
			<?php endforeach; ?>
		</ul>
		<div class="templateOk txtR"><button class="btn aristo">Ok</button></div>
	</div>
</div>