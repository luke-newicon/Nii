<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		
		<link rel="stylesheet" media="print" type="text/css" href="<?php echo Yii::app()->urlManager->baseUrl; ?>/css/print.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->urlManager->baseUrl; ?>/css/style.css" />
<style>
	
.page{width:940px;}

/* for the grid jquery thing (hold down g) */
#grid{

    /* Dimensions - same width as your grid with gutters */
    width: 980px;

    /* Grid (left-aligned)
    position: absolute;
    top: 0;
    left: 0;
    */

    /* Grid (centered) */
    position: absolute;
    top: 0;
    left: 50%;
    margin-left: -490px;

}

/**
 * Vertical grid lines
 *
 * Set the column width taking the borders into consideration,
 * and use margins to set column gutters.
 */
#grid div.vert{

    width: 139px;
    border: solid darkturquoise;
    border-width: 0 1px;
    margin-right: 19px;

}

#grid div.vert.first-line{

    margin-left: 19px;

}


/**
 * Horizontal grid lines, defined by your base line height
 *
 * Remember, the CSS properties that define the box model:
 * visible height = height + borders + margins + padding
 */
#grid div.horiz{

    /* 20px line height */
    height: 23px;
    border-bottom: 1px dotted darkgray;
    margin: 0;
    padding: 0;

}

/**
* Classes for multiple grids
*
* When using more than one grid, remember to set the numberOfGrids 
* option in the hashgrid.js file.
*/
#grid.grid-1 div.vert{

    /* Vertical grid line colour for grid 1 */
    border-color: darkturquoise;

}
#grid.grid-2{

    /* Adjustments */
    padding: 0 160px;
    width: 660px;

}
#grid.grid-2 div.vert{

    /* Vertical grid line colour for grid 2 */
    border-color: crimson;

}
			
		</style>
	</head>
	<body>
		<div class="page">
			<?php $this->renderPartial('//layouts/site/_head'); ?>
			<div class="body">
				<div class="main">
					<?php $this->renderPartial('//layouts/_messages'); ?>
					<?php // $this->renderPartial('//layouts/_breadcrumbs'); ?>
					<?php echo $content; ?>
				</div>
			</div>
			<?php $this->renderPartial('//layouts/site/_foot'); ?>
		</div>
<!--		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>-->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/hashgrid/hashgrid.js" ></script>
	</body>
</html>