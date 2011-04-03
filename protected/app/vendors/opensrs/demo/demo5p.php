<?php 

if (isSet($_POST['function'])) {
	// ONLY FOR TESTING PURPOSE!!!
	require_once("../opensrs/spyc.php");
	
	// !!!!!!!! ---  Proper form values verification  --- !!!!!!!!!
	
	$formFormat = $_POST["format"];
	$formFunction = $_POST["function"];
	$formDomain = $_POST["domain"];
	$formTLD = $_POST["tld"];
	
	// Put the data to the proper form - ONLY FOR TESTING PURPOSE!!!
	$callstring = "";
	$callArray = array (
		"func" => $formFunction,
		"data" => array (
			"domain" => $formDomain,
			"selected" => $formTLD,
			"defaulttld" => $formTLD
		)
	);

	if ($formFormat == "json") $callstring = json_encode($callArray);
	if ($formFormat == "yaml") $callstring = Spyc::YAMLDump($callArray);
	
	// Open SRS Call -> Result
	require_once ("../opensrs/openSRS_loader.php");
	$osrsHandler = processOpenSRS ($formFormat, $callstring);
	
	// Print out the results
//	echo (" In: ". $callstring ."<br>");
//	echo ("Out: ". $osrsHandler->resultFormated);
	
	$jsonRet = $osrsHandler->resultRaw;
	echo ($jsonRet[0]['status']);
	
} else {
	echo ("<h2>Invalid call!</h2>");
}
?> 
