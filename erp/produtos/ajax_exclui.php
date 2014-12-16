<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$tabela = "produtos";

//buscando o sku do produto antes de excluir
$sql = "SELECT skumagento FROM produtos WHERE codigo='".$_POST['cod']."'";
$result = mysql_query($sql);
list($sku)=mysql_fetch_row($result);

echo $banco->deleta($tabela, $_POST['cod']);	

// EXCLUINDO DADOS NO MAGENTO
include("../conectarSoap.php");

$result = $client->catalogProductDelete($session,$sku,$identifierType = 'sku');
	
?>