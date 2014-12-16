<?php
include("bd.php");

$curso = $_GET['curso'];
?>
<select name="turma" class="campo">
  <option value=''>Selecione</option>
  <?php
    $sql = "SELECT codigo, periodo FROM turmas WHERE curso='$curso' ORDER BY codigo";
    $res = mysql_query($sql);
    while(list($codturma,$periodo)=mysql_fetch_row($res)){
      echo "<option value='$codturma'";
      echo $turma==$codturma?" selected":"";
      echo ">$periodo</option>";
    }
  ?>
</select>