<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome","parent");
	$dados = array($_POST["nome"],$_POST["parent"]);
	$tabela = "classificacao";
	echo $banco->insere($tabela, $campos, $dados);
	$cod = mysql_insert_id();
	
	//gravando no magento
	include("../conectarSoap.php");
	
	$result = $client->catalogCategoryCreate($session, $_POST["parent"], array(
	    'name' => $_POST["nome"],
	    'is_active' => 1,
	    //<!-- position parameter is deprecated, category anyway will be positioned in the end of list
	    //and you can not set position directly, use catalog_category.move instead -->
	    'available_sort_by' => array('position'),
	    'default_sort_by' => 'position',
	    'description' => $_POST['nome'],
	    'include_in_menu' => 1,
	));
		
	echo '<br>'.$banco->atualiza($tabela, array('idmagento'), array($result), $cod);
?>