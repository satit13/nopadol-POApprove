<?php
echo "<meta charset='utf-8'>";
$str = "บักโบ้ รัตนพล ส.วรพิน ระดมมัดอัดลำตัว วินโด แพซ นักชกจากแดนอีกเหนา น็อคยก3 ส่วน วิษณุ ก่อเกียรติยิม ป้องกันแชมป์หลังอัด สิทูโมรัง จบยก 2";
//$str=$sort['apName'][$i];
            if (strlen($str) > 30 ){
                $str=trim(mb_substr($str, 0, 30, 'UTF-8'))."....";
            }   else {
                $str=$str;
            }
echo $str."<br>";

$number=10000.99;
echo number_format($number, 2, '.', ',');
?>