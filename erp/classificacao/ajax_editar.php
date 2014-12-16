<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	//$campos =  array("nome","idmagento");
	//$dados = array($_POST["nome"],$_POST["idmagento"]);
	//$tabela = "classificacao";
	//echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);
	
	//atualizando através do idmagento
	$sql = "UPDATE classificacao SET nome='".$_POST["nome"]."' WHERE idmagento='".$_POST["cod"]."'";
	$result = mysql_query($sql);
	
	//update no magento
	include("../conectarSoap.php");
	
	$result = $client->catalogCategoryUpdate($session, $_POST["cod"], array(
	    'name' => $_POST["nome"],
	    'is_active' => 1,
	    //<!-- position parameter is deprecated, category anyway will be positioned in the end of list
	    //and you can not set position directly, use catalog_category.move instead -->
	    'available_sort_by' => array('position'),
	    'default_sort_by' => 'position',
	    'description' => $_POST['nome'],
	    'include_in_menu' => 1,
	));	
	
	if($result)
		echo "Dados atualizados com sucesso.";
	
?>