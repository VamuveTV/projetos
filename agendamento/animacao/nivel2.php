<?php
header("Content-type: text/html; charset=utf-8");

include('bd.php');

$categoria = $_POST['categoria'];

//verificando se existem sub-categorias
$sql = "SELECT id, nome, icone FROM categoria WHERE tipo='S' AND mae='$categoria'";
$result = mysql_query($sql);

if(mysql_num_rows($result)>0){ //existem subcategorias
  while(list($id,$nome,$icone)=mysql_fetch_row($result))
  {
    echo "<div id=\"subbox$id\" onclick=\"sub('$id')\" class=\"box\">
          <p>
          <img src='$icone' width='64'><br>
          $nome
          </p>    
        </div>";
  }


}
else{
  include('nivel3.php');
}