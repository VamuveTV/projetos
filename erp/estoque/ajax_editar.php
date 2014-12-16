<?php
	session_start();
	
	function converte_data($data,$tipo){
	  if($tipo=="usuario")
	    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
	  
	  if($tipo=="banco")
	    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
	  return $data;
	}
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("produto","quantidade","tipo","centro","data","unitario","unitario_venda");
	$_POST["data"] = converte_data($_POST["data"], "banco");
	$dados = array($_POST["produto"],$_POST["quantidade"],'E',$_POST["centro"],$_POST["data"],$_POST["valor"],$_POST["venda"]);
	$tabela = "estoque";
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);	
	
	
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