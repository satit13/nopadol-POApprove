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
  }

/*
  echo "<br>".$userID;
  echo "<br>".$levelID;
  echo "<br>".$experTeam;*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">-->
<link rel="stylesheet" href="css/jquery.mobile-1.4.5.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<link rel="stylesheet" href="css/style.css">

</head>
<body>

<div data-role="page" id="pageone">

   <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
 <!--<a href='list.php' class="ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext" style="margin-top: 0.8%; margin-left: 1%;"></a>!-->
  <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
   <!--<a href="setting/setting.php" class="ui-btn ui-corner-all ui-icon-gear ui-btn-icon-notext ui-btn-left" style="margin-top: 0.8%; margin-left: 1%;"></a>!-->
  </div>

<!--////////////////////////////  content ////////////////////////////////!-->
<div class="ui-content">
<div class='head'></div>
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
        echo "<h1 class='expert'>กรุณาเลือก expertTeam ที่ต้องการ</h1><hr class='hr'>";
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
  <form>        
    <td align="right" width="80%"><div class='line'><input type="search" name="search" data-role="none" data-shadow="true" placeholder="NO apCode (รหัสเจ้าหนี้)" style="height: 35px; width: 80%; border-radius: 9px; display: block;"></div></td>
    <td align="left" width="20%"><button type="submit" data-inline="true" data-mini="true">Search</button></td>
  </form>   
</tr></table>

<div class="ui-grid-solo">

<?php
if(empty($_GET['search'])){
    $_GET['search']="";
}

require("require/connect_apiDetail.php");
if($PO=="[]"){

echo "<div style='width:100%; text-align:center;'><h1>ไม่มีข้อมูล".$cate."</h1></div>";

}
//////////////////////////////////////////////////////////////////////////////////////////////////
$out_w=json_decode($PO,true);

$result = array();
$all_prouct="";
$all_tableP="";
$SumPrice=0;
foreach ($out_w as $row) {
  $result[$row['poNo']]['poNo'] = $row['poNo'];
  $result[$row['poNo']]['apCode'] = $row['apCode'];
  $result[$row['poNo']]['apName'] = $row['apName'];
  $result[$row['poNo']]['poAmount'] = $row['poAmount'];
  
}
  $result = array_values($result);
      $sort = array();
      foreach ($result as $k => $v) {
    $sort['poNo'][$k] = $v['poNo'];
    $sort['apCode'][$k] = $v['apCode'];
    $sort['apName'][$k] = $v['apName'];
    $sort['poAmount'][$k] = $v['poAmount'];
    }
    //array_multisort($sort['billAmount'],SORT_DESC,$sort['itemName'],SORT_ASC,$result);

    $cnt=count($result);
   /* echo "<script>alert($cnt)</script>"*/;
echo "<form action='approve.php' method='GET'>";
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
         <td width='10%' text-align='left'><div class='icon'><a href='#pagetwo".$sort['poNo'][$i]."' data-transition='slide'><img src='images/icon2.png' width='100%'></a></div></td>
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
</div> 


<?php
 
for($a=0;$a<5;$a++){
   require("require/connect_apiPOdetail.php");

if(isset($sort['poNo'][$a])){$no=$sort['poNo'][$a];}
else{$no="";}

 echo '<div data-role="page" id="pagetwo'.$no.'">'?>
 
 <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
 <a href="#pageone" class="ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext" style="margin-top: 0.8%; margin-left: 1%;"></a>
   <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
  </div>

  <div data-role="main" class="ui-content">
  <div class='head'></div>
    <?php
     $out_w=json_decode($POdetail,true);

        $Dresult = array();
        //$Dcnt=0;
        foreach ($out_w as $row) {
          $Dresult[$row['itemCode']]['itemCode'] = $row['itemCode'];
          $Dresult[$row['itemCode']]['docDate'] = $row['docDate'];
          $Dresult[$row['itemCode']]['apCode'] = $row['apCode'];
          $Dresult[$row['itemCode']]['apName'] = $row['apName'];
          $Dresult[$row['itemCode']]['myDescription'] = $row['myDescription'];
          $Dresult[$row['itemCode']]['docNo'] = $row['docNo'];
          $Dresult[$row['itemCode']]['itemName'] = $row['itemName'];
          $Dresult[$row['itemCode']]['qty'] = $row['qty'];
          $Dresult[$row['itemCode']]['unitCode'] = $row['unitCode'];
          $Dresult[$row['itemCode']]['price'] = $row['price'];
          $Dresult[$row['itemCode']]['discountWord'] = $row['discountWord'];
          $Dresult[$row['itemCode']]['discountAmount'] = $row['discountAmount'];
          $Dresult[$row['itemCode']]['whCode'] = $row['whCode'];
          $Dresult[$row['itemCode']]['shelfCode'] = $row['shelfCode'];
          $Dresult[$row['itemCode']]['netAmount'] = $row['netAmount'];
          $Dresult[$row['itemCode']]['oldPrice'] = $row['oldPrice'];
          $Dresult[$row['itemCode']]['oldDiscountWord'] = $row['oldDiscountWord'];
          //$Dcnt+=1;
          
        }
          $Dresult = array_values($Dresult);
              $deSort = array();
              foreach ($Dresult as $k => $v) {
              $deSort['itemCode'][$k] = $v['itemCode']; 
              $deSort['docDate'][$k] = $v['docDate'];
              $deSort['apCode'][$k] = $v['apCode'];
              $deSort['apName'][$k] = $v['apName'];
              $deSort['myDescription'][$k] = $v['myDescription'];
              @$deSort['docNo'][$k] = $v['docNo'];
              $deSort['itemName'][$k] = $v['itemName'];
              $deSort['qty'][$k] = $v['qty'];
              $deSort['unitCode'][$k] = $v['unitCode'];
              $deSort['price'][$k] = $v['price'];
              $deSort['discountWord'][$k] = $v['discountWord'];
              $deSort['discountAmount'][$k] = $v['discountAmount'];
              $deSort['whCode'][$k] = $v['whCode'];
              $deSort['shelfCode'][$k] = $v['shelfCode'];
              $deSort['netAmount'][$k] = $v['netAmount'];
              $deSort['oldPrice'][$k] = $v['oldPrice'];
              $deSort['oldDiscountWord'][$k] = $v['oldDiscountWord'];
            }
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
        for($f=0;$f<$Dcnt;$f++){
        $SPN += $deSort['netAmount'][$f];
        $SPO += $deSort['oldPrice'][$f];
        }
        echo "<tr><td>ราคารวมใบ PO ใหม่ </td><td colspan='9'>".number_format($SPN,2)." บาท</td></tr>";
        echo "<tr><td>ราคารวมใบ PO เก่า</td><td colspan='9'>".number_format($SPO,2)." บาท</td></tr>";
        echo "</table><hr width='90%'><table data-role='table' class='ui-responsive' id='myTable'>
        <thead>
        <tr>
        <th>รหัสสินค้า</th>
        <th data-priority='9'>ชื่อสิค้า</th>
        <th data-priority='8'>จำนวน</th>
        <th data-priority='7'>ราคา</th>
        <th data-priority='6'>ส่วนลด</th>
        <th data-priority='5'>ส่วนลดเก่า</th>
        <th data-priority='4'>ราคารวม</th>
        <th data-priority='3'>ราคาเก่า</th>
        <th data-priority='2'>คลัง</th>
        <th data-priority='1'>ชั้นเก็บ</th>
        <th>รายละเอียดสินค้า</th>
        </tr>
        </thead>";
       echo "<tbody>";
       // echo $DCt;
       
       for($f=0;$f<$Dcnt;$f++){

        echo "<tr style='border-bottom:1px dashed green; padding-top:5%;'><td>".$deSort['itemCode'][$f]."</td><td>".$deSort['itemName'][$f]."</td><td>".$deSort['qty'][$f]."&nbsp;&nbsp;".$deSort['unitCode'][$f]."</td><td>".number_format($deSort['price'][$f],2)."</td><td>".$deSort['discountWord'][$f]."</td><td>".$deSort['oldDiscountWord'][$f]."</td><td>".number_format($deSort['netAmount'][$f],2)."</td><td>".number_format($deSort['oldPrice'][$f],2)."</td><td>".$deSort['whCode'][$f]."</td><td>".$deSort['shelfCode'][$f]."</td><td align='center'><a href='#pagethree' class='ui-btn ui-btn-inline ui-icon-search ui-btn-icon-notext ui-corner-all ui-shadow'></td></tr>";
        }
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
  <?php
  echo '<div data-role="page" id="pagethree">'?>
 
 <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
 <a href="#pagetwo" class="ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext" style="margin-top: 0.8%; margin-left: 1%;"></a>
   <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
  </div>

  <div data-role="main" class="ui-content">
  <div class='head'></div>
    <?php
     $out_w=json_decode($POdetail,true);

        $Dresult = array();
        //$Dcnt=0;
        foreach ($out_w as $row) {
          $Dresult[$row['itemCode']]['itemCode'] = $row['itemCode'];
          $Dresult[$row['itemCode']]['docDate'] = $row['docDate'];
          $Dresult[$row['itemCode']]['apCode'] = $row['apCode'];
          $Dresult[$row['itemCode']]['apName'] = $row['apName'];
          $Dresult[$row['itemCode']]['myDescription'] = $row['myDescription'];
          $Dresult[$row['itemCode']]['docNo'] = $row['docNo'];
          $Dresult[$row['itemCode']]['itemName'] = $row['itemName'];
          $Dresult[$row['itemCode']]['qty'] = $row['qty'];
          $Dresult[$row['itemCode']]['unitCode'] = $row['unitCode'];
          $Dresult[$row['itemCode']]['price'] = $row['price'];
          $Dresult[$row['itemCode']]['discountWord'] = $row['discountWord'];
          $Dresult[$row['itemCode']]['discountAmount'] = $row['discountAmount'];
          $Dresult[$row['itemCode']]['whCode'] = $row['whCode'];
          $Dresult[$row['itemCode']]['shelfCode'] = $row['shelfCode'];
          $Dresult[$row['itemCode']]['netAmount'] = $row['netAmount'];
          $Dresult[$row['itemCode']]['oldPrice'] = $row['oldPrice'];
          $Dresult[$row['itemCode']]['oldDiscountWord'] = $row['oldDiscountWord'];
          //$Dcnt+=1;
          
        }
          $Dresult = array_values($Dresult);
              $deSort = array();
              foreach ($Dresult as $k => $v) {
              $deSort['itemCode'][$k] = $v['itemCode']; 
              $deSort['docDate'][$k] = $v['docDate'];
              $deSort['apCode'][$k] = $v['apCode'];
              $deSort['apName'][$k] = $v['apName'];
              $deSort['myDescription'][$k] = $v['myDescription'];
              @$deSort['docNo'][$k] = $v['docNo'];
              $deSort['itemName'][$k] = $v['itemName'];
              $deSort['qty'][$k] = $v['qty'];
              $deSort['unitCode'][$k] = $v['unitCode'];
              $deSort['price'][$k] = $v['price'];
              $deSort['discountWord'][$k] = $v['discountWord'];
              $deSort['discountAmount'][$k] = $v['discountAmount'];
              $deSort['whCode'][$k] = $v['whCode'];
              $deSort['shelfCode'][$k] = $v['shelfCode'];
              $deSort['netAmount'][$k] = $v['netAmount'];
              $deSort['oldPrice'][$k] = $v['oldPrice'];
              $deSort['oldDiscountWord'][$k] = $v['oldDiscountWord'];
            }
        //$Dcnt = count($CDresult);
        //echo $Dcnt;
        //echo '<br>'.$Dcnt;
        
        echo "<table class='ui-responsive'>";
        echo "<tr><td align='right'><b>รหัสสินค้า</b></td><td colspan='9'>".$deSort['docNo'][0]."</td></tr>";
        echo "<tr><td align='right'><b>ชื่อสินค้า</b></td><td colspan='9'>".$deSort['apCode'][0]."</td></tr>";
        echo "<tr><td align='right'><b>เลขที่</b></td><td colspan='9'>".$deSort['apName'][0]."</td></tr>";
        echo "<tr><td align='right'><b>สถานะ</b></td><td colspan='9'>".$deSort['docDate'][0]."</td></tr>";
        echo "<tr><td align='right'><b>GP </b></td><td colspan='9'>".$deSort['myDescription'][0]."</td></tr>";
        echo "<tr><td align='right'><b>ยอดเงินสด</b></td><td colspan='9'>".$deSort['docDate'][0]."</td></tr></table><hr width='90%'>";
        
        echo "<table data-role='table' class='ui-responsive' id='myTable'>
        <thead>
        <tr align='right'>
        <th>เสนอซื้อ</th>
        <th>Adjust Qty</th>
        <th>Approve Qty</th>
        <th>เกรด</th>
        <th>คงเหลือ S01</th>
        <th>คงเหลือ S02</th>
        <th>ค้างรับ S01</th>
        <th>ค้างรับ S02</th>
        <th>ขายย้อนหลัง 3 เดือน S01</th>
        <th>ขายย้อนหลัง 3 เดือน S02</th>
        <th>ขายเฉลี่ยต่อเดือนจากยอดย้อนหลัง 3 เดือน S01</th>
        <th>ขายเฉลี่ยต่อเดือนจากยอดย้อนหลัง 3 เดือน S02</th>
        <th>จำนวนบิลต่อเดือน S01</th>
        <th>จำนวนบิลต่อเดือน S02</th>
        </tr>
        </thead>";
       echo "<tbody>";
       // echo $DCt;
        $Dcnt = count($Dresult);
       for($f=0;$f<$Dcnt;$f++){
        echo "<tr style='border-bottom:1px dashed green; padding-top:5%;'><td>".$deSort['itemCode'][$f]."</td><td>".$deSort['itemName'][$f]."</td><td>".$deSort['qty'][$f]."&nbsp;&nbsp;".$deSort['unitCode'][$f]."</td><td>".number_format($deSort['price'][$f],2)."</td><td>".$deSort['discountWord'][$f]."</td><td>".$deSort['oldDiscountWord'][$f]."</td><td>".number_format($deSort['netAmount'][$f],2)."</td><td>".number_format($deSort['oldPrice'][$f],2)."</td><td>".$deSort['whCode'][$f]."</td><td>".$deSort['shelfCode'][$f]."</td><td>".$deSort['shelfCode'][$f]."</td><td>".$deSort['shelfCode'][$f]."</td><td>".$deSort['shelfCode'][$f]."</td><td>".$deSort['shelfCode'][$f]."</td></tr>";
        }
        echo "</tbody></table>";
    $doc=$deSort['docNo'][0];
    $ap=$deSort['apCode'][0];
    ?>
        
  </div>
</div>


<?php
  }
}
?>

</body>
</html>