<?php
require_once('barcode.inc.php'); 
$code_number = $_GET['cod'];
#new barCodeGenrator($code_number,0,'hello.gif'); 
new barCodeGenrator($code_number,0,'hello.gif', 190, 90);
?> 