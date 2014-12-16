<?php 

mysql_connect('localhost','root','') or die('Falha ao conectar');
mysql_select_db('curso') or die('Falha ao selecionar BD');
mysql_set_charset('utf8');

$sql = "SELECT * FROM categorias";
$result = mysql_query($sql);
$categorias = array();
while($dados = mysql_fetch_assoc($result)){
  $categorias[] = $dados;
}
//print_r($categorias);
echo json_encode($categorias);
?>