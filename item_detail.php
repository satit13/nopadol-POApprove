<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="css/jquery.mobile-1.4.5.css">
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery.mobile-1.4.5.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>


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
  $('#loading').fadeOut('slow');
});
</script>

</head>
<body>

<div id="loading"></div>
<?php $item_code =$_GET['itemcode'];
$cate =$_GET['cate'];
$po_no= $_GET['pono'];
?>
<div data-role="page">
  <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
    <div class="user"><?php echo $_COOKIE['userID'].":".$_COOKIE['expertTeam']; ?></div>
 <!--<a href='list.php' class="ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext" style="margin-top: 0.8%; margin-left: 1%;"></a>!-->
  <?php echo "<a href='#' onClick='window.location=\"Po_all.php?cate=".$cate."#pagetwo".$po_no."\"' class='ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext' style='margin-top: 0.8%; margin-left: 1%;'></a>";
 ?>
  <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
   <!--<a href="setting/setting.php" class="ui-btn ui-corner-all ui-icon-gear ui-btn-icon-notext ui-btn-left" style="margin-top: 0.8%; margin-left: 1%;"></a>!-->
  </div>

  <div data-role="main" class="ui-content">


<?php

//echo "<meta charset='utf-8'>";
$myfile = fopen("setting/listorder.txt","r") or die("Unable to open file!");
$urldetail = fgets($myfile);
fclose($myfile);

$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);


$data = array (
      "profit"=>"s01",
      "expertTeam"=>$cate,
      "poNo"=>$po_no,
      "itemCode"=>$item_code
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
    $outlist = curl_exec($ch);
    // output the profile information - includes the header
    //echo $output;
    //$sub = substr($output,9);
    $list = "[";
    $sub = explode("GMT",$outlist);
    $list .= trim($sub[1])."]";
   // $list = "[".$outlist."]";


    //echo $list;
  //echo "<script>alert($iCode)</script>";
       /*echo $list."<br>";
        echo $iCode."<br>";
        echo $no."<br>";
        echo $cate;*/
     $out_l=json_decode($list,true);
        //echo $out_l;
        $listpo = array();
        
        //$Dcnt=0;
        foreach ($out_l as $row) {
          $listpo[$row['itemCode']]['itemCode'] = $row['itemCode'];
          $listpo[$row['itemCode']]['itemName'] = $row['itemName'];
          $listpo[$row['itemCode']]['unitCode'] = $row['unitCode'];
          $listpo[$row['itemCode']]['defSaleUnit'] = $row['defSaleUnit'];
          $listpo[$row['itemCode']]['defBuyUnit'] = $row['defBuyUnit'];
          $listpo[$row['itemCode']]['poNo'] = $row['poNo'];
          $listpo[$row['itemCode']]['itemStatus'] = $row['itemStatus'];
          $listpo[$row['itemCode']]['gp'] = $row['gp'];
          $listpo[$row['itemCode']]['saleAmount'] = $row['saleAmount'];
          $listpo[$row['itemCode']]['reqQty'] = $row['reqQty'];
          $listpo[$row['itemCode']]['adjustQty'] = $row['adjustQty'];
          $listpo[$row['itemCode']]['approveQty'] = $row['approveQty'];
          $listpo[$row['itemCode']]['grade'] = $row['grade'];
          $listpo[$row['itemCode']]['s01RemainQty'] = $row['s01RemainQty'];
          $listpo[$row['itemCode']]['s02RemainQty'] = $row['s02RemainQty'];
          $listpo[$row['itemCode']]['s01WH'] = $row['s01WH'];
          $listpo[$row['itemCode']]['s02WH'] = $row['s02WH'];
          $listpo[$row['itemCode']]['s01RemainInQty'] = $row['s01RemainInQty'];
          $listpo[$row['itemCode']]['s02RemainInQty'] = $row['s02RemainInQty'];
          $listpo[$row['itemCode']]['s01Sale'] = $row['s01Sale'];
          $listpo[$row['itemCode']]['s02Sale'] = $row['s02Sale'];
          $listpo[$row['itemCode']]['s01AvgSale'] = $row['s01AvgSale'];
          $listpo[$row['itemCode']]['s02AvgSale'] = $row['s02AvgSale'];
          $listpo[$row['itemCode']]['s01BillMonth'] = $row['s01BillMonth'];
          $listpo[$row['itemCode']]['s02BillMonth'] = $row['s02BillMonth'];
          //$Dcnt+=1;
          
        }
          $listpo = array_values($listpo);
              $listsort = array();
              foreach ($listpo as $k => $v) {
              $listsort['itemCode'][$k] = $v['itemCode']; 
              $listsort['itemName'][$k] = $v['itemName'];
              @$listsort['unitCode'][$k] = $v['unitCode'];
              @$listsort['defSaleUnit'][$k] = $v['defSaleUnit'];
              @$listsort['defBuyUnit'][$k] = $v['defBuyUnit'];
              @$listsort['poNo'][$k] = $v['poNo'];
              @$listsort['itemStatus'][$k] = $v['itemStatus'];
              @$listsort['gp'][$k] = $v['gp'];
              @$listsort['saleAmount'][$k] = $v['saleAmount'];
              @$listsort['reqQty'][$k] = $v['reqQty'];
              @$listsort['adjustQty'][$k] = $v['adjustQty'];
              @$listsort['approveQty'][$k] = $v['approveQty'];
              @$listsort['grade'][$k] = $v['grade'];
              @$listsort['s01RemainQty'][$k] = $v['s01RemainQty'];
              @$listsort['s02RemainQty'][$k] = $v['s02RemainQty'];
              @$listsort['s01WH'][$k] = $v['s01WH'];
              @$listsort['s02WH'][$k] = $v['s02WH'];
              @$listsort['s01RemainInQty'][$k] = $v['s01RemainInQty'];
              @$listsort['s02RemainInQty'][$k] = $v['s02RemainInQty'];
              @$listsort['s01Sale'][$k] = $v['s01Sale'];
              @$listsort['s02Sale'][$k] = $v['s02Sale'];
              @$listsort['s01AvgSale'][$k] = $v['s01AvgSale'];
              @$listsort['s02AvgSale'][$k] = $v['s02AvgSale'];
              @$listsort['s01BillMonth'][$k] = $v['s01BillMonth'];
              @$listsort['s02BillMonth'][$k] = $v['s02BillMonth'];
            }
  echo '<h1 class="title_item">แสดงรายละเอียดสินค้า '.$listsort['itemName'][0].'</h1>';
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
                      $("#ts1").click(function(){
                          $("#s1").slideToggle("slow");
                      });
                      $("#ts2").click(function(){
                          $("#s2").slideToggle("slow");
                      });
                  });
                </script>';
        echo "<a href='#' id='ts1'><b><font color='red'>".number_format($listsort['s01RemainQty'][0])."</font></b></a><div id='s1' style='display:none;'><hr><table><tr style='background-color:#9f9f9f;'><th>คลัง</th><th>คงเหลือ</th></tr>";
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
        echo "<td><a href='#' id='ts2'><b><font color='red'>".number_format($listsort['s02RemainQty'][0])."</font></b></a><div id='s2' style='display:none;'><hr><table><tr style='background-color:#9f9f9f;'><th>คลัง</th><th>คงเหลือ</th></tr>";
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
<div data-role="footer" data-position="fixed" id="footer" style="text-align: center;">
    
  </div>
</div>

</body>
</html>






