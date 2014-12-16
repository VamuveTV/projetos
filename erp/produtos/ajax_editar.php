<?php

// -------------------------------
// VERSAO SEM MAGENTO
// -------------------------------

	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	//include("../funcoesSoap.php");
	$banco = new ZarbMysql();
	
	//dados necessarios para o MAGMI
	//require_once("../magmi/inc/magmi_defs.php");
	//require_once("../magmi/integration/inc/magmi_datapump.php");	
	
	// create a Product import Datapump using Magmi_DatapumpFactory
	//$dp=Magmi_DataPumpFactory::getDataPumpInstance("productimport");		
	//$dp->beginImportSession("default","update");


	$_POST['valor'] = str_replace(".", "", $_POST['valor']);
	$_POST['valor'] = str_replace(",", ".", $_POST['valor']);

	//gravando primeiro o grupo de produtos
	$campos =  array("nome","descricao","frete","lancamento","peso","referencia","marca","imposto","preco");	
	$dados = array($_POST["nome"],$_POST["descricao"],$_POST["frete"],$_POST["lancamento"],$_POST["peso"],$_POST["referencia"],$_POST["marca"],$_POST["imposto"],$_POST['valor']);
	$tabela = "grupo_produtos";
	
	// ATUALIZANDO DADOS NO MAGENTO
    //include("../conectarSoap.php");
  
	if(isset($_POST['Filename'])){
		$campos[]="foto";
		$dados[]=$_POST['Filename'];
	}	
	
	//buscando a imagem anterior para excluir e o nome do magento
	$sql = "SELECT nome, foto FROM grupo_produtos WHERE codigo='".$_POST['cod']."'";
	$result = mysql_query($sql);
	list($nome_old,$foto_old)=mysql_fetch_row($result);
	
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);
	
	$sql2 = "SELECT nome FROM marca WHERE codigo='".$_POST['marca']."'";
	$res2 = mysql_query($sql2);
	list($nome_marca)=mysql_fetch_row($res2);
	
	//buscando as unidados deste grupo de produtos para verificar se é integrado com magento
	$sql = "SELECT up.unidade, u.magento FROM unidades_produtos AS up INNER JOIN unidades AS u ON u.codigo=up.unidade 
			WHERE up.produto='".$_POST['cod']."' AND u.magento='S'";
	$res = mysql_query($sql);
	$usa_magento = mysql_num_rows($res)>0?'S':'N';		
	
	//ATUALIZANDO A TABELA DOS PRODUTOS (produtos)
	$sql = "SELECT codigo, nome, referencia, skumagento FROM produtos WHERE grupo='".$_POST['cod']."'";
	$res = mysql_query($sql);
	while(list($cod_subp,$nome_subp,$referencia_subp,$sku_subp)=mysql_fetch_row($res)){
		//atualizar nome, peso, descricao, referencia na tabela do ERP
		$novo_nome = str_replace($nome_old, $_POST['nome'], $nome_subp);
		$novo_nome = str_replace($referencia_subp, $_POST['referencia'], $novo_nome);
		
		$sql2 = "UPDATE produtos SET nome='$novo_nome',peso='".$_POST['peso']."',referencia='".$_POST['referencia']."' WHERE codigo='$cod_subp'";
		$res2 = mysql_query($sql2);
				
		//atualizando no magento
		/*
		if($usa_magento=='S'){
			$item=array("name"=>$novo_nome,
						"sku"=>$sku_subp,
						"attribute_set"=>"Default",
						"store"=>"admin",
						"description"=>$_POST["descricao"],
						"frete_gratis"=>$_POST['frete'],
						"lancamento"=>$_POST['lancamento'],								
						"manufacturer"=>$nome_marca);	
																
			// Now ingest item into magento
			$dp->ingest($item);				 
		} 
		 * 
		 */					
	}
	
	// End import Session
	//$dp->endImportSession();	
	
	//EXCLUINDO E GRAVANDO AS CATEGORIAS
	mysql_query("DELETE FROM categorias_produtos WHERE produto='".$_POST['cod']."'");	
	foreach($_POST['categorias'] AS $codCategoria){
		$banco->insere("categorias_produtos", array("categoria","produto"), array($codCategoria,$_POST['cod']));
	}	
?>