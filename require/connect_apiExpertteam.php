<?php
$myfile = fopen("setting/expert.txt","r") or die("Unable to open file!");
$urlexpert = fgets($myfile);
fclose($myfile);

$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);

    $token = 'your token here';
    // set up the curl resource
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$urlserver.$urlexpert);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
    ));       
    // execute the request
    $output = curl_exec($ch);
    // output the profile information - includes the header
    //echo $output;
    //$sub = substr($output,9);
    $team = "[";
    $sub = explode(":[",$output);
    $team .= substr($sub[1],0,-1);
  //  echo $team;

    ?>