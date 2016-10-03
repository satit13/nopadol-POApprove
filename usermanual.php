<?php
require_once('mpdf/mpdf.php');
ob_start();
?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

<style type="text/css">
<!--
@page rotated { size: landscape; }
<style>
.manualimg{
  width: 40%;
  margin-right: 10%;
}
.manualimg3{
  width: 40%;
}

.content-a{
  margin-left: 5%;
}
.content-b{
  margin:0;
  padding:0;
  font-size: 14.5px;
}

#user_manual{
  margin-top: 5%;
  background: #fff;
  border-radius: 9px;
}
.a{
  width:36%; float: left; text-align: right; margin-bottom:1%; margin-top: 1%; padding-right: 3%;
}
.b{
  width: 60%; float:left; text-align: left;  padding-top: 0;
}
</style>
-->
</style>
<!DOCTYPE html>
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

</head>
<body>

  <div data-role="main" class="ui-content" id="user_manual">

       <div style="text-align: center;" class="content-a">  
          <div class="a">
                    <img src="images/pages/login.jpg" class="manualimg">
          </div>
          <div class="b">
                <ul><h3>หน้าจอ Login </h3>
                <li>เข้าใช้งานเว็บไซต์ <a href="http://nopadolais.dyndns.org/apppo/" style="color: #000;">http://nopadolais.dyndns.org/apppo</a></li>
                <li>กรอก username และ password</li>
                <li>คลิกปุ่ม login เพิ่อเข้าสู่ระบบ</li>
                </ul>
          </div>

       </div>
       <hr style="width: 80%; clear: both; margin-top: 5%;">
       <div style="text-align: center;" class="content-a">  
          <div class="a">
                    <img src="images/pages/user_cat3.jpg" class="manualimg3">
                    <img src="images/pages/catdr_select.jpg" class="manualimg3">
                    <img src="images/pages/select_catdr_team.jpg" class="manualimg3">
                    <img src="images/pages/check_item_cat3.jpg" class="manualimg3">
          </div>
          <div class="b">
                <ul><h3>หน้าจอ PO ทั้งหมดของผู้ที่เข้าใช้งาน </h3></ul>
                <ol><b><u>cate</u></b>
                        <li>จะเห็นข้อมูลของใบ PO ของตัวเอง</li>
                        <li>สามารถค้นหาใบ PO ที่ต้องการจากช่องที่ใช้สำหรับค้นหาได้</li>
                        <li>สามารถ กดปุ่ม Checkbox และ กดปุ่ม อนุมัติ เพื่ออนุมัติใบ PO ที่เลือกได้เลย</li>
                        <li>สามารถเลือกอนุมัติใบ PO ได้มากกว่า 1 รายการ</li>
                </ol>
                <hr width="80%">
                <ol><b><u>owner</u></b>
                        <li>จะเห็น list รายการ ให้ท่านเลือก cate ที่ต้องการ Approve ใบ PO</li>
                        <li>เมื่อท่านเลือก cate เสร็จแล้ว ก็สามารถเห็นรายการ PO ของ cate นั้นได้</li>
                        <li>สามารถ กดปุ่ม Checkbox และ กดปุ่ม อนุมัติ เพื่ออนุมัติใบ PO ที่เลือกได้เลย</li>
                        <li>สามารถเลือกอนุมัติใบ PO ได้มากกว่า 1 รายการ</li>
                        <li>สามารถค้นหารายการ PO ตามรหัสเจ้าหนี้ได้ ในช่องค้นหา แล้วกดปุ่มค้นหาเพื่อค้นหารายการ PO ที่ต้องการ</li>
                </ol>
          </div>

       </div>
       <hr style="width: 80%; clear: both; margin-top: 5%;">
              <div style="text-align: center;" class="content-a">  
          <div class="a">
                    <img src="images/pages/user_cat3.jpg" class="manualimg3">
                    <img src="images/pages/Podeail_catdr.jpg" class="manualimg3">
          </div>
          <div class="b">
                <ul><h3>หน้าจอรายละเอียดรายการ PO </h3>
                <li>เมื่อกดปุ่ม Icon&nbsp;<img src="images/pages/iconpo.jpg" width="20">&nbsp;ทางด้านขวา ก็จะสามารถดูรายละเอียดของใบ PO ใบนั้นได้</li>
                <li>ภาพด้านขวาเป็นหน้าแสดง รายละเอียดของใบ PO ใบที่เราเลือก</li>
                <li>เมื่อกดปุ่ม Icon&nbsp;<img src="images/pages/iconback.jpg" width="20">&nbsp;มุมซ้ายบน ก็จะย้อนกลับไปยังหน้าก่อน หน้านี้</li>
                <li>เมื่อกดปุ่ม Icon&nbsp;<img src="images/pages/iconlogout.jpg" width="20">&nbsp;มุมขวาบน จะเป็นการออกจากระบบ</li>
                </ul>
          </div>

       </div>
       <hr style="width: 80%; clear: both; margin-top: 5%;">
              <div style="text-align: center;" class="content-a">  
          <div class="a">
                    <img src="images/pages/Podeail_catdr.jpg" class="manualimg3">
                    <img src="images/pages/toggle_item.jpg" class="manualimg3">
          </div>
          <div class="b">
                <ul><h3>หน้าจอรายละเอียดรายการสินค้า </h3>
                <li>เมื่อกดปุ่ม Icon&nbsp;<img src="images/pages/iconsearch.jpg" width="20">&nbsp; ก็จะสามารถดูรายละเอียดของรายการสินค้าในใบ PO ใบนั้นได้</li>
                <li>ภาพด้านขวาเป็นหน้าแสดง รายละเอียดของสินค้าในใบ PO ใบที่เราเลือก</li>
                <li>เมื่อคลิกที่เครื่องหมาย + สีแดง จะสามารถดูรายละเอียดของสินค้า คงเหลือในคลังต่าง ๆ ได้</li>
                </ul>
          </div>

       </div>

    </div>
  </div>

</body>
</html>
<?Php
$header .= "<div style='text-align:left; float:left; width:35%;' margin-bottom:5%;><img src='images/logo-header.gif'></div>";
$header .= "<div style='text-align:left; float:left;'><h1>คู่มือการใช้งาน PO Approve</h1></div>";
$footer .= "คุ่มือในการใช้งานเว็บไซต์ manage category ของ บริษัท นพดลพานิช จำัด เว็บไซต์ www.qserver.nopadol.com/catman";

$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-P', '0', 'THSaraban');
$pdf->SetMargins( 100,100,30 );
$pdf->SetHeader($header);
$pdf->WriteHTML($html);
$pdf->Setfooter($footer);
$pdf->Output();
?>     