<?php if(empty($_COOKIE['userName']) || $_COOKIE['status']==0){echo "<script>window.location='index.php'</script>";}
else{ 
if(isset($_COOKIE['loginstatus'])){echo $_COOKIE['loginstatus'];
setcookie('loginstatus', "",time() - 3600);
}
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">-->
<link rel="stylesheet" href="../css/jquery.mobile-1.4.5.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<link rel="stylesheet" href="../css/style.css">

</head>
<body>

<div data-role="page" id="pageone" data-theme="a">

  <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
 <!--<a href="#" class="ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext" style="margin-top: 0.8%; margin-left: 1%;"></a>-->
 	<a href="../Po_all.php" class="ui-btn ui-corner-all ui-icon-back ui-btn-icon-notext ui-btn-left" style="margin-top: 0.8%; margin-left: 1%;"></a>
  <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
  </div>

<!--////////////////////////////  content ////////////////////////////////!-->
<div class="ui-content">
<?php
$server1 = fopen("server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);

$myfile1 = fopen("login.txt","r") or die("Unable to open file!");
$urllogin = fgets($myfile1);
fclose($myfile1);

$myfile2 = fopen("expert.txt","r") or die("Unable to open file!");
$urlexpert = fgets($myfile2);
fclose($myfile2);


$myfile3 = fopen("detail.txt","r") or die("Unable to open file!");
$urldetail = fgets($myfile3);
fclose($myfile3);


$myfile4 = fopen("podetail.txt","r") or die("Unable to open file!");
$urlpodetail = fgets($myfile4);
fclose($myfile4);


?>
<h1 class="head">Setting</h1>
<hr class="hr">
<div class="form_set">
<!--=================================================queuecount==============================================-->
<FORM action="setup.php" method="POST">

 <label for="fullname">link ของ server: </label>
 <input type="text" name="server" placeholder="URL server" value="<?php echo $urlserver?>">
 
 <label for="fullname">link ของ login: </label>
 <input type="text" name="apilogin" placeholder="URL login" value="<?php echo $urllogin?>">
      
 <label for="fullname">link ของ expertteam: </label>
 <input type="text" name="apiexpert" placeholder="URL expert" value="<?php echo $urlexpert?>">
      
 <label for="fullname">link ของ apiDetail: </label>
 <input type="text" name="apidetail" placeholder="URL detail" value="<?php echo $urldetail?>">
      
  <label for="fullname">link ของ apiPODetail: </label>
 <input type="text" name="apipodetail" placeholder="URL PO" value="<?php echo $urlpodetail?>">
      
 


<hr class="hr">
<input type="submit" value="ตกลง" data-inline="true" class="accept"/>
<input type="reset" value="cancel"  data-inline="true" class="ignore"></button>

</FORM>
</div>
</div>
</div>  
</body>
</html>
<?php }?>