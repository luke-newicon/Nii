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
			"authusername" => $_POST["authusername"],
			"authpassword" => $_POST["authpassword"],
			"authdomain" => $_POST["authdomain"],
			"domain" => $_POST["domain"],
			"workgroup" => $_POST["workgroup"],
			"mailbox" => $_POST["mailbox"],
			"password" => $_POST["password"],
			"first_name" => $_POST["first_name"],
			"last_name" => $_POST["last_name"],
			"title" => $_POST["title"],
			"phone" => $_POST["phone"],
			"fax" => $_POST["fax"],
			"timezone" => $_POST["timezone"],
			"language" => $_POST["language"],
			"filteronly" => $_POST["filteronly"],
			"spam_tag" => $_POST["spam_tag"],
			"spam_folder" => $_POST["spam_folder"],
			"spam_level" => $_POST["spam_level"]
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

<form action="test-mailCreateMailbox.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="mailCreateMailbox">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr><td><b>Authentication</b></td></tr>
		<tr>
			<td width="100%"><span class="headLine">authusername </span> <input type="text" name="authusername" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">authpassword </span> <input type="text" name="authpassword" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">authdomain </span> <input type="text" name="authdomain" value="" class="frontBox"></td>
		</tr>
		<tr><td><b>Required</b></td></tr>
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">workgroup </span> <input type="text" name="workgroup" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">mailbox </span> <input type="text" name="mailbox" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">password </span> <input type="text" name="password" value="" class="frontBox"></td>
		</tr>
		<tr><td><b>Optional</b></td></tr>
		<tr>
			<td width="100%"><span class="headLine">first_name </span> <input type="text" name="first_name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">last_name </span> <input type="text" name="last_name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">title </span> <input type="text" name="title" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">phone </span> <input type="text" name="phone" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">fax </span> <input type="text" name="fax" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">timezone </span> <input type="text" name="timezone" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">language </span> <input type="text" name="language" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">filteronly </span> <input type="text" name="filteronly" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">spam_tag </span> <input type="text" name="spam_tag" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">spam_folder </span> <input type="text" name="spam_folder" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">spam_level </span> <input type="text" name="spam_level" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Create Mailbox" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
