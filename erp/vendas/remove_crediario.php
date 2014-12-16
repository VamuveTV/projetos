<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

$sql = "DELETE FROM parcelas WHERE venda='".$_POST['venda']."' AND forma_pagamento='C' ";
$result = mysql_query($sql);

$sql = "UPDATE vendas SET parcelasCred='', totalCred='', vencimento='' WHERE codigo='".$_POST['venda']."'";
$result = mysql_query($sql);
	
?>