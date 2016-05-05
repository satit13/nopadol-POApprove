<?php
$myfile = fopen("setting/detail.txt","r") or die("Unable to open file!");
$urldetail = fgets($myfile);
fclose($myfile);

$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);

$data = array (
      "userID"=>$userID,
      "userCat"=>$cate,
      "levelID"=>$levelID,
      "apCode"=>$_GET['search']
      );
    // json encode data
    $data_string = json_encode($data); 
    // the token
    $token = 'your token here';
    // set up the curl resource
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$urlserver.$urldetail);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string)                                                                       
    ));       
    // execute the request
    $output = curl_exec($ch);
    // output the profile information - includes the header
    //echo $output;
    //$sub = substr($output,9);
    $PO = "[";
    $sub = explode(":[",$output);
    $PO .= substr($sub[1],0,-1);
    ?>