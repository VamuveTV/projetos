<?php
header('Content-type: image/gif'); 
require_once('barcode.inc.php'); 
new barCodeGenrator("201308301",0,"hello.gif");
?>