<?php

/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
?>

<script type="text/template" id="time-log-row-template">
	<td>
		<% if (editable) { %>
		<div class="field mbn project" >
			<div class="input">
				<input class="select" type="text" value="">
				<input class="project-id" type="hidden" name="log[<%= row %>][project]" id="project_<%= row %>" />
			</div>
			<span style="position:absolute;top:5px;right:5px;cursor:pointer;" class="down sprite fam-bullet-arrow-down"></span>
		</div>
		<% } %>
		<% if (!editable) { %>
			<% print(window.timesheet.projects.displayProject(project_id)); %>
		<% } %>
	</td>
	<td>
		<% if (editable) { %>
			<div class="field mbn task">
				<div class="input">
					<input name="log[<%= row %>][task]" id="task_<%= row %>" type="text" />
				</div>
			</div>
		<% } %>
		<% if (!editable) { %>
			<% print(window.timesheet.tasks.displayTask(task_id)); %>
		<% } %>
	</td>
	<td class="hour_units mon-col field <% print(window.timesheet.printToday(1)) %>">
		<% if (editable) { %>
			<div class="input">
				<input class="time" name="log[<%= row %>][time][]" value="<%= mon %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= mon %>
		<% } %>
	</td>
	<td class="hour_units tue-col field <% print(window.timesheet.printToday(2)) %>">
		<% if (editable) { %>
			<div class="input">
				<input class="time" name="log[<%= row %>][time][]" value="<%= tue %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= tue %>
		<% } %>
	</td>
	<td class="hour_units wed-col field <% print(window.timesheet.printToday(3)) %>">
		<% if (editable) { %>
			<div class="input">
				<input class="time" name="log[<%= row %>][time][]" value="<%= wed %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= wed %>
		<% } %>
	</td>
	<td class="hour_units thu-col field <% print(window.timesheet.printToday(4)) %>">
		<% if (editable) { %>
			<div class="input">
				<input class="time" name="log[<%= row %>][time][]" value="<%= thu %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= thu %>
		<% } %>
	</td>
	<td class="hour_units fri-col field <% print(window.timesheet.printToday(5)) %>">
		<% if (editable) { %>
			<div class="input">
				<input class="time" name="log[<%= row %>][time][]" value="<%= fri %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= fri %>
		<% } %>
	</td>
	<td class="hour_units sat-col field <% print(window.timesheet.printToday(6)) %>">
		<% if (editable) { %>
			<div class="input">
				<input class="time" name="log[<%= row %>][time][]" value="<%= sat %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= sat %>
		<% } %>
	</td>
	<td class="hour_units sun-col field <% print(window.timesheet.printToday(0)) %>">
		<% if (editable) { %>
			<div class="input">
				<input class="time" name="log[<%= row %>][time][]" value="<%= sun %>" type="text"  maxlength="4" />
			</div>
		<% } %>
		<% if (!editable) { %>
			<%= sun %>
		<% } %>
	</td>
	<td class="hour_units total-col">0:00</td>
	<td class="delete-col">
		<% if (editable){ %>
			<a href="#" class="icon fam-delete record-delete"></a>
		<% } %>
	</td>
</script>