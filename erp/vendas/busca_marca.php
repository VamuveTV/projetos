<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

$sql = "SELECT m.nome FROM produtos AS p INNER JOIN  marcas AS m ON m.codigo=p.marca WHERE p.codigo='".$_POST['produto']."'";
$result = mysql_query($sql);
list($marca)=mysql_fetch_row($result);

echo $marca;

?>