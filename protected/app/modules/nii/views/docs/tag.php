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
<h1>Taggable behavior</h1>

<p>Add the ability to attach tags to any NActiveRecord model with an id (primary key) column.</p>

<p>This plugin allows you to easily add and search for models which have been tagged.</p>

<h2>Make a model taggable</h2>

<?php $this->beginWidget('CTextHighlighter', array('language' => 'php')); ?>

<?php $this->endWidget(); ?>