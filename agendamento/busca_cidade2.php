<?php

mysql_connect("localhost","digital_pontos","acdigital");

mysql_select_db("digital_pontos");

/*
mysql_connect("localhost","root","");

mysql_select_db("agendamento");
*/

//buscando cidades ja cadastradas
$sql = "SELECT DISTINCT(cidade) FROM tbl_pontos ";
$result = mysql_query($sql);
$vcidades = array();
while(list($c)=mysql_fetch_row($result)){
  $vcidades[] = $c;
}

$uf = $_POST['uf'];

$sql = "SELECT id, nome FROM tb_cidades WHERE uf='$uf' AND (";
$ct = 0;
foreach($vcidades AS $c){
  $ct++;
  $sql.= " id='$c' ";
  $sql.= $ct!=count($vcidades)?' OR ':'';
}
$sql.= ") ORDER BY nome";
$result = mysql_query($sql);
echo '<select onchange="busca_pontos(this.value)" class="form-control" required id="cidade" name="cidade">';
echo '<option value="">Selecione:</option>';
while(list($id,$nome)=mysql_fetch_row($result)){
  echo "<option value='$id'>$nome</option>";
} 

echo '</select>';
?>