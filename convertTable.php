<?php
$chkbox = $_POST['chk'];
$txtbox = $_POST['txt'];
$country = $_POST['country'];
 
foreach($txtbox as $a => $b)
  echo "{ $inputCriteriaType[$a] : {description: $inputDescription[$a],  min  :  $inputMinVal[$a], max  :  $inputMaxVal[$a] }}";
 
?>
