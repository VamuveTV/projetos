<?php
session_start();
?>
<html>
<head>
  <meta charset="utf-8">
  <title>Relatório</title>
</head>
<body>
<?php

//conexao com banco de dados
mysql_connect("localhost","pedro_ingresso","ingresso");
mysql_select_db("pedro_ingresso");

function converte_data($dt){
  $hora = substr($dt,10);
  $dt = substr($dt,0,10);
  return substr($dt,-2).'/'.substr($dt,5,2).'/'.substr($dt,0,4).' '.$hora;
} 
?>

<style type="text/css">
body,th,td{
  font-family: arial;
  font-size: 12px;
}
table{
  background: #000;
}
th{
  background: #EEE;
}
td{
  background: #fff;
}
</style>

<?php

if(isset($_POST['acao'])){
  if($_POST['senha']=='boo20happy14')
    $_SESSION['logado']=1;
}

if(!isset($_SESSION['logado'])){
?>

<form method="post">
<label>Senha:</label> <input type="password" name="senha"><br>
<input type="submit" name="acao" value="Enviar">
</form>
<?php


}
else{
?>
<table cellpadding="4" cellspacing="1">
  <tr>
    <th>EVENTO</th>
    <th>CLIENTE</th>
    <th>E-MAIL CLIENTE</th>
    <th>PEDIDO</th>
    <th>STATUS</th>
    <th>CÓD. BARRAS</th>
  </tr>
  <?php
  $sql = "SELECT * FROM ingressos ORDER BY id";
  $result = mysql_query($sql);
  while($dados=mysql_fetch_array($result)){
    $dados['evento']=str_replace('�', '-', $dados['evento']);
    echo '<tr>
            <td>'.$dados['evento'].'</th>
            <td>'.$dados['cliente'].'</th>
            <td>'.$dados['email'].'</th>
            <td>'.$dados['id_pedido'].'</th>
            <td>'.$dados['status'].'</th>
            <td>'.$dados['cod_barras'].'</th>
          </tr>';
  } 
  
  ?>
</table>
<?php
}
?>
</body>
</html>