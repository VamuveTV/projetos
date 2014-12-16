<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$tabela = "clientes";
echo $banco->deleta($tabela, $_POST['cod']);	
	
?>