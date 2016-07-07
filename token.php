<?php session_start();?>
<!DOCTYPE html>
<html>
<head>

  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width,maximum-scale=1.0" /> 
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/style.css" /> 
  <link rel="stylesheet" href="css/jquery.mobile-1.4.5.css" /> 
  
  <meta charset="utf-8">
        <title>Admin Tools</title>
        <script>
function cnklogin(){
if(document.forms["login"]["user"].value== "" || document.forms["login"]["user"].value == null){
	alert("กรุณากรอกข้อมูล Username !!");
	document.forms["login"]["user"].focus();
	return false;
	}
	else if(document.forms["login"]["passwd"].value== "" || document.forms["login"]["passwd"].value == null){
	alert("กรุณากรอกข้อมูล Password !!");
	document.forms["login"]["passwd"].focus();
	return false;
	}
	
}
</script>
</head>
<body>
<?php
 if(isset($_COOKIE['loginadmin'])){
              echo $_COOKIE['loginadmin'];
    //          unset($_COOKIE['loginadmin']);
    setcookie('loginadmin', "0",time()- 3600);
          }
     ?>
<div id="header"></div>
<div id="form-main">

  <div id="form-div">
  <img src="images/Settings-icon.png" class="logo">
    <form class="form" name="login" method='POST' id="theForm" action="#" onSubmit="return cnklogin()">
      
      <p class="username">
        <input name="user" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Username" id="username" />
      </p>
      
      <p class="email">
        <input name="passwd" type="password" class="validate[required,custom[email]] feedback-input" id="password" placeholder="Password" />
      </p>
      
      
      
      <div class="submit">
        <input type="submit" value="LOGIN" class="button-green"/>
        <div class="ease"></div>
      </div>
    </form>
    <br>
  </div>



<?php 
if(isset($_POST['user'])){
$user=$_POST['user'];
$pass=$_POST['passwd'];
if(isset($_COOKIE['token'])){
$token="get_from_cookie";
}else{$token="get_from_api";}
//ได้รับจาก cookie แล้วส่งเข้าไปยัง api  เพื่อ login ถ้าผ่านก็ได้ cookie จะเก็บไว้ 1 วัน หลังจากนั้นรับ token ใหม่ 
//

if($user=="admin" && $pass=="[vdw,jwfh"){
setcookie('loginadmin', "<script language='javascript'>alert('ยินดีต้อนรับ Admin เข้าสู้ระบบ')</script>",time()+3600);
	echo "<script>window.location='register_form.php'</script>";
	$_SESSION['register_type']="admin";
}else{

setcookie('loginadmin', "<script language='javascript'>alert('Username หรือ Password  ไม่ถูกต้อง')</script>",time()+3600);
	echo "<script>window.location='login_register.php'</script>";
	$_SESSION['register_type']=null;
}
}

?>
</body>
</html>
