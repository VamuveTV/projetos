<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$tabela = "classificacao";


$sql = "DELETE FROM classificacao WHERE idmagento='".$_POST['cod']."'";
$result = mysql_query($sql);

//excluindo do magento
include("../conectarSoap.php");

$result = $client->catalogCategoryDelete($session, $_POST['cod']);

if($result)
	echo "Dados excluidos com sucesso.";
	
?>