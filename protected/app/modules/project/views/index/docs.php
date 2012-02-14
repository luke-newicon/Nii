<?php

/**
 * Nii php file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
?>

<h1>Project API</h1>

<p>access a project resource</p>
<code>http://nii/project/</code>
<p>returns a list of top level projects</p>

<pre>
{
    id:1,
    name:"project 1",
    tasks:"http://nii/project/project-1/tasks",
},
{
    id:2,
    name:"awesome project",
    tasks:"http://nii/project/awesome-project/tasks"
}
</pre>
