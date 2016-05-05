<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login PO Approve</title>
</head>

<body>
<?php 


	setcookie('userID', "",time()- 3600);
	setcookie('userName', "",time()- 3600);
	setcookie('levelID', "",time()- 3600);
	setcookie('expertTeam', "",time()- 3600);
	setcookie('status', "0",time()- 3600);
	session_destroy();
?>
<script>alert("ออกจากระบบ");
window.location='index.php'</script>
</body>
</html>