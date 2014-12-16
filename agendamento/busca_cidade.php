<?php
/*
mysql_connect("localhost","digital_pontos","acdigital");

mysql_select_db("digital_pontos");
*/

mysql_connect("localhost","root","");

mysql_select_db("agendamento");


$uf = $_POST['uf'];

$sql = "SELECT id, nome FROM tb_cidades WHERE uf='$uf' ORDER BY nome";
$result = mysql_query($sql);
echo '<select class="form-control" required id="cidade" name="cidade">';
echo '<option value="">Selecione:</option>';
while(list($id,$nome)=mysql_fetch_row($result)){
  echo "<option value='$id'>$nome</option>";
} 

echo '</select>';
?>