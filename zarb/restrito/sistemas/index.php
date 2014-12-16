<?php
$titulo = "Sistemas"; //titulo da página
$modulo = "sistemas"; //módulo atual (mesmo nome da pasta)
$tabela = "sistema"; //tabela do banco de dados
$campos = array("sistema","descricao");//nome dos campos na tabela.
$dados = array($_POST['sistema'],$_POST['descricao']);//nome dos campos do form, devem seguir ordem dos campos da tabela
$conn = new ZarbMysql;
//-------------------------------------------------------------------------
// INICIO DAS FUNCIONALIDADE REFERENTES AO BANCO DE DADOS                //
//-------------------------------------------------------------------------
if($_POST["acao"]=="Gravar")//se selecionado gravar
{
  $msg = $conn->insere($tabela,$campos,$dados);

  unset($_POST);
}
else if($_POST["acao"]=="Salvar")//se selecionado salvar
{
  $msg = $conn->atualiza($tabela,$campos,$dados,$cod);

  unset($_POST);
}
else if($_POST["acao"]=="Excluir")//se selecionado excluir
{
  extract($_POST);
  foreach ($lista as $valor) {
  	$msg = $conn->deleta($tabela,$valor);
  }

  unset($_POST);
}
//----------------------------------------------------------------------------
// FIM DAS FUNCIONALIDADE REFERENTES AO BANCO DE DADOS E INICIO DO CONTEÚDO //
//----------------------------------------------------------------------------
?>
<h1><?=$titulo;?></h1>
<br />
<?php
//AREA INICIAL: SELEÇÃO DE DISTRIBUIDORES
if(!$_POST["acao"] && !$_GET["cod"] && !$_GET["param"])
{
?>
<script language=javascript>
<!--
function CheckAll() {
   for (var i=0;i<document.index.elements.length;i++) {
     var x = document.index.elements[i];
     if (x.name == 'lista[]') {
x.checked = document.index.selall.checked;
}
}
}
//-->
</script>
<form method="post" action="principal.php?centro=<?=$modulo;?>" name="index">
<input type="button" value="Novo" class="botao" onclick="document.location='principal.php?centro=<?=$modulo;?>&param=new'" /><br /><br />
<font class="label3">Buscar: </font><input type="text" class="campo_simples" name="nome_busca" /> <input type="submit" name="filtro" value="Pesquisar" class="botao" /><br /><br />
<?php
$sql = "SELECT codigo, sistema, descricao FROM $tabela ";
if($_POST["nome_busca"])
  $sql.= "WHERE sistema LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY sistema ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='27%'>Sistema</th>
        <th width='70%'>Descri&ccedil;&atilde;o</th>
        </tr>";
  while(list($cod,$sistema,$descricao)=mysql_fetch_row($res))
  {
    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$sistema</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$descricao</a></td>
          </tr>";
  }
  echo "</table>";
?>
<br />
<input type="submit" name="acao" value="Excluir" class="botao" />
</form>
<?
}
}
else if($_GET["param"]=="new" || $_GET["cod"])
{
  $cod = $_GET["cod"];
  if($cod){
    $fazer="Salvar";
    $sql = "SELECT codigo, sistema, descricao FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo,$sistema,$descricao)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label><b>Sistema: </b></label><input type="text" name="sistema" value="<?=$sistema;?>" class="campo" /><br /><br />
  <label><b>Descri&ccedil;&atilde;o: </b></label>
  <textarea name="descricao" rows="6" cols="65" style='border: 1px #444 solid;font-family:verdana;font-size: 11px;padding: 4px'><?=$descricao;?></textarea><br /><br />
  <input type="hidden" name="cod" value="<?=$cod;?>" />
  <input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
  </form>
<?php
}
if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>