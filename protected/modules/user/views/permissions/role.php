<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<h1>Role: <?php echo $role->name; ?></h1>

<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>array(
		'Permissions'=>'Tree of permissions to assign',
		'Users'=>array('content'=>'Users in this role', 'id'=>'tab2'),
		// panel 3 contains the content rendered by a partial view
		'AjaxTab'=>array('ajax'=>NHtml::url('/user/permissions/roles')),
	),
	// additional javascript options for the tabs plugin
	'options'=>array(
		'collapsible'=>true,
	),
));
?>
Users in this role:


<br />
<br />
<br />
<br />

Permissions:
<br />
Super User | Not Super User
<br />
<br />
Roles check box tree
