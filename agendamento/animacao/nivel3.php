<?php
header("Content-type: text/html; charset=utf-8");

include('bd.php');

$categoria = $_POST['categoria'];
$sql = "SELECT sku, nome, foto, preco, url FROM produto WHERE idcategoria='$categoria'";
$res = mysql_query($sql);

while(list($sku,$nome,$foto,$preco,$url)=mysql_fetch_row($res)){
  
  echo "<div class=\"produto\">
                    <p>
                    <img src='$foto' width='64'>
                    </p>
                    <h3>$nome</h3>
                    <h3>A partir de R$ $preco</h3>
                    <br>
                    <a href=\"$url?options=cart\" class=\"botao\">COMPRAR</a>
                    </p>
                  </div>";
}