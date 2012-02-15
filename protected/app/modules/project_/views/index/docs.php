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
    name:"my awesome project",
    tasks:"http://nii/project/my-awesome-project/tasks"
}
</pre>


<code>http://nii/project/my-awesome-project</code>

<pre>
{
    id:2,
    name:"my awesome project",
    tasks:"http://nii/project/my-awesome-project/tasks"
    jobs:{
        data: [
            {
                id:'3',
                name:'build website',
                total_minutes:'3600',
                total_minutes_done:'3600',
                tasks:'http://nii/project/my-awesome-project/job/build-website',
            },
            {
                id:'4',
                name:'build website 2',
                total_minutes:'3600',
                total_minutes_done:'3600',
                tasks:'http://nii/project/my-awesome-project/job/build-website'
            },
            {
                id:'5',
                name:'maintenance',
                total_minutes:'3600',
                total_minutes_done:'3600',
                tasks:'http://nii/project/my-awesome-project/job/build-website'
            },
            {
                id:'6',
                name:'email campaign',
                total_minutes:'3600',
                total_minutes_done:'3600',
                tasks:'http://nii/project/my-awesome-project/job/build-website'
            },
            {
                id:'7',
                name:'promotion',
                total_minutes:'3600',
                total_minutes_done:'3600',
                tasks:'http://nii/project/my-awesome-project/job/build-website'
            }
        ],
        paging:{
            next:"http://nii/project/my-awesome-project/jobs?offset=5"
        }
    }
}
</pre>

