<?php
$soap_request  = "<?xml version=\"1.0\"?>\n";
$soap_request .= "<soap:Envelope xmlns:soap=\"http://www.w3.org/2001/12/soap-envelope\" soap:encodingStyle=\"http://www.w3.org/2001/12/soap-encoding\">\n";
$soap_request .= "  <soap:Body xmlns:m=\"http://www.example.org/stock\">\n";
$soap_request .= "    <m:GetStockPrice>\n";
$soap_request .= "      <m:StockName>IBM</m:StockName>\n";
$soap_request .= "    </m:GetStockPrice>\n";
$soap_request .= "  </soap:Body>\n";
$soap_request .= "</soap:Envelope>";

$header = array(
    "Content-type: text/xml;charset=\"utf-8\"",
    "Accept: text/xml",
    "Cache-Control: no-cache",
    "Pragma: no-cache",
    "SOAPAction: \"run\"",
    "Content-length: ".strlen($soap_request),
);

$soap_do = curl_init();
curl_setopt($soap_do, CURLOPT_URL, "http://api.leagues.datawiresport.dev/data-sync?wsdl" );
curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($soap_do, CURLOPT_TIMEOUT,        10);
curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($soap_do, CURLOPT_POST,           true );
curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $soap_request);
curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);
print "Execute Soap".PHP_EOL;
$xmlresponse = curl_exec($soap_do);
var_dump($xmlresponse);
if(curl_exec($soap_do) === false) {
    $err = 'Curl error: ' . curl_error($soap_do);
    curl_close($soap_do);
    print $err;
} else {
    curl_close($soap_do);
    print 'Operation completed without any errors';
}
