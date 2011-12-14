<?php

class GoogleBugsPortlet extends NPortlet {

	public $title = '<h3>Welcome to Hope for Tomorrow</h3>';
//	public $contentCssClass='portlet-body h400 overflow-scroll mbs';

	protected function renderContent() {
		echo '<div class="alert-message block-message info">';
		echo '<p>This is the Hope for Tomorrow development site. As new sections are available, they will appear in the menu above.</p>';
		echo '<p>If you spot any bugs or have a feature request, please enter the details below.<br />You can view updates on your requests <a href="https://docs.google.com/a/newicon.net/spreadsheet/ccc?key=0Ape6AGoGde2YdEs2NUlTUzBUZkY4WFVFeE0xZHJlckE" target="_blank">here</a>.</p></div>';
		echo '<iframe src="https://docs.google.com/spreadsheet/embeddedform?formkey=dEs2NUlTUzBUZkY4WFVFeE0xZHJlckE6MQ" width="500" height="850" frameborder="0" marginheight="0" marginwidth="0" style="margin-top: 10px;">Loading...</iframe>';
	}

}