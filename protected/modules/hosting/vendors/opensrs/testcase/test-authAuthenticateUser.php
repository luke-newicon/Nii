<?php 

if (isSet($_POST['function'])) {
	// ONLY FOR TESTING PURPOSE!!!
	require_once("../opensrs/spyc.php");

	// Form data capture
	$formFormat = $_POST["format"];

	// Put the data to the formated array
	$callstring = "";
	$callArray = array (
		"func" => $_POST["function"],
		"data" => array (
			"username" => $_POST["username"],
			"password" => $_POST["password"]
		)
	);

	if ($formFormat == "json") $callstring = json_encode($callArray);
	if ($formFormat == "yaml") $callstring = Spyc::YAMLDump($callArray);


	// Open SRS Call -> Result
	require_once ("../opensrs/openSRS_loader.php");
	$osrsHandler = processOpenSRS ($formFormat, $callstring);

	// Print out the results
	echo (" In: ". $callstring ."<br>");
	echo ("Out: ". $osrsHandler->resultFullFormated);

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

<form action="test-authAuthenticateUser.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="authAuthenticateUser">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%">
				<span class="headLine">Username </span> <input type="text" name="username" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td width="100%">
				<span class="headLine">Password </span> <input type="text" name="password" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td><input value="Authenticate User" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
