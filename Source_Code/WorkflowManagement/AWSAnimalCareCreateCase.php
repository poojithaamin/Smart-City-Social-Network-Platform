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
   'pro_uid'   => '',
   'tas_uid'   => '',
   'variables' => $aCaseVars
);
$pmServer = "http://ec2-54-186-44-218.us-west-2.compute.amazonaws.com"; 
$accessToken = "";
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
