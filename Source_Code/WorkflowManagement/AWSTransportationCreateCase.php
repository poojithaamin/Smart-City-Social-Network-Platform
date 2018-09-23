<?php
$aCaseVars = array(array(
   "DepartmentName"            => $argv[1],            
   "IssueDetail"            => $argv[2],
   "RequesterName"            => $argv[3],
   "RequesterLastName"   =>$argv[4],
   "RequesterEmail" =>$argv[5],	
   "RequestStatus"    => "Pending",
   "RedirectStaffId"  => "None",
   "RerouteDepartment" => "None")                       
);
$aVars = array(
   'pro_uid'   => '4654954805a1c96c6b3ecc2031543887',
   'tas_uid'   => '7368398085a1c96efc4a756074548681',
   'variables' => $aCaseVars
);
$pmServer = "http://ec2-54-186-45-217.us-west-2.compute.amazonaws.com"; 
$accessToken = "03d7891f8f2f3c10e511499ff24b5f35e9e6c351";
$ch = curl_init($pmServer . "/api/1.0/workflow/cases");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aVars));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$aUsers = json_decode(curl_exec($ch));
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
var_dump($aUsers); 
if ($aUsers->status == 200) {
   print "New Case {$aUsers->response->app_number} created.\n";
}
$appid = "{$aUsers->app_uid}";
print "***$appid***";

$ch2 = curl_init($pmServer . "/api/1.0/workflow/cases/$appid/execute-trigger/9236514775a1c9ed7452df0026514966");
curl_setopt($ch2, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $accessToken));
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
$aUsers2 = json_decode(curl_exec($ch2));
$statusCode2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
curl_close($ch2);
var_dump($aUsers2); 
print "$statusCode2";
