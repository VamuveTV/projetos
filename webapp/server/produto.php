<?php 

mysql_connect('localhost','root','') or die('Falha ao conectar');
mysql_select_db('curso') or die('Falha ao selecionar BD');
mysql_set_charset('utf8');

$sql = "SELECT * FROM produtos WHERE id='".$_POST['produto']."'";
$result = mysql_query($sql);
$produtos = array();
$dados = mysql_fetch_assoc($result);
$produto[] = $dados;

//print_r($categorias);
echo json_encode($produto);
?>