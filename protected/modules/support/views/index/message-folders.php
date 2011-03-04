<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?php foreach ($folders as $localName => $folder): ?>
	<?php $localName = str_pad('', $folders->getDepth(), '-', STR_PAD_LEFT) . $localName; ?>
	<?php if (!$folder->isSelectable()): ?>

	<?php else: ?>
		<div><?php echo htmlspecialchars($localName) ?></div>
	<?php endif; ?>
<?php endforeach; ?>