<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php /*setcookie("result", "<script language='javascript'>alert('$_POST[username]')</script>",time()+3600); 
	echo "<script>window.location='index.php'</script>";*/

$myfile = fopen("setting/login.txt","r") or die("Unable to open file!");
$urllogin = fgets($myfile);
fclose($myfile);

$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);

if(empty($_POST['username'])){$username=$_COOKIE['userID'];}else{$username=$_POST['username'];}

if(isset($_POST['passwd'])){$passwd=$_POST['passwd'];}
else if(isset($_POST['passwd2'])){$passwd=$_POST['passwd2'];}
	
$data = array (
	"userID" => $username,
	"pwd" => $passwd
	);


// json encode data
$data_string = json_encode($data); 
// the token
$token = 'your token here';
// set up the curl resource
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$urlserver.$urllogin);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string)                                                                       
));       

$output = curl_exec($ch);
$out=json_decode($output,true);
$cnt=count($output);

if($out["resp"]["success"]=="1"){

setcookie('userID', $out['userID'],time()+3600*24*356);
setcookie('userName', $out['userName'],time()+3600*24*356);
setcookie('levelID', $out['levelID'],time()+3600*24*356);
setcookie('expertTeam', $out['expertTeam'],time()+3600*24*356);
setcookie('status', "1",time()+3600*24*356); 

//echo "<script>alert('Login สำเร็จ')</script>";

echo "<script>window.location='PO_all.php'</script>";

}else if($out["resp"]["success"]==""){
	if(empty($_COOKIE['userID'])){
	setcookie('userID', "",time()+3600*24*356);
	setcookie('userName', "",time()+3600*24*356);
	setcookie('levelID', "",time()+3600*24*356);
	setcookie('expertTeam', "",time()+3600*24*356);
	setcookie('status', "0",time()+3600*24*356); 
	setcookie('loginstatus', "<script language='javascript'>alert('Login ไม่สำเร็จ กรุณาตรวจสอบ Username และ Password อีกครั้ง1')</script>",time()+3600);
	}else{
	setcookie('userID', $_COOKIE['userID'],time()+3600*24*356);
	setcookie('userName', $_COOKIE['userName'],time()+3600*24*356);
	setcookie('levelID', $_COOKIE['levelID'],time()+3600*24*356);
	setcookie('expertTeam', $_COOKIE['expertTeam'],time()+3600*24*356);
	setcookie('status', "1",time()+3600*24*356); 
	setcookie('loginstatus', "<script language='javascript'>alert('Login ไม่สำเร็จ กรุณาตรวจสอบ Username และ Password อีกครั้ง2')</script>",time()+3600);
		
		}
		echo "<script>window.location='index.php'</script>";
}


?>
</body>
</html>