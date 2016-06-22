<?php
//echo "<meta charset='utf-8'>";
$myfile = fopen("setting/listorder.txt","r") or die("Unable to open file!");
$urldetail = fgets($myfile);
fclose($myfile);

$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);

if(isset($deSort['itemCode'][$b])){$listD=$deSort['itemCode'][$b];}

$data = array (
      "profit"=>"s01",
      "expertTeam"=>$cate,
      "poNo"=>$no,
      "itemCode"=>$listD
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


     if(isset($deSort['itemCode'][$b])){$iCode=$deSort['itemCode'][$b];}
else{$iCode="";}
  //echo "<script>alert($iCode)</script>";
 echo '<div data-role="page" id="pagethree'.$iCode.'">'?>
 
 <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
 <a href="#pagetwo<?php echo $no; ?>" class="ui-btn ui-corner-all ui-icon-carat-l ui-btn-icon-notext" style="margin-top: 0.8%; margin-left: 1%;"></a>
   <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
  </div>

  <div data-role="main" class="ui-content">
  <div class='head'></div>
       <?php

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
    ?>



