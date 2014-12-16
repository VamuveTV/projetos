<?php 
/*
mysql_connect('localhost','root','') or die('Falha ao conectar');
mysql_select_db('curso') or die('Falha ao selecionar BD');
mysql_set_charset('utf8');

$sql = "INSERT INTO vendas(produto,quantidade) VALUES ('".$_POST['produto']."','".$_POST['quantidade']."')";
$result = mysql_query($sql);
*/

foreach($_POST['tbProdutos'] AS $prod){
  print_r(json_decode($prod,true));
}
?>