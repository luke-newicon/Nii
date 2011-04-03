<?
$callArray = array (
        "func" => "subresGet",
        "data" => array (
                "username" => "clamsub10"
        )
);

require_once("/opt/apache/htdocs/client/.opensrs_api/opensrs/openSRS_loader.php");

$callstring = json_encode($callArray);

$osrsHandler = processOpenSRS ("json", $callstring);

echo (" In: ". $callstring ."<br>");
echo ("Out: ". $osrsHandler->resultFormated);
?>
