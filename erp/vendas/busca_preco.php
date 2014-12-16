<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

$sql = "SELECT AVG(unitario_venda) FROM estoque WHERE produto='".$_POST['produto']."'";
$result = mysql_query($sql);
list($preco)=mysql_fetch_row($result);

echo number_format($preco,2);

?>