<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

$tabela = "parcelas";

$banco->deleta($tabela, $_POST['parcela']);

echo $_POST["cod"];
	
?>