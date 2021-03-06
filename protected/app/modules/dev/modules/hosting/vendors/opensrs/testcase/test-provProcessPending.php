<?php 

if (isSet($_POST['function'])) {
	require_once("../opensrs/spyc.php");

	// Form data capture
	$formFormat = $_POST["format"];

	// Put the data to the formated array
	$callstring = "";
	$callArray = array (
		"func" => $_POST["function"],
		"data" => array (
			"command" => $_POST["command"],
			"order_id" => $_POST["order_id"],
			"fax_received" => $_POST["fax_received"],
			"owner_address" => $_POST["owner_address"]
		)
	);
	
	if ($formFormat == "json") $callstring = json_encode($callArray);
	if ($formFormat == "yaml") $callstring = Spyc::YAMLDump($callArray);


	// Open SRS Call -> Result
	require_once ("../opensrs/openSRS_loader.php");
	$osrsHandler = processOpenSRS ($formFormat, $callstring);

	// Print out the results
	echo (" In: ". $callstring ."<br>");
	echo ("Out: ". $osrsHandler->resultFormated);

} else {
	// Format
	if (isSet($_GET['format'])) {
		$tf = $_GET['format'];
	} else {
		$tf = "json";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title></title>
	<meta name="generator" http-equiv="generator" content="Claire Lam" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en"/>
</head>
<body>

<form action="test-provProcessPending.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="provProcessPending">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">command </span> <input type="text" name="command" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">order_id </span> <input type="text" name="order_id" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">fax_received </span> <input type="text" name="fax_received" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">owner_address </span> <input type="text" name="owner_address" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Process Pending" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
