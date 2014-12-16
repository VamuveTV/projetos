<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$tabela = "estoque";

//BUSCANDO O CODIGO DO PRODUTO
$sql = "SELECT produto FROM estoque WHERE codigo='".$_POST['cod']."'";
$result = mysql_query($sql);
list($_POST["produto"])=mysql_fetch_row($result);

echo $banco->deleta($tabela, $_POST['cod']);	

// INTEGRANDO COM MAGENTO
include("../conectarSoap.php");

//BUSNCANDO O CODIGO SKU DO PRODUTO NO MAGENTO 
$sql = "SELECT skumagento FROM produtos WHERE codigo='".$_POST["produto"]."'";
$result = mysql_query($sql);
list($sku)=mysql_fetch_row($result);

//BUSCANDO O PRECO MEDIO E QUANTIDADE PARA ATUALIZAR NO MAGENTO
$sql = "SELECT AVG(unitario_venda), SUM(quantidade) FROM estoque WHERE produto='".$_POST["produto"]."' AND centro='F'";
$result = mysql_query($sql);
list($preco_medio,$qtd_nova)=mysql_fetch_row($result);
  
//atualizando o preco no magento
$result = $client->catalogProductUpdate($session, $sku, array(
			    'price' => $preco_medio
			),
			$store = null, 
			$identifierType = 'sku'
			);
			    	
//atualizando a quantidade atual no magento
$result = $client->catalogInventoryStockItemUpdate($session, $sku, array(
			    'qty' => $qtd_nova,
			    'is_in_stock' => 1
			    ));
	
?>