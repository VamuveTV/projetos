<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$tabela = "vendas";

mysql_query("DELETE FROM produtos_vendas WHERE venda='".$_POST['cod']."'");

echo $banco->deleta($tabela, $_POST['cod']);	
	
	
?>