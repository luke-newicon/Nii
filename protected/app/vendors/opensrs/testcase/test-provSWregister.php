<?php 

if (isSet($_POST['function'])) {


// ONLY FOR TESTING PURPOSE!!!
require_once("../opensrs/spyc.php");

// !!!!!!!! ---  Proper form values verification  --- !!!!!!!!!

// Put the data to the proper form - ONLY FOR TESTING PURPOSE!!!
$formFormat = $_POST["format"];
$formFunction = $_POST["function"];

$callstring = "";
$callArray = array (
	"func" => $_POST["function"],
	"personal" => array (
		"first_name" => $_POST['first_name'],
		"last_name" => $_POST['last_name'],
		"org_name" => $_POST['org_name'],
		"address1" => $_POST['address1'],
		"address2" => $_POST['address2'],
		"address3" => $_POST['address3'],
		"city" => $_POST['city'],
		"state" => $_POST['state'],
		"postal_code" => $_POST['postal_code'],
		"country" => $_POST['country'],
		"phone" => $_POST['phone'],
		"fax" => $_POST['fax'],
		"email" => $_POST['email'],
		"url" => $_POST['url'],
		"lang_pref" => $_POST['lang_pref']
	),
	"cedinfo" => array (
		"contact_type" => $_POST['contact_type'],
		"id_number" => $_POST['id_number'],
		"id_type" => $_POST['id_type'],
		"id_type_info" => $_POST['id_type_info'],
		"legal_entity_type" => $_POST['legal_entity_type'],
		"legal_entity_type_info" => $_POST['legal_entity_type_info'],
		"locality_city" => $_POST['locality_city'],
		"locality_country" => $_POST['locality_country'],
		"locality_state_prov" => $_POST['locality_state_prov']
	),
	"nexus" => array (
		"app_purpose" => $_POST['app_purpose'],
		"category" => $_POST['category'],
		"validator" => $_POST['validator']
	),
	"data" => array (
		"reg_username" => $_POST['reg_username'],
		"reg_password" => $_POST['reg_password'],
		"reg_domain" => $_POST['reg_domain'],
		"reg_type" => $_POST['reg_type'],
		"affiliate_id" => $_POST['affiliate_id'],
		"auto_renew" => $_POST['auto_renew'],
		"domain" => $_POST['domain'],
		"f_parkp" => $_POST['f_parkp'],
		"f_whois_privacy" => $_POST['f_whois_privacy'],
		"f_lock_domain" => $_POST['f_lock_domain'],
		"period" => $_POST['period'],
		"link_domains" => $_POST['link_domains'],
		"custom_nameservers" => $_POST['custom_nameservers'],
		"name1" => $_POST['name1'],
		"sortorder1" => $_POST['sortorder1'],
		"name2" => $_POST['name2'],
		"sortorder2" => $_POST['sortorder2'],
		"name3" => $_POST['name3'],
		"sortorder3" => $_POST['sortorder3'],
		"name4" => $_POST['name4'],
		"sortorder4" => $_POST['sortorder4'],
		"name5" => $_POST['name5'],
		"sortorder5" => $_POST['sortorder5'],
		"encoding_type" => $_POST['encoding_type'],
		"custom_tech_contact" => $_POST['custom_tech_contact'],
		"change_contact" => $_POST['change_contact'],
		"master_order_id" => $_POST['master_order_id'],
		"dns_template" => $_POST['dns_template'],
		"handle" => $_POST['handle'],
		"custom_transfer_nameservers" => $_POST['custom_transfer_nameservers'],
		"premium_price_to_verify" => $_POST['premium_price_to_verify'],
		"country" => $_POST['country'],
		"lang" => $_POST['lang'],
		"owner_confirm_address" => $_POST['owner_confirm_address'],
		"ca_link_domain" => $_POST['ca_link_domain'],
		"cwa" => $_POST['cwa'],
		"domain_description" => $_POST['domain_description'],
		"isa_trademark" => $_POST['isa_trademark'],
		"lang_pref" => $_POST['lang_pref'],
		"legal_type" => $_POST['legal_type'],
		"rant_agrees" => $_POST['rant_agrees'],
		"rant_no" => $_POST['rant_no'],
		"forwarding_email" => $_POST['forwarding_email']
	)
);

if ($formFormat == "array") $callstring = $callArray;
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


<form action="test-provSWregister.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="provSWregister">

<table cellpadding="0" cellspacing="20" border="0" width="100%">
	<tr class="searchBox">
		<td class="searchBoxText" width="100%">
			<span class="headLine">Register new domain</span><br>
		</td>
	</tr>
	<tr>
		<td>
			<b>Personal info</b><br>
			first_name: <input type="text" name="first_name" value="Claire"><br>
			last_name: <input type="text" name="last_name" value="Lam"><br>
			org_name: <input type="text" name="org_name" value="Tucows"><br>
			address1: <input type="text" name="address1" value="96 Mowat Avenue"><br>
			address2: <input type="text" name="address2" value=""><br>
			address3: <input type="text" name="address3" value=""><br>
			city: <input type="text" name="city" value="Toronto"><br>
			state: <input type="text" name="state" value="ON"><br>
			postal_code: <input type="text" name="postal_code" value="M6K 3M1"><br>
			country: <input type="text" name="country" value="CA"><br>
			phone: <input type="text" name="phone" value="416-535-0123 x1386"><br>
			fax: <input type="text" name="fax" value=""><br>
			email: <input type="text" name="email" value="clam@tucows.com"><br>
			url: <input type="text" name="url" value="http://www.tucows.com"><br>
			lang_pref: <input type="text" name="lang_pref" value="EN">
		</td>
	</tr>
	<tr>
		<td>
			<b>Required at all time</b><br>
			domain: <input type="text" name="domain" value="tucowstest1000120xx.com"><br>
			period: <input type="text" name="period" value="1">year(s)<br>
			reg_username: <input type="text" name="reg_username" value="clam"><br>
			reg_password: <input type="text" name="reg_password" value="abc123"><br>
			reg_type: <input type="text" name="reg_type" value="new"><br>
			custom_tech_contact: <input type="text" name="custom_tech_contact" value="0"><br>
			custom_nameservers: <input type="text" name="custom_nameservers" value="1"><br>
		</td>
	</tr>
	<tr>
		<td>
			<b>Common optional</b><br>
			affiliate_id: <input type="text" name="affiliate_id" value="">Required on renewal order Leave blank for no affiliate<br>
			auto_renew: <input type="text" name="auto_renew" value="0"><br>
			change_contact: <input type="text" name="change_contact" value=""><br>
			reg_domain: <input type="text" name="reg_domain" value=""><br>
			f_parkp: <input type="text" name="f_parkp" value="Y"><br>
			f_whois_privacy: <input type="text" name="f_whois_privacy" value="1"><br>
			f_lock_domain: <input type="text" name="f_lock_domain" value="1"><br>
			link_domains: <input type="text" name="link_domains" value="0"><br>
			master_order_id: <input type="text" name="master_order_id" value=""><br>
			encoding_type: <input type="text" name="encoding_type" value=""><br>
			dns_template: <input type="text" name="dns_template" value=""><br>
			handle: <input type="text" name="handle" value=""><br>
			custom_transfer_nameservers: <input type="text" name="custom_transfer_nameservers" value=""><br>
			premium_price_to_verify: <input type="text" name="premium_price_to_verify" value=""><br>
			nameserver_list >>  <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name1" value="ns1.nameserver.com"> <input type="text" name="sortorder1" value="1"> <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name2" value="ns2.nameserver.com"> <input type="text" name="sortorder2" value="2"> <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name3" value=""> <input type="text" name="sortorder3" value=""> <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name4" value=""> <input type="text" name="sortorder4" value=""> <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name5" value=""> <input type="text" name="sortorder5" value=""> <br>
		</td>
	</tr>
	<tr>
		<td>
			<b>.Asia</b><br />
			tld_data >> ced_info >> <br />
			&nbsp; &nbsp;contact_type: <input type="text" name="contact_type" value="owner"><br>
			&nbsp; &nbsp;id_number: <input type="text" name="id_number" value="Pasport number"><br>
			&nbsp; &nbsp;id_type: <input type="text" name="id_type" value="passport"><br>
			&nbsp; &nbsp;id_type_info: <input type="text" name="id_type_info" value=""> required only for id_type = other<br>
			&nbsp; &nbsp;legal_entity_type: <input type="text" name="legal_entity_type" value="naturalPerson"><br>
			&nbsp; &nbsp;legal_entity_type_info: <input type="text" name="legal_entity_type_info" value="">required only for legal_entity_type = other<br>
			&nbsp; &nbsp;locality_city: <input type="text" name="locality_city" value=""> - Optional<br>
			&nbsp; &nbsp;locality_country: <input type="text" name="locality_country" value=""><br>
			&nbsp; &nbsp;locality_state_prov: <input type="text" name="locality_state_prov" value=""> - Optional<br>
			
		</td>
	</tr>
	<tr>
		<td>
			<b>.EU / .BE / .DE</b><br />
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.EU | country: <input type="text" name="country" value="gb"><br>
			&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;.BE | .EU | lang: <input type="text" name="lang" value="en"><br>
			.DE | .BE | .EU | owner_confirm_address: <input type="text" name="owner_confirm_address" value=""><br>
		</td>
	</tr>	
	<tr>
		<td>
			<b>.CA</b><br />
			ca_link_domain: <input type="text" name="ca_link_domain" value=""> - Optional<br>
			cwa: <input type="text" name="cwa" value=""> - Optional<br>
			domain_description: <input type="text" name="domain_description" value=""> - Optional<br>
			isa_trademark: <input type="text" name="isa_trademark" value="0"><br>
			lang_pref: <input type="text" name="lang_pref" value="en"><br>
			legal_type: <input type="text" name="legal_type" value="CCT"><br>
			rant_agrees: <input type="text" name="rant_agrees" value=""> - Optional<br>
			rant_no: <input type="text" name="rant_no" value=""> - Optional<br>
		</td>
	</tr>
	<tr>
		<td>
			<b>.US</b><br />
			tld_data >> nexus >> <br/>
			&nbsp; &nbsp;app_purpose: <input type="text" name="app_purpose" value=""><br>
			&nbsp; &nbsp;category: <input type="text" name="category" value=""><br>
			&nbsp; &nbsp;validator: <input type="text" name="validator" value="">Required if category = C31 or C32<br>
		</td>
	</tr>
	<tr>
		<td>
			<b>.NAME</b><br />
			tld_data >> <br/>
			&nbsp; &nbsp;forwarding_email: <input type="text" name="forwarding_email" value=""><br>
		</td>
	</tr>
	<tr>
		<td><input value="Register" id="lookupSearch" type="submit"></td>
	</tr>
</table>
</form>


	
</body>
</html>



<?php 
}
?> 