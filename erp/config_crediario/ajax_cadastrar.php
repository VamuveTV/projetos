<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	
	$_POST['minimo_parcela'] = str_replace(",",".",$_POST['minimo_parcela']);
	
	$sql = "UPDATE config_crediario SET 
			maximo_compra='".$_POST['maximo_compra']."',
			maximo_parcela='".$_POST['maximo_parcela']."',
			parcela_minima='".$_POST['minimo_parcela']."'";
	$result = mysql_query($sql);
	
	if($result)
		echo "Dados atualizados com sucesso";
	else
		echo "Falha ao atualizar";
?>