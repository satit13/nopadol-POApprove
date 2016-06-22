<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<link rel="stylesheet" href="css/style.css">
<title>ReOrder Programs</title>
</head>
<body>

<?php
	$myfile = fopen("setting/approve.txt","r") or die("Unable to open file!");
	$urlapprove = fgets($myfile);
	fclose($myfile);

	$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
	$urlserver = fgets($server1);
	fclose($server1);
//echo $_GET['docNo'];
if(isset($_GET['docNo'])){
/*echo $_GET['docNo']."<br>";
echo $_GET['apCode']."<br>";
echo $_GET['userID']."<br>";
echo $_GET['expertTeam'];*/
$docNo=$_GET['docNo'];
$userID=$_GET['userID'];
$expertTeam=$_GET['expertTeam'];
$apCode=$_GET['apCode'];

	
	$data = array (
      "docNo"=>$docNo,
      "userID"=>$userID,
      "expertTeam"=>$expertTeam,
      "apCode"=>$apCode
      );
    // json encode data
    $data_string = json_encode($data); 
    // the token
    $token = 'your token here';
    // set up the curl resource
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$urlserver.$urlapprove);
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
  // echo $output;*/
//echo "<script>".$output."</script>";
echo "<script>alert('อนุมัติรายการเรียบร้อย')</script>";
echo "<script>window.location='Po_all.php?cate=".$_GET['expertTeam']."';</script>";
    
}else if(empty($_GET['select'])){
	echo "<script>alert('กรุณาเลือกรายการที่ต้องการ อนุมัติอย่างน้อย 1 รายการ')</script>";
	//echo "<script>alert(".$_GET['cate'].")</script>";
	echo "<script>window.location='Po_all.php?cate=".$_GET['cate']."';</script>";
	
}
else if(isset($_GET['select'])){
	$cnt=count($_GET['select']);
	for($i=0;$i<$cnt;$i++){
	$pono[]=explode(";",$_GET['select'][$i]);

		$docNo=$pono[$i][0];
		$apCode=$pono[$i][1];
		$userID=$_SESSION['userID'];
		$expertTeam=$_GET['cate'];

		$data = array (
		      "docNo"=>$docNo,
		      "userID"=>$userID,
		      "expertTeam"=>$expertTeam,
		      "apCode"=>$apCode
		      );
		    // json encode data
		    $data_string = json_encode($data); 
		    // the token
		    $token = 'your token here';
		    // set up the curl resource
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL,$urlserver.$urlapprove);//$urlserver.$urldetail);
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
		   //echo $output;*/
   
	}   
	echo "<script>alert('อนุมัติรายการเรียบร้อย')</script>";
	echo "<script>window.location='Po_all.php?cate=".$_GET['cate']."';</script>";

	}		
	
?>
</body>
</html>
