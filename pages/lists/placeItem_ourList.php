<?php
$filename = 'STEAMtoTMList.txt';
$classid_instanceid = $_POST['tclassid_instanceid'] . ",";
$handle = fopen($filename, 'a');
fwrite($handle, $classid_instanceid);
?>