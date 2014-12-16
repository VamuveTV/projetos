<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
//$_POST['senha'] = md5($_POST['senha']);
$sql = "SELECT * FROM usuarios WHERE senha='".$_POST['senha']."' and codigo=".$_POST['codigo_usuario']."";
$result = mysql_query($sql);

if(mysql_num_rows($result) == 1)
    echo 1;
else
    echo 2;
?>