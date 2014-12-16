<?php
$titulo = "Sistemas de Cliente"; //titulo da página
$modulo = "cliente_sistema"; //módulo atual (mesmo nome da pasta)
$tabela = "cliente_sistema"; //tabela do banco de dados
$campos = array("cliente_id","sistema_id");//nome dos campos na tabela.
$dados = array($_POST['cliente'],$_POST['sistema']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
$sql = "SELECT cs.codigo, c.nome, s.sistema FROM $tabela AS cs ";
$sql.= "INNER JOIN clientes AS c ON c.codigo = cs.cliente_id ";
$sql.= "INNER JOIN sistema AS s ON s.codigo = cs.sistema_id ";
if($_POST["nome_busca"])
  $sql.= "WHERE c.nome LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY c.nome ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='45%'>Cliente</th>
        <th width='48%'>Sistema</th>
        </tr>";
  while(list($cod,$cliente,$sistema)=mysql_fetch_row($res))
  {
    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$cliente</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$sistema</a></td>
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
    $sql = "SELECT codigo, cliente_id, sistema_id FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo,$cliente,$sistema)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label>Cliente: </label>
  <select name="cliente" class="campo">
    <option value="">Selecione </option>
      <?
        $sql = "Select codigo, nome From clientes Order By nome";
        $res = mysql_query($sql);
        while($linha2 = mysql_fetch_array($res)){
          if($cliente == $linha2[codigo])
            echo " <option value= '$linha2[codigo]' 'selected' >$linha2[nome]</option>";
          else
            echo " <option value= '$linha2[codigo]'>$linha2[nome]</option>";
        }
      ?>
  </select><br /><br />
  <label><b>Sistema: </b></label>
  <select name="sistema" class="campo">
    <option value="">Selecione </option>
      <?
        $sql = "Select codigo, sistema From sistema Order By sistema";
        $res = mysql_query($sql);
        while($linha2 = mysql_fetch_array($res)){
          if($sistema == $linha2[codigo])
            echo " <option value= '$linha2[codigo]' 'selected' >$linha2[sistema]</option>";
          else
            echo " <option value= '$linha2[codigo]'>$linha2[sistema]</option>";
        }
      ?>
  </select><br /><br />
  <input type="hidden" name="cod" value="<?=$cod;?>" />
  <input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
  </form>
<?php
}
if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>