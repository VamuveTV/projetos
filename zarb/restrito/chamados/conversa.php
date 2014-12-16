<?php
include("../lib.php");
?>
<title>Zarb Solution - administração</title>
<style type="text/css">
@import url(style.css);
</style>
<div id="conteudo">
<?
echo "<div id='interacoes'> ";
$sql = "SELECT c.nome, u.nome, i.data, i.hora, i.texto FROM interacoes AS i ";
$sql.= "INNER JOIN clientes AS c ON i.cliente_id = c.codigo INNER JOIN usuclientes AS u ON i.usuario_id = u.codigo ";
$sql.= "INNER JOIN chamado AS ch ON i.chamado_id = ch.codigo WHERE i.chamado_id = '$cod' ORDER BY i.codigo";
$res = mysql_query($sql);
  while(list($cliente,$usuario,$data,$hora,$texto)=mysql_fetch_row($res)){

  $data = converte_data($data,"usuario");
?>
<label class="interacoes"><?=$cliente." - ".$usuario."<br>".$data." - ".$hora." : ".$texto."<br>";?></label><br />
<?
}
?>
</div>