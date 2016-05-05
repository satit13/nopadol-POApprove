<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<link rel="stylesheet" href="css/style.css">
<title>ReOrder Programs</title>
</head>
<body>

<div data-role="page"  id="pagetwo" data-dialog="true" style="width: 100%;">
  <div data-role="header" style="vertical-align: middle; padding: 0;" id="header">
  <a href="logout.php" class="ui-btn ui-corner-all ui-icon-power ui-btn-icon-notext ui-btn-right" style="margin-top: 0.8%; margin-right: 1%;"></a>
   <!--<a href="setting/setting.php" class="ui-btn ui-corner-all ui-icon-gear ui-btn-icon-notext ui-btn-left" style="margin-top: 0.8%; margin-left: 1%;"></a>!-->
  </div>


  <div data-role="main" class="ui-content" style="width: 90%; margin:auto;">
  <div style="width: 50%:;">
 </br></br></br></br> <h1 class="expert">กรุณาเลือก expertTeam ที่ต้องการ</h1><hr class="hr">
<?php
$myfile = fopen("setting/detail.txt","r") or die("Unable to open file!");
$urldetail = fgets($myfile);
fclose($myfile);

$server1 = fopen("setting/server.txt","r") or die("Unable to open file!");
$urlserver = fgets($server1);
fclose($server1);


$cate = trim($_SESSION['expertTeam']);
if($cate != "CATDR"){
  echo "<script>window.location='Po_all.php'</script>";
}else{
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

      $userID = trim($_SESSION['userID']);
      $expertTeam=trim($_SESSION['expertTeam']);
      $levelID = trim($_SESSION['levelID']);      

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
            $Pct=count($sortP['poNo']);
            $cnt=count($result);
            echo "<option value='".$sort['catCode'][$c]."'>".$sort['catCode'][$c]." (".$Pct.")</option>";

          }
        echo "</select>";
  echo "<a href='logout.php'><button class='ui-btn ui-icon-power ui-btn-icon-left'>จบการทำงาน</button></a>";
    echo "</div>";
}
    ?>
  </div>
<script>
  function select_cate(cate){
   window.location="PO_all.php?cate="+cate.value;    
  }

</script>
</div>
</body>
</html>