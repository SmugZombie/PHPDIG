<?PHP
header('Access-Control-Allow-Origin: *'); 
header("Content-type: text/javascript");
$ip = $_GET['ip'];
echo get_provider($ip);

function get_provider($ip){
	//This requires the server to have WHOIS installed
	$output = shell_exec("whois -h whois.cymru.com ' -h $ip '");
	$chunks = explode("|", $output);
	$asn = str_replace("AS Name", "AS", trim($chunks[2]));
	$asn =preg_replace('/\s+/', '', $asn);
	$link = "http://whois.arin.net/rest/asn/$asn/pft";
	$provider = trim($chunks[4]);
	$isp = $asn.$provider;

	echo '{"asn":"'.$asn.'","provider":"'.$provider.'","link":"'.$link.'"}';
}

?>
