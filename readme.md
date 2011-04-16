Nii
---------

The Nii app, is a skeleton app which holds sever modules, widgets and goodies used frequently in yii based application development.

Major application components:
 
 - NFileManager 
   This component is responsible for saving and retrieving files. That's all. 
   This creates a common interface for modules and widgets to save and retrieve files
 - NImage
   This component can manipulate images and also handles generating and caching various size image thumb nails.
   Dependant on NFileManager 

Modules included:
 
 - users (manages user authentication and authorisation permissions)
 - support (an email client module, should be renamed to emailclient module)
 - crm (basic crm functionality in a nice gui)