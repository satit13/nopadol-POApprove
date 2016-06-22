<?php 
if(isset($_COOKIE['userName'])){
//echo $_COOKIE['userID'];
//echo $_COOKIE['userName'];
//echo $_COOKIE['levelID'];
//echo $_COOKIE['expertTeam'];
//echo $_COOKIE['status'];

}
//if(isset($_COOKIE['loginstatus'])){echo $_COOKIE['loginstatus'];
//setcookie('loginstatus', "",time() - 3600);

//}
?>
<!DOCTYPE html>
<head>
	<title>Approve PO</title> 
    <meta name="viewport" content="width=device-width,maximum-scale=1.0" />
	<link rel="stylesheet" href="css/style.css" />
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<script>
function cnklogin(){
if(document.forms["login"]["username"].value== "" || document.forms["login"]["username"].value == null){
	alert("กรุณากรอกข้อมูล Username !!");
	document.forms["login"]["username"].focus();
	return false;
	}
	else if(document.forms["login"]["passwd"].value== "" || document.forms["login"]["passwd"].value == null){
	alert("กรุณากรอกข้อมูล Password !!");
	document.forms["login"]["passwd"].focus();
	return false;
	}
	
}
function logout(){
	window.location='logout.php'
	}

</script>
</head>
<body>
<?php if(empty($_COOKIE['userName']) || $_COOKIE['status']==0){
echo '<div id="header"></div>';
?>
  
<!--  <div class="login_container" id='flippr'>

  <h3>Login ระบบจัดการ Category</h3>
  
  <form name="login" method='POST' id="theForm" action="require/connect_apilogin.php" onSubmit="return cnklogin()">
  <div  class="form_login"> <input type='text' id="username" name='username'class="form-control" placeholder='Username'></div>
  <br>
    <div  class="form_login"><input type='password' id='password' name='passwd' class="form-control" placeholder='Password'></div>
      
    <div class='login_bt'>
      <input type='submit' value='Login'>
    </div> 
  </form>
</div>-->


<div id="form-main">

  <div id="form-div">
  <img src="images/approve-icon1.png" class="img ">
    <form class="form" name="login" method='POST' id="theForm" action="check_login.php" onSubmit="return cnklogin()">
      
      <p class="username">
        <input name="username" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Username" id="username" />
      </p>
      
      <p class="email">
        <input name="passwd" type="password" class="validate[required,custom[email]] feedback-input" id="password" placeholder="Password" />
      </p>
      
      
      
      <div class="submit">
        <input type="submit" value="Login" id="button-blue"/>
        <div class="ease"></div>
      </div>
    </form>
    <br>
  </div>
  <?php }
else{
echo '<div id="header">';
echo '<div class="header_right">';
echo '<div class="head_rightlogo"><a href="logout.php"><div class="head_right"></div></div><br class="clear">';
	
	echo $_COOKIE['userID'];
	echo '</div>';
	echo'</a></div>';

	echo '<div id="form-main">

  <div id="form-div">
  <img src="images/approve-icon1.png".png" class="img">
    <form class="form" name="login2" method="POST" id="theForm" action="check_login.php" onSubmit="return cnklogin()">
      <br><br>
      
      <p class="email">
        <input name="passwd" type="password" class="validate[required,custom[email]] feedback-input" id="password" placeholder="Password" />
      </p>
      
      <div class="submit">
        <input type="submit" value="Login" id="button-blue"/>
        <div class="ease"></div>
      </div>
    </form>
    <br><br><br><br><br>
  </div>';

  }
  
  ?>
  
  
</body>
</html>