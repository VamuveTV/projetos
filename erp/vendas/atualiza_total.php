<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	
	$query2 = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
	$result2 = mysql_query($query2);
	list($total)=mysql_fetch_row($result2);
		
	echo number_format($total,2,",",".");
	
?>