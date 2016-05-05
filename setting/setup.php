
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
	
$server = $_POST['server'];
$fpserver = fopen("server.txt","w");

$apilogin = $_POST['apilogin'];
$fplogin = fopen("login.txt","w");

$apiexpert = $_POST['apiexpert'];
$fpexpert = fopen("expert.txt","w");

$apidetail = $_POST['apidetail'];
$fpdetail = fopen("detail.txt","w");

$apipodetail = $_POST['apipodetail'];
$fppodetail = fopen("podetail.txt","w");




fputs($fpserver,$server);
fputs($fplogin,$apilogin);
fputs($fpexpert,$apiexpert);
fputs($fpdetail,$apidetail);
fputs($fppodetail,$apipodetail);


fclose($fpserver);
fclose($fplogin);
fclose($fpexpert);
fclose($fpdetail);
fclose($fppodetail);

}
?>
<script>
window.location="setting.php"
</script>



</body>
</html>