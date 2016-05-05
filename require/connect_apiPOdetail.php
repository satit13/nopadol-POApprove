<?php
$myfile = fopen("setting/podetail.txt","r") or die("Unable to open file!");
$urlpodetail = fgets($myfile);
fclose($myfile);

$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);


if(isset($sort['poNo'][$a])){$detail=$sort['poNo'][$a];}

$data = array (
      "search"=> $detail,
      );

    // json encode data
    $data_string = json_encode($data); 
    // the token
    $token = 'your token here';
    // set up the curl resource
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$urlserver.$urlpodetail);
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
    $POdetail = "[";
    $sub = explode(":[",$output);
    $POdetail .= substr($sub[1],0,-1);
    /*echo $POdetail;

      $out_w=json_decode($POdetail,true);

        $result = array();
        $SumPrice=0;
        foreach ($out_w as $row) {
          $result[$row['itemCode']]['itemCode'] = $row['itemCode'];
          /*$result[$row['itemCode']]['docDate'] = $row['docDate'];
          $result[$row['itemCode']]['apCode'] = $row['apCode'];
          $result[$row['docNo']]['apName'] = $row['apName'];
          $result[$row['docNo']]['myDescription'] = $row['myDescription'];*/
          //$result[$row['itemCode']]['docNo'] = $row['docNo'];
          /*$result[$row['docNo']]['itemName'] = $row['itemName'];
          $result[$row['docNo']]['qty'] = $row['qty'];
          $result[$row['docNo']]['unitCode'] = $row['unitCode'];
          $result[$row['docNo']]['price'] = $row['price'];
          $result[$row['docNo']]['discountWord'] = $row['discountWord'];
          $result[$row['docNo']]['discountAmount'] = $row['discountAmount'];
          $result[$row['docNo']]['whCode'] = $row['whCode'];
          $result[$row['docNo']]['shelfCode'] = $row['shelfCode'];
          $result[$row['docNo']]['netAmount'] = $row['netAmount'];
          $result[$row['docNo']]['oldPrice'] = $row['oldPrice'];
          $result[$row['docNo']]['oldDiscountWord'] = $row['oldDiscountWord'];*/
          //$SumPrice+=1;
          
        /*}
          $result = array_values($result);
              $deSort = array();
              foreach ($result as $k => $v) {
              $deSort['itemCode'][$k] = $v['itemCode'];
              /*$deSort['docDate'][$k] = $v['docDate'];
              $deSort['apCode'][$k] = $v['apCode'];
              $deSort['apName'][$k] = $v['apName'];
              $deSort['myDescription'][$k] = $v['myDescription'];*/
              //@$deSort['docNo'][$k] = $v['docNo'];
              /*$deSort['itemName'][$k] = $v['itemName'];
              $deSort['qty'][$k] = $v['qty'];
              $deSort['unitCode'][$k] = $v['unitCode'];
              $deSort['price'][$k] = $v['price'];
              $deSort['discountWord'][$k] = $v['discountWord'];
              $deSort['discountAmount'][$k] = $v['discountAmount'];
              $deSort['whCode'][$k] = $v['whCode'];
              $deSort['shelfCode'][$k] = $v['shelfCode'];
              $deSort['netAmount'][$k] = $v['netAmount'];
              $deSort['oldPrice'][$k] = $v['oldPrice'];
              $deSort['oldDiscountWord'][$k] = $v['oldDiscountWord'];*/
            //}

           // array_multisort($deSort['itemCode'],SORT_ASC,$result);
        //$Dcnt = count($CDresult);
        //echo $Dcnt;
       // echo "<meta charset='utf-8'>";
        //*echo '<br>'.$SumPrice;
        //echo "<table border='1' width='100%'>";
        //echo "<tr><td>เลขที่ PO</td><td colspan='9'>".$deSort['docNo'][0]."</td></tr>";
        /*echo "<tr><td>รหัสเจ้าหนี้</td><td colspan='9'>".$deSort['apCode'][0]."</td></tr>";
        echo "<tr><td>ชื่อเจ้าหนี้</td><td colspan='9'>".$deSort['apName'][0]."</td></tr>";
        echo "<tr><td>วันที่</td><td colspan='9'>".$deSort['docDate'][0]."</td></tr>";
        echo "<tr><td>MyDescription</td><td colspan='9'>".$deSort['myDescription'][0]."</td></tr>";
        echo "<tr><th>IC</th><th>IN</th><th>QU</th><th>Pr</th><th>Dis</th><th>OD</th><th>NA</th><th>OP</th><th>Wh</th><th>Sh</th></tr>";*/
       // echo $DCt;
       // $DCt = count($result);
      // for($x=0;$x<$DCt;$x++){
        /*echo "<tr><td>".$deSort['itemcode'][$f]."</td><td>".$deSort['itemName'][$f]."</td><td>".$deSort['qty'][$f]."&nbsp;&nbsp;".$deSort['unitCode'][$f]."</td><td>".$deSort['price'][$f]."</td><td>".$deSort['discountWord'][$f]."</td><td>".$deSort['oldDiscountWord'][$f]."</td><td>".$deSort['netAmount'][$f]."</td><td>".$deSort['oldPrice'][$f]."</td><td>".$deSort['whCode'][$f]."</td><td>".$deSort['shelfCode'][$f]."</td></tr>";*/
       // echo "<br >".$deSort['itemCode'][$x];


       // }
       // echo "</table>";
    ?>