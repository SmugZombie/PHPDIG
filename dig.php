<?php
$domain = $_GET['query'];
if($domain == ""){$domain = "digdns.com";}
header('Content-Type: application/json');
$resultsoa = dns_get_record($domain, DNS_SOA); $resultns = dns_get_record($domain, DNS_NS); 
$resulta = dns_get_record($domain, DNS_A); $resultmx = dns_get_record($domain, DNS_MX); 
$resultaaaa = dns_get_record($domain, DNS_AAAA); $resulttxt = dns_get_record($domain, DNS_TXT); 
$resultsrv = dns_get_record($domain, DNS_SRV); $resultcname = dns_get_record($domain, DNS_CNAME); 
$host = 0;
echo '{"dig":[';
getResults($resulta);
getResults($resultsoa);
getResults($resultns);
getResults($resultmx);
getResults($resultaaaa);
getResults($resulttxt);
getResults($resultsrv);
getResults($resultcname);
if($host == 0){ echo ']}'; return; }
$output = substr($output, 0, -2);
echo $output.']}';

function getResults($result){
global $host, $output;
$i = 0; $max = count($result);
while($i < $max)
	{
		$get_host = $result[$i]['host'];
		$get_type = $result[$i]['type'];
		$get_target = $result[$i]['target'];
		$get_ipv4 = $result[$i]['ip'];
		$get_ipv6 = $result[$i]['ipv6'];
		$get_class = $result[$i]['class'];
		$get_ttl = $result[$i]['ttl'];
		$get_mname = $result[$i]['mname'];
		$get_rname = $result[$i]['rname'];
		$get_serial = $result[$i]['serial'];
		$get_refresh = $result[$i]['refresh'];
		$get_retry = $result[$i]['retry'];
		$get_expires = $result[$i]['expires'];
		$get_txt = $result[$i]['txt'];
		if($get_host != ""){$get_host = $get_host.".";}

		$output .= '{"Record":"'.$get_type.'", 
			"Host":"'.$get_host.'", 
			"Target":"'.$get_target.'", 
			"IPv4":"'.$get_ipv4.'", 
			"IPv6":"'.$get_ipv6.'", 
			"Class":"'.$get_class.'", 
			"TTL":"'.$get_ttl.'", 
			"Mname":"'.$get_mname.'", 
			"Rname":"'.$get_rname.'", 
			"Serial":"'.$get_serial.'", 
			"Refresh":"'.$get_refresh.'", 
			"Retry":"'.$get_retry.'", 
			"Expires":"'.$get_expires.'", 
			"Txt":"'.$get_txt.'"}, ';
		$i++;
		if($get_host != "" && $get_host != "."){$host ++;}
	}
}
?>
