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
			"cookie" => $_POST["cookie"],
			"bypass" => $_POST["bypass"],
			"domain" => $_POST["domain"],
			"subdomain" => $_POST["subdomain"],
			"description" => $_POST["description"],
			"destination_url" => $_POST["destination_url"],
			"enabled" => $_POST["enabled"],
			"keywords" => $_POST["keywords"],
			"masked" => $_POST["masked"],
			"title" => $_POST["title"]
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

<form action="test-fwdSet.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="fwdSet">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">cookie </span> <input type="text" name="cookie" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">bypass domain </span> <input type="text" name="bypass" value="" class="frontBox"> <small>In case that your provider allows you to use this. Cookie not required.</small></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">subdomain </span> <input type="text" name="subdomain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">description </span> <input type="text" name="description" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">destination_url </span> <input type="text" name="destination_url" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">enabled </span> <input type="text" name="enabled" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">keywords </span> <input type="text" name="keywords" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">masked </span> <input type="text" name="masked" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">title </span> <input type="text" name="title" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Set Forwarding" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
