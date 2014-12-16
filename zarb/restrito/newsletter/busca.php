<?php
include "../../bd.php";

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}

$valor = stripslashes($_GET[valor]); 
$valor2 = stripslashes($_GET[valor2]); 
$valor3 = stripslashes($_GET[valor3]);
$valor4 = stripslashes($_GET[valor4]); 
$valor5 = stripslashes($_GET[valor5]);  

$sql="select count(codigo) from usuarios where codigo>0";
if($valor)
	$sql.= " and uf='$valor' ";
if($valor2)
	$sql.=" and cidade ='$valor2' ";	
if($valor3)
	$sql.=" and operadora='$valor3' ";
if($valor4){
  $valor4 = converte_data($valor4,"banco");
  $sql.= "AND data_cadastro >= '$valor4' ";
}
if($valor5){
  $valor5 = converte_data($valor5,"banco");
  $sql.= "AND data_cadastro >= '$valor5' ";
}
   
$resultado=mysql_query($sql) or die (mysql_error());
list($quant) = mysql_fetch_row($resultado);
echo "N&uacute;mero de Pessoas Selecionadas $quant";
echo "<input type='hidden' name='quantidade' value='$quant' /><br />";

?>
