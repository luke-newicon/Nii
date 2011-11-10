<tr data-id="<?php echo $link->link; ?>">
	<td><a target="_blank" href="<?php echo $link->getLink(); ?>"><?php echo $link->link; ?></a></td>
	<td class="txtC"><?php echo ($link->password)?$link->password:'-'; ?></td>
	<td><a href="#" class="icon fugue-pencil edit"></a><a href="#" class="icon fugue-minus-circle delete"></a></td>
</tr>