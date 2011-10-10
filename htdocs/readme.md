Nii
---------

The Nii app, is a skeleton app which holds modules, widgets and goodies used frequently in yii based application development.

Application Components
----------------------
 
 - NFileManager 
   This component is responsible for saving and retrieving files. That's all. 
   This creates a common interface for modules and widgets to save and retrieve files
 - NImage
   This component can manipulate images and also handles generating and caching various size image thumb nails.
   Dependant on NFileManager


Widgets
-------



Input Widgets
-------------

- NTextareaMarkdown
  Shows a textarea with a preview option to display the rendered markdown. Also provide a help link




Modules included:
 
 - users (manages user authentication and authorisation permissions)
 - support (an email client module, should be renamed to emailclient module)
 - crm (basic crm functionality in a nice gui)