<?php 
	// Domain TLDs
	$popular = array (".ca", ".com", ".net", ".org", ".me", ".biz", ".info");
//	$domains = array (".mobi", ".tel", ".name", ".tv", ".eu", ".cc", ".at", ".es", ".be", ".co.uk", ".org.uk", ".me.uk", ".uk.com", ".us.com", ".gb.com", ".eu.com", ".de.com", ".jpn.com", ".qc.com", ".cn.com", ".za.com", ".se.com", ".sa.com", ".kr.com", ".ru.com", ".hu.com", ".no.com", ".uy.com", ".br.com", ".uk.net", ".gb.net", ".se.net", ".ae.org");	
	$domains = array (".mobi", ".tel", ".name", ".tv", ".eu", ".cc", ".at", ".es", ".be", ".co.uk", ".org.uk", ".me.uk");	
	
	// Modify the field name
	function nameFix ($wordIn){
		$wordOut = str_replace(".", "-", $wordIn);
		return $wordOut;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us" >
<head>
	<link rel="stylesheet" href="css/template.css" type="text/css" />
	<link rel="stylesheet" href="css/template-about.css" type="text/css" />
	
    <script language="Javascript" type="text/javascript" src="js/json2.js"></script>
    <script language="Javascript" type="text/javascript" src="js/jquery-1.3.2.js"></script>
    <script language="Javascript" type="text/javascript" src="js/jquery-ui-1.7.2.js"></script>
    <script language="Javascript" type="text/javascript" src="js/runonload.js"></script>
	<script language="Javascript" type="text/javascript" src="js/democode.js"></script>	
	
	<script type="text/javascript">
		
		// JS arrays definitions based on PHP code
		var popular = [<?php 
			$out = implode ("', '", $popular);
			echo ("'". $out ."'");
		?>];
		var popularFixed = [<?php 
			$out = implode ("', '", nameFix ($popular));
			echo ("'". $out ."'");
		?>];
		var domains = [<?php 
			$out = implode ("', '", $domains);
			echo ("'". $out ."'");
		?>];
		var domainsFixed = [<?php 
			$out = implode ("', '", nameFix ($domains));
			echo ("'". $out ."'");
		?>];


		// initial call for the functions
		runOnLoad(function(){
		});

		// 
		function makeThatCall (userValEnt, tldStr, dest){

			// Call formating functions. Proper JSON or YAML will be created here and passed to server in function below
			
			$.ajax({
				url: 'http://www.someserver.com/path/openSRSLoader.php',
				data: 'format=json&data=---Actual data string in proper format---',
				type: 'POST', 	 // POST / GET ---  GET Will be allowed for because loader will be abe to handle direct URLs with all information within
				success: function (htmlResult) {
					$('div#r'+ dest).html(htmlResult);			// Loader responce in format used for the call
				}
			});
		}



		$(function() {
			// Init setup 

			// key binding
			$('#domain').bind('keypress', function(e) {
				// key - Enter
				if(e.keyCode==13){
					
					var tldStr = "";
					var userValEnt = $("input#domain").val();
					if (userValEnt == ""){
						// $("input#domain").val("Please type something here.");
						// empty field check
					} else {
						// Tucows blast all TLD requests are sent to to verification
						
						// Load the values to page
						for (i=0; i<popularFixed.length; i++){
							$('div#r'+ popularFixed[i]).html("<img src='images/smalloaderb.gif' />");
							
							tldStr = $('span#d'+ popularFixed[i]).html();
							makeThatCall (userValEnt, tldStr, popularFixed[i]);
						}
						
						// Load the rest after
						for (i=0; i<domainsFixed.length; i++){
							$('div#r'+ domainsFixed[i]).html("<img src='images/smalloaderb.gif' />");
							
							tldStr = $('span#d'+ domainsFixed[i]).html();
							makeThatCall (userValEnt, tldStr, domainsFixed[i]);
						}
					}
				}
			});

			// Typing and page propagation
			$('#domain').keyup(function () {
				var userVal = $("input#domain").val();
				var t = this;

				// Remove spaces some strings - Add some more here or make it a bit smarter
				userVal = userVal.split(' ').join('')
				userVal = userVal.split('=').join('')
				userVal = userVal.split(',').join('')
				userVal = userVal.split('.').join('')
				userVal = userVal.split('/').join('')
				userVal = userVal.split('?').join('')
				userVal = userVal.split('"').join('')
				userVal = userVal.split('\'').join('')
				$("input#domain").val(userVal);
				
				// Load the values to page
				for (i=0; i<popularFixed.length; i++){
					$('span#f'+ popularFixed[i]).html(userVal);
				}
				for (i=0; i<domainsFixed.length; i++){
					$('span#f'+ domainsFixed[i]).html(userVal);
				}
			});	
		});
	</script>	
</head>

<body>
	<a name="up" id="up"></a>
	
	<div id="center" align="center">
		<div id="backbanner"><div id="wrapper" class="osrs_header_blue">
			<!-- Page header -->
			<table cellpadding="0" cellspacing="0" border="0" width="960">
				<tr>
					<td width="198" rowspan="2" valign="top"><a href=""><img src="images/osrs_header_logo.png" width="198" height="120" border="0" /></a></td>
					<td class="header_layer1">Toolkit Demo</td>
				</tr>
				<tr>
					<td class="header_layer2"></td>
				</tr>
				<tr>
					<td colspan="2" class="header_layer3" valign="top"><div class="headerFieldPadding"><div class="headerFieldBack">
						<input name="domain" id="domain" value="" class="headerbox" type="text" />
					</div></div></td>
				</tr>
			</table>
	
			<!-- page content -->
			<div id="content">
				<table cellpadding="0" cellspacing="0" border="0" width="540">
					<tr>
						<td colspan="5" class="listHeadline">Popular domains</td>
					</tr>
<?php
	for ($i=0; $i<count($popular); $i++){
		$temp = ($i % 2) + 1;
		$fixed = nameFix ($popular[$i]);
?>
					<tr class="listLine<?php echo ($temp); ?>">
						<td id="field<?php echo ($fixed);?>">
							<span id="f<?php echo ($fixed);?>"></span><b><span id="d<?php echo ($fixed);?>"><?php echo ($popular[$i]); ?></span></b>
							<div id="r<?php echo ($fixed);?>" class="lineResult"></div>
						</td>
					</tr>
<?php
	}
?>
				</table>
			</div>
			
			<div id="content">
				<table cellpadding="0" cellspacing="0" border="0" width="540">
					<tr>
						<td colspan="5" class="listHeadline">Other domains</td>
					</tr>
<?php
	for ($i=0; $i<count($domains); $i++){
		$temp = ($i % 2) + 1;
		$fixed = nameFix ($domains[$i]);
?>
					<tr class="listLine<?php echo ($temp); ?>">
						<td id="field<?php echo ($fixed);?>">
							<span id="f<?php echo ($fixed);?>"></span><b><span id="d<?php echo ($fixed);?>"><?php echo ($domains[$i]); ?></span></b>
							<div id="r<?php echo ($fixed);?>" class="lineResult"></div>
						</td>
					</tr>
<?php
	}
?>
				</table>
			</div>
			
			<!-- Page footer -->
			<div id="footer">
				<!-- Left links -->
				<a href="http://www.facebook.com/home.php#/pages/OpenSRS/127798660660?ref=s">OpenSRS is part of </a><a href="http://www.tucowsinc.com/">Tucows</a>
				<span class="separator">|</span> <a href="http://opensrs.com/privacy">Privacy Policy</a>	<span class="separator">|</span> 
				<a href="http://opensrs.com/sitemap.php">Sitemap</a> <span class="separator">|</span>  &copy; 2010
			</div>	
			
		</div></div>
	</div>
</body>

</html>