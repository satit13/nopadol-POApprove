<?php
session_start();
$_SESSION['userID']=$_COOKIE['userID'];
$_SESSION['levelID']=$_COOKIE['levelID'];
$_SESSION['expertTeam']=$_COOKIE['expertTeam'];

if(empty($_COOKIE['userName']) || $_COOKIE['status']==0){echo "<script>window.location='index.php'</script>";}
else{ 
  $userID=trim($_SESSION['userID']);
  $levelID=trim($_SESSION['levelID']);

  if(empty($_GET['cate'])){
    $cate=$_SESSION['expertTeam'];
  }else{
    $cate=$_GET['cate'];
    $_SESSION['experTeam']=$_GET['cate'];
  }

/*
  echo "<br>".$userID;
  echo "<br>".$levelID;
  echo "<br>".$experTeam;*/
?>
<!DOCTYPE html>
<html>
<head>
<title>Approve PO</title> 
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="css/jquery.mobile-1.4.5.css">
<script src="js/jquery.mobile-1.4.5.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
<link rel="stylesheet" href="css/style.css">
<script>
  /*$(window).load(function() { // makes sure the whole site is loaded
  //$('#status').fadeOut(); // will first fade out the loading animation
  $('#preloader').fadeOut('slow'); // will fade out the white DIV that covers the website.
  $('body').css({
    'overflow': 'visible'
  });
})
$(window).ready(function() {
    $('#loading').hide();
});*/
$(document).ready(function () {
  $('#loading').hide();
});
</script>

</head>
<body>




<div data-role="page" id="pageone">


   <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
 <!--<a href='list.php' class="ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext" style="margin-top: 0.8%; margin-left: 1%;"></a>!-->
<?php
 if(isset($_GET['search'])){

echo "<a href='#'  onClick='window.location=\"Po_all.php?cate=".$cate."\"'class='ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext' style='margin-top: 0.8%; margin-left: 1%;'></a>";
}?>
  <div class="user"><?php echo $userID.":".$_COOKIE['expertTeam']; ?></div>
  <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
   <!--<a href="setting/setting.php" class="ui-btn ui-corner-all ui-icon-gear ui-btn-icon-notext ui-btn-left" style="margin-top: 0.8%; margin-left: 1%;"></a>!-->
  </div>

<!--////////////////////////////  content ////////////////////////////////!-->
<div class="ui-content">
<div class='head'></div>

<h1 class='expert' style="text-align: center;">กรุณาเลือก expertTeam ที่ต้องการ</h1><hr class='hr'>
<div style="width:50%; margin: auto; text-align: center;">
<?php



$myfile = fopen("setting/detail.txt","r") or die("Unable to open file!");
$urldetail = fgets($myfile);
fclose($myfile);

$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);



require('require/connect_apiExpertteam.php');
  $out_w=json_decode($team,true);

    $result = array();
    $SumPrice=0;
    foreach ($out_w as $row) {
      $result[$row['catCode']]['catCode'] = $row['catCode'];
      
    }
      $result = array_values($result);
          $sort = array();
          foreach ($result as $k => $v) {
        $sort['catCode'][$k] = $v['catCode'];
        }
     $Ct = count($result);
  
  if(trim($_SESSION['expertTeam'])=="CATDR"){
    
  echo "<div  class='Cateselect'>";
        
        echo "<select name='cate' data-native-menu='false' onchange='return select_cate(this)' class='selest_expert'>";
        echo "<option value=''>เลือก ExpertTeam </option>";

        for($c=0;$c<$Ct;$c++){

           $data = array (
              "userID"=>$userID,
              "userCat"=>$sort['catCode'][$c],
              "levelID"=>$levelID,
              "apCode"=>""
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
            //echo $PO;

            $out_w=json_decode($PO,true);
            $result = array();
            foreach ($out_w as $row) {
              $result[$row['poNo']]['poNo'] = $row['poNo'];
              
            }
              $resultP = array_values($result);
                  $sortP = array();
                  foreach ($resultP as $k => $v) {
                $sortP['poNo'][$k] = $v['poNo'];
                }
                //array_multisort($sort['billAmount'],SORT_DESC,$sort['itemName'],SORT_ASC,$result);
                
           if ($_GET['cate'] == trim($sort['catCode'][$c])){ $selected = "selected = 'selected'";}else{ $selected = '';}
            $Pct=count($sortP['poNo']);
            echo "<option value='".$sort['catCode'][$c]."' ".$selected.">  ".$sort['catCode'][$c]." (".$Pct.") </option>";

        }

        echo "</select></div>";
      }
?>

</div>

<script>
  function select_cate(cate){
   
   window.location="Po_all.php?cate="+cate.value;

  }
</script>
<table border="0" style="padding: 0; margin: 0 auto;" width="50%"><tr>
  <form action="<?php echo "Po_all.php?cate=".trim($cate); ?>">        
    <td align="right" width="80%"><div class='line'><input type="search" name="search" data-role="none" data-shadow="true" placeholder="NO apCode (รหัสเจ้าหนี้)" style="height: 35px; width: 80%; border-radius: 9px; display: block;"></div></td>
    <td align="left" width="20%"><button type="submit" data-inline="true" data-mini="true">Search</button></td>
  </form>   
</tr></table>

<div class="ui-grid-solo">

<?php
if(empty($_GET['search'])){
    $_GET['search']="";
}
/*echo $userID."<br>";
echo "team : ".$cate."<br>";
echo $levelID."<br>";
echo "search :".$_GET['search'];*/

require("require/connect_apiDetail.php");
if($PO=="[]"){
if($cate=="CATDR"){

echo "<div style='width:100%; text-align:center;'><h1>กรุณาเลือก cat</h1></div>";
}else{echo "<div class='no_po' style='text-align:center;'><h1>ไม่มีข้อมูลใบ PO ของ ".$cate."</h1></div>";}


}else{
  echo '<h1 class="title_po">แสดงรายการ PO ทั้งหมด</h1>';
//////////////////////////////////////////////////////////////////////////////////////////////////

    //array_multisort($sort['billAmount'],SORT_DESC,$sort['itemName'],SORT_ASC,$result);

    
   /* echo "<script>alert($cnt)</script>"*/;
echo "<form action='approve.php' method='GET'>";
echo "<input type='hidden' name='cate' value='".trim($cate)."'>";
echo "<table width='95%' class='table_head'><tr><th></th><th>เลขที่ PO </th><th>ชื่อเจ้าหนี้</th><th align='right'>ราคารวม </th><th></th></tr></table>";
}

$cnt=count($result);
    for($i=0;$i<$cnt;$i++){

        $str=$sort['apName'][$i];
        if (strlen($str) > 25 ){
                $str=trim(mb_substr($str, 0, 35, 'UTF-8'))."....";
            }   else {
                $str=$str;
            }
      echo "<div class='ui-block-a'>";
        
        echo "<table border='0' style='width:95%; margin-left:2.5%;'><tr>
    <td width='10%' style='padding-left:2%;'><input type='checkbox' name='select[]' id='select' value='".$sort['poNo'][$i].";".$sort['apCode'][$i]."'></td>
        <td width='80%'>

        <div class='No'>".$sort['poNo'][$i]."</div>
        <div class='name'>".$str."</div>".
        "<div class='Price'>".number_format($sort['poAmount'][$i], 2, '.', ',')."&nbsp;</div>

        </td>
         <td width='10%' text-align='left'><div class='icon'><a href='#pagetwo".$sort['poNo'][$i]."' data-transition='slide'><img src='images/icon_b.png' width='100%'></a></div></td>
        </tr></table>";
    echo"</div>";
    }
    ?>
      <div data-role="footer" data-position="fixed" id="footer" style="text-align: center;">
  <?php
    echo "<button type='submit' onclick=\"return confirm('ต้องการอนุมัติใบ PO ที่เลือก ใช่หรือไม่')\">อนุมัติ</button></form>";
  ?>
    
  </div>
</div>


</div>



</div>



<?php
 
for($a=0;$a<$cnt;$a++){
   require("require/connect_apiPOdetail.php");

if(isset($sort['poNo'][$a])){$no=$sort['poNo'][$a];}
else{$no="";}

 echo '<div data-role="page" id="pagetwo'.$no.'">'?>
 
 <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
  <div class="user"><?php echo $userID.":".$_COOKIE['expertTeam']; ?></div>
 <a href="#pageone" class="ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext" style="margin-top: 0.8%; margin-left: 1%;"></a>
   <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
  </div>

  <div data-role="main" class="ui-content">
  <div class='head'></div>
    <?php

    echo '<h1 class="title_po">แสดงรายละเอียด PO เลขที่ '.$deSort['docNo'][0].'</h1>';
   // echo $cnt;
   
        //$Dcnt = count($CDresult);
        //echo $Dcnt;
        //echo '<br>'.$Dcnt;
        

        echo "<table class='ui-responsive'>";
        echo "<tr><td>เลขที่ PO</td><td colspan='9'>".$deSort['docNo'][0]."</td></tr>";
        echo "<tr><td>รหัสเจ้าหนี้</td><td colspan='9'>".$deSort['apCode'][0]."</td></tr>";
        echo "<tr><td>ชื่อเจ้าหนี้</td><td colspan='9'>".$deSort['apName'][0]."</td></tr>";
        echo "<tr><td>วันที่</td><td colspan='9'>".$deSort['docDate'][0]."</td></tr>";
        echo "<tr><td>MyDescription</td><td colspan='9'>".$deSort['myDescription'][0]."</td></tr>";       

        $Dcnt = count($Dresult);
        $SPN = 0;
        $SPO = 0;
        for($l=0;$l<$Dcnt;$l++){
        $SPN += $deSort['netAmount'][$l];
        $SPO += $deSort['oldPrice'][$l];
        }
        echo "<tr><td>ราคารวมใบ PO </td><td colspan='9'>".number_format($SPN,2)." บาท</td></tr>";
        echo "<tr><td>จำนวนสินค้า</td><td colspan='9'>".$Dcnt." รายการ</td></tr>";
        echo "</table><hr width='90%'><table data-role='table' class='ui-responsive' id='myTable'>
        <thead>
        <tr>
        <th>รหัสสินค้า</th>
        <th data-priority='9'>ชื่อสิค้า</th>
        <th data-priority='8'>จำนวน</th>
        <th data-priority='7'>ราคา</th>
        <th data-priority='7'>ราคาซื้อล่าสุด</th>
        <th data-priority='6'>ส่วนลด</th>
        <th data-priority='5'>ส่วนลดเก่า</th>
        <th data-priority='4'>ราคารวม</th>
        <th data-priority='2'>คลัง</th>
        <th data-priority='1'>ชั้นเก็บ</th>
        <th>รายละเอียดสินค้า</th>
        </tr>
        </thead>";
       echo "<tbody>";
       // echo $DCt;
       
       for($f=0;$f<$Dcnt;$f++){

        echo "<tr style='color:#000;border-bottom:1px dashed green; padding-top:5%;'>
        <td>".$deSort['itemCode'][$f]."</td><td>".$deSort['itemName'][$f]."</td>
        <td>".$deSort['qty'][$f]."&nbsp;&nbsp;".$deSort['unitCode'][$f]."</td>
        <td>".number_format($deSort['price'][$f],2)."</td>
        <td>".number_format($deSort['oldPrice'][$f],2)."</td>
        <td>".$deSort['discountWord'][$f]."</td>
        <td>".$deSort['oldDiscountWord'][$f]."</td>
        <td>".number_format($deSort['netAmount'][$f],2)."</td>
        <td>".$deSort['whCode'][$f]."</td>
        <td>".$deSort['shelfCode'][$f]."</td>
        <td align='center'><a href='#'  onClick='window.location=\"item_detail.php?itemcode=".$deSort['itemCode'][$f]."&cate=".$cate.'&pono='.$deSort['docNo'][0]."\"' class='ui-btn ui-btn-inline ui-icon-search ui-btn-icon-notext ui-corner-all ui-shadow'></td></tr>";
        }
       //onclick="return confirm(\'ต้องการลบรูปภาพนี้หรือไม่ ?\');" 
        echo "</tbody></table>";
    $doc=$deSort['docNo'][0];
    $ap=$deSort['apCode'][0];
    ?>
        
  </div>

  <div data-role="footer" data-position="fixed" id="footer" style="text-align: center;">
  <?php
    echo "<a href='approve.php?docNo=$doc&apCode=$ap&userID=$userID&expertTeam=$cate' onclick=\"return confirm('ต้องการอนุมัติใบ $doc ใช่หรือไม่')\"> อนุมัติ </a>";
  ?>
    
  </div>
  </div>

</div>
</div>
</div> 
  </div>
</div>


</div>
</div>
</div> 

<?php
    
  }
}
?>

</div>

<div id="loading"></div>
</body>
</html>