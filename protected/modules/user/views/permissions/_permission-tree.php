<!--
<div id="demo1">
<ul>
	<li>
		<a href="some_value_here">Node title</a>
		 UL node only needed for children - omit if there are no children 
		<ul>
			<li><a href="some_value_here 1">Node title 1</a></li>
			<li><a href="some_value_here 2">Node title 2</a>
				<ul>
					<li><a href="some_value_here 1">Node title 1</a></li>
					<li><a href="some_value_here 2">Node title 2</a></li>
				</ul>
			</li>
		</ul>

	</li>
</ul>
</div>-->


<?php
// array('data'=>'node 1', 'children'=>array('node 2', 'node 3'))
$this->Widget('application.widgets.jstree.CJsTree', array(
	'id'=>'permissions',
	'core'=>array('animation'=>0),
	'json_data'=>array(
		'data'=>$permissions
	),
//	'html_data'=>array(
//		'data'=>'<div id="demo1">
//		<ul>
//			<li>
//				<a href="some_value_here">Node title</a>
//				<ul>
//					<li><a href="some_value_here 1">Node title 1</a></li>
//					<li><a href="some_value_here 2">Node title 2</a>
//						<ul>
//							<li><a href="some_value_here 1">Node title 1</a></li>
//							<li><a href="some_value_here 2">Node title 2</a></li>
//						</ul>
//					</li>
//				</ul>
//
//			</li>
//		</ul>
//		</div>'
//	),
	'themes'=>array('theme'=>'ni'),
	'plugins'=>array("themes", "json_data", "checkbox"),
));
?>


<a href="#" onclick="jQuery('#permissions').jstree('get_checked').each(function(i, el){alert($(el).text())});return false;">get checked</a>