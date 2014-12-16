<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <link rel="stylesheet" type="text/css" href="style2.css" />
  <title>Zarb Solution - Solu&ccedil;&otilde;es em TI</title>
  <script type="text/javascript" src="js/jquery-1.4.4.js"></script>
<style type="text/css">

h3{
  font-size: 11px;
  color: #444;
  font-family: Trebuchet MS;
}

span{
  color: #444;              
}

li{
  color: #339999;
  font-size: 11px;
}

p{
  font-family: Trebuchet MS;
  color: #444;
  font-size: 11px;
}

</style>
  </head>
  <body>
<div id="superbox">
<?php
include("lib.php");
?>
<h1>Turmas Abertas:</h1>
<a name="topo"></a>
<?php
$cod_turma = $_GET['codturma'];

$sql = "SELECT t.codigo, c.codigo, c.nome FROM cursos AS c, turmas AS t WHERE t.curso=c.codigo ORDER BY c.nome";
$res = mysql_query($sql);
while(list($codturma,$codcurso,$nomecurso)=mysql_fetch_row($res)){
}
$sql2 = "SELECT t.codigo, t.curso, c.nome, c.descricao, t.periodo, t.turno, t.carga, t.pagamento, t.observacao ";
$sql2.= "FROM turmas AS t, cursos AS c WHERE t.codigo='$cod_turma' AND t.curso = c.codigo AND status = 'N' ORDER BY c.nome";
$res2 = mysql_query($sql2);

$ct = 0;
while(list($codturma,$codcurso,$nomecurso,$descricao,$periodo,$turno,$carga,$pagamento,$observacao)=mysql_fetch_row($res2)){
  if($ct!=0)
    $comp = " class='separa'";
  else
    $comp = "";
?>
  <a name="<?=$codturma;?>"<?=$comp;?>></a>
                                                            
  <p><a class="linkdestaque" href='inscricao.php'>Clique aqui</a> para realizar sua inscri&ccedil;&atilde;o.</p>

  <h1><?=$nomecurso;?></h1>
  <h3>
  <?echo "<h3>$descricao</h3";?><br />
  </h3>
  <h3 class="sub_tit">INVESTIMENTO</h3>
  <h3>
    <?=$pagamento;?>
  </h3>
  <h3 class="sub_tit">CARGA HORÁRIA</h3>
  <h3>
    <?=$carga;?>
  </h3>
  <h3 class="sub_tit">CALENDÁRIO</h3>
  <h3>
    <?=$periodo;?>
  </h3>
  <h3 class="sub_tit">HORÁRIO</h3>
  <h3>
    <?=$turno;?>
  </h3>
  <h3 class="sub_tit">LOCALIZA&Ccedil;&Atilde;O</h3>
  <h3>                                                                
    Rua: Sergipe, 1122 - Bairro Funcion&aacute;rios<br /> 31 2105-6450
  </h3>
<?php
  $ct++;
}
?>
</div>
  </body>
</html>
