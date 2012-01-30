<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
   code { background-color: #FEE9CC;color: rgba(0, 0, 0, 0.75);padding: 1px 3px;}
code, pre { padding: 0 3px 2px; font-family: Monaco, Andale Mono, Courier New, monospace; font-size: 12px; -webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;}
</style>
<div class="alert-message">
	Install was successful but I can not save the configuration file, because the config directory is not writable.
 <br/>
</div>

<p>
    We have created the config file for you.  <strong><a href="<?php echo NHtml::url(array('install/configFile','content'=>base64_encode($config))); ?>">Download it here</a></strong> and place it in the <code><?php echo $configFolder; ?></code> folder. 
    <br/><br/><em>(Or you can make the config folder writable and hit refresh)</em>
</p>

For the techies, the contents of the local.php configuration file is:
<?php $this->beginWidget('CTextHighlighter', array('language'=>'php','showLineNumbers'=>true, 'lineNumberStyle'=>true)); ?>
<?php echo $config; ?>
<?php $this->endWidget(); ?>

<a href="<?php echo NHtml::url(); ?>" class="btn large primary">Ok, I have done this, continue</a>