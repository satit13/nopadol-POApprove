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
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="css/jquery.mobile-1.4.5.css">
<script src="js/jquery.mobile-1.4.5.min.js"></script>

<!--<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<script>
  $(window).load(function() { // makes sure the whole site is loaded
  //$('#status').fadeOut(); // will first fade out the loading animation
  $('#preloader').fadeOut('slow'); // will fade out the white DIV that covers the website.
  $('body').css({
    'overflow': 'visible'
  });
})


</script>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="preloader">
  <div id="status">&nbsp;</div>
</div>


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

echo "<div style='width:100%; text-align:center;'><h1>ไม่มีข้อมูล".$cate."</h1></div>";

}
//////////////////////////////////////////////////////////////////////////////////////////////////

    //array_multisort($sort['billAmount'],SORT_DESC,$sort['itemName'],SORT_ASC,$result);

    $cnt=count($result);
   /* echo "<script>alert($cnt)</script>"*/;
echo "<form action='approve.php' method='GET'>";
echo "<input type='hidden' name='cate' value='".trim($cate)."'>";
echo "<table width='95%'><tr><th></th><th>เลขที่ PO </th><th>ชื่อเจ้าหนี้</th><th align='right'>ราคารวม </th><th></th></tr></table>";
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
 
for($a=0;$a<$cnt;$a++){
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

        echo "<tr style='border-bottom:1px dashed green; padding-top:5%;'><td>".$deSort['itemCode'][$f]."</td><td>".$deSort['itemName'][$f]."</td><td>".$deSort['qty'][$f]."&nbsp;&nbsp;".$deSort['unitCode'][$f]."</td><td>".number_format($deSort['price'][$f],2)."</td><td>".number_format($deSort['oldPrice'][$f],2)."</td><td>".$deSort['discountWord'][$f]."</td><td>".$deSort['oldDiscountWord'][$f]."</td><td>".number_format($deSort['netAmount'][$f],2)."</td><td>".$deSort['whCode'][$f]."</td><td>".$deSort['shelfCode'][$f]."</td><td align='center'><a href='#pagethree".$deSort['itemCode'][$f]."' class='ui-btn ui-btn-inline ui-icon-search ui-btn-icon-notext ui-corner-all ui-shadow'></td></tr>";
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

</div>
</div>
</div> 

<?php
 for($b=0;$b<$Dcnt;$b++){
  require("require/connect_apiPOlist.php");

 
        //$Dcnt = count($CDresult);
        //echo $Dcnt;
        //echo '<br>'.$Dcnt;
        echo "<table class='ui-responsive'>";
        echo "<tr><td><b>รหัสสินค้า</b></td><td colspan='9'>".$listsort['itemCode'][0]."</td></tr>";
        echo "<tr><td><b>ชื่อสินค้า</b></td><td colspan='9'>".$listsort['itemName'][0]."</td></tr>";
        echo "<tr><td>เ<b>ลขที่ PO </b></td><td colspan='9'>".$listsort['poNo'][0]."</td></tr>";
        echo "<tr><td><b>สถานะ</b></td><td colspan='9'>".$listsort['itemStatus'][0]."</td></tr>";
        echo "<tr><td><b>GP </b></td><td colspan='9'>".round($listsort['gp'][0],2)." %</td></tr>";
        echo "<tr><td><b>ราคาขายเงินสด</b></td><td colspan='9'>".number_format($listsort['saleAmount'][0], 2 )." บาท</td></tr>";
        echo "</table><hr width='90%'>";

        echo "<table class='ui-responsive'>";
        echo "<tr><td width='40%' style='text-align:right;'><b>จำนวนเสนอซื้อ</b></td><td>".number_format($listsort['reqQty'][0])." ".$listsort['unitCode'][0]."</td></tr>";        
        echo "<tr><td width='40%' style='text-align:right;'><b>Ajust Qty</b></td> <td>".number_format($listsort['adjustQty'][0])."  ".$listsort['defSaleUnit'][0]."</td></tr>";
        echo "<tr><td width='40%' style='text-align:right;'><b>Approve QTY</b></td><td>".number_format($listsort['approveQty'][0])."  ".$listsort['defBuyUnit'][0]."</td></tr>";
        echo "<tr><td width='40%' style='text-align:right;'><b>เกรด</b></td><td>".$listsort['grade'][0]."</td></tr>";
        echo "<tr><td width='40%' style='text-align:right;'><b>คงเหลือ S1</b></td><td>";

        echo '<script>
                  $(document).ready(function(){
                      $("#ts1'.$iCode.'").click(function(){
                          $("#s1'.$iCode.'").slideToggle("slow");
                      });
                      $("#ts2'.$iCode.'").click(function(){
                          $("#s2'.$iCode.'").slideToggle("slow");
                      });
                  });
                </script>';

        echo "<a href='#' id='ts1".$iCode."'><b><font color='red'>".number_format($listsort['s01RemainQty'][0])."</font></b></a><div id='s1".$iCode."' style='display:none;'><hr><table><tr style='background-color:#9f9f9f;'><th>คลัง</th><th>คงเหลือ</th></tr>";
        $s01wh = $listsort['s01WH'][0];
        $s02wh = $listsort['s02WH'][0];

          $s01 = array();
        
        //$Dcnt=0;
        foreach ($s01wh as $r) {
          $s01[$r['whCode']]['whCode'] = $r['whCode'];
          $s01[$r['whCode']]['qty'] = $r['qty'];
        }
        $s01 = array_values($s01);
              $s01sort = array();
              foreach ($s01 as $k => $v) {
              @$s01sort['whCode'][$k] = $v['whCode']; 
              @$s01sort['qty'][$k] = $v['qty'];
            }
        $cnts1=count($s01);
        for($s1=0;$s1<$cnts1;$s1++){
          if($s01sort['qty'][$s1]!=0){
          echo "<tr style='background-color:#fff;'><td>".$s01sort['whCode'][$s1]."</td><td>".number_format($s01sort['qty'][$s1])."</td></tr>";
          }
        }
        echo "</table></div></td></tr>
        <tr><td width='40%' style='text-align:right;'><b>คงเหลือ S2</b></td>";

        echo "<td><a href='#' id='ts2".$iCode."'><b><font color='red'>".number_format($listsort['s02RemainQty'][0])."</font></b></a><div id='s2".$iCode."' style='display:none;'><hr><table><tr style='background-color:#9f9f9f;'><th>คลัง</th><th>คงเหลือ</th></tr>";
          $s02 = array();
        
        //$Dcnt=0;
        foreach ($s02wh as $r) {
          $s02[$r['whCode']]['whCode'] = $r['whCode'];
          $s02[$r['whCode']]['qty'] = $r['qty'];
        }
        $s02 = array_values($s02);
              $s02sort = array();
              foreach ($s02 as $k => $v) {
              @$s02sort['whCode'][$k] = $v['whCode']; 
              @$s02sort['qty'][$k] = $v['qty'];
            }
        $cnts2=count($s02);
        for($s2=0;$s2<$cnts2;$s2++){
          if($s02sort['qty'][$s2]!=0){
            echo "<tr style='background-color:#fff;'><td>".$s02sort['whCode'][$s2]."</td><td>".number_format($s02sort['qty'][$s2])."</td></tr>";
          }
        }
        echo "</table></div></td></tr>
        <tr><td width='40%' style='text-align:right;'><b>ค้างรับ S1</b></td><td>".number_format($listsort['s01RemainInQty'][0])."</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>ค้างรับ S2</b></td><td>".number_format($listsort['s02RemainInQty'][0])."</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>ขายย้อนหลัง 3 เดือน S1</b></td><td>".number_format($listsort['s01Sale'][0],2)."</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>ขายย้อนหลัง 3 เดือน S2</b></td><td>".number_format($listsort['s02Sale'][0],2)."</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>ขายเฉลี่ยย้อนหลัง 3 เดือน S1</b></td><td>".number_format($listsort['s01AvgSale'][0],2)." %</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>ขายเฉลี่ยย้อนหลัง 3 เดือน S2</b></td><td>".number_format($listsort['s02AvgSale'][0],2)." %</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>จำนวนบิล/เดือน S1</b></td><td>".number_format($listsort['s01BillMonth'][0])."</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>จำนวนบิล/เดือน S2</b></td><td>".number_format($listsort['s02BillMonth'][0])."</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>หน่วยนับสินค้า</b></td><td>".$listsort['unitCode'][0]."</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>หน่วยนับขายสินค้า</b></td><td>".$listsort['defSaleUnit'][0]."</td></tr>
        <tr><td width='40%' style='text-align:right;'><b>หน่วยนับซื้อสินค้า</b></td><td>".$listsort['defBuyUnit'][0]."</td></tr>";
        echo "</table>";       
    ?>
        
  </div>
</div>


</div>
</div>
</div> 

<?php
   } 
  }
}
?>


<div id="loader-wrapper">
    <div id="loader"></div>
</div>
</div>
</body>
</html>