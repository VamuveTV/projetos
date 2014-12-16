<?php
$titulo = "Funcion&aacute;rios"; //titulo da página
$modulo = "funcionarios"; //módulo atual (mesmo nome da pasta)
$tabela = "funcionarios"; //tabela do banco de dados
$pag_mensal = str_replace(",",".",$pag_mensal);
$vale_tranporte = str_replace(",",".",$vale_transporte);
$campos = array("nome","email","login","senha","comissao","pag_mensal","vale_transporte","ativo");//nome dos campos na tabela.
$dados = array($_POST['nome'],$_POST['email'],$_POST['login'],$_POST['senha'],$_POST['comissao'],$pag_mensal,$vale_transporte,$_POST['ativo']);//nome dos campos do form, devem seguir ordem dos campos da tabela
$conn = new ZarbMysql;
//-------------------------------------------------------------------------
// INICIO DAS FUNCIONALIDADE REFERENTES AO BANCO DE DADOS                //
//-------------------------------------------------------------------------
if($_POST["acao"]=="Gravar")//se selecionado gravar
{
  $pag_mensal = str_replace(",",".",$pag_mensal);
  $vale_tranporte = str_replace(",",".",$vale_transporte);
  $msg = $conn->insere($tabela,$campos,$dados);

  unset($_POST);
}
else if($_POST["acao"]=="Salvar")//se selecionado salvar
  {
  $pag_mensal = str_replace(",",".",$pag_mensal);
  $vale_tranporte = str_replace(",",".",$vale_transporte);
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
$sql = "SELECT codigo, nome, email, login, comissao, pag_mensal, vale_transporte, ativo FROM $tabela ";
if($_POST["nome_busca"])
  $sql.= "WHERE nome LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY nome ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='1%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='20%'>Nome</th>
        <th width='20%'>E-mail</th>
        <th width='10%'>Login</th>
        <th width='10%'>Comissao</th>
        <th width='10%'>Pagamento Mensal</th>
        <th width='10%'>Vale Transporte</th>
        <th width='10%'>Ativo</th>
        </tr>";
  while(list($cod,$nome,$email,$login,$comissao,$pag_mensal,$vale_transporte,$ativo)=mysql_fetch_row($res))
  {

  switch($ativo){
    case 'S':
      $ativo = "Sim";
      break;
    case 'N':
      $ativo = "N&atilde;o";
      break;
  }

  switch($comissao){
    case 'S':
      $comissao = "Sim";
      break;
    case 'N':
      $comissao = "N&atilde;o";
      break;
  }

    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$nome</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$email</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$login</a></td>
          <td align='center'><a href='principal.php?centro=$modulo&cod=$cod'>$comissao</a></td>
          <td align='right'><a href='principal.php?centro=$modulo&cod=$cod'>R$ ".str_replace(".",",",$pag_mensal)."</a></td>
          <td align='right'><a href='principal.php?centro=$modulo&cod=$cod'>R$ ".str_replace(".",",",$vale_transporte)."</a></td>
          <td align='center'><a href='principal.php?centro=$modulo&cod=$cod'>$ativo</a></td>
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
    $sql = "SELECT codigo, nome, email, login, senha, comissao, pag_mensal, vale_transporte, ativo FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);       
    list($codigo,$nome,$email,$login,$senha,$comissao,$pag_mensal,$vale_transporte,$ativo)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
<form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label>Nome: </label>
    <input type="text" name="nome" class="nome" value="<?=$nome;?>" /><br /><br />
  <label>E-mail: </label>
    <input type="text" name="email" class="email" value="<?=$email;?>" /><br /><br />
  <label>Login: </label>
    <input type="text" name="login" class="campo" value="<?=$login;?>" /><br /><br />
  <label>Senha: </label>
    <input type="password" name="senha" class="campo" value="<?=$senha;?>" /><br /><br />
  <label>Comiss&atilde;o: </label>
    <input type="radio" name="comissao" value="S" <?if($comissao=="S") echo "checked";?> /> Sim
    <input type="radio" name="comissao" value="N" <?if($comissao=="N" || $comissao=="") echo "checked";?> /> N&atilde;o <br /><br />
  <label>Pagamento: </label>
    <input type="text" name="pag_mensal" class="valor" value="<?=$pag_mensal;?>" /><br /><br />
  <label>Vale Transporte: </label>
    <input type="text" name="vale_transporte" class="valor" value="<?=$vale_transporte;?>" /><br /><br />
  <label>Ativo: </label>
    <input type="radio" name="ativo" value="S" <?if($ativo=="S" || $ativo=="") echo "checked";?> /> Sim
    <input type="radio" name="ativo" value="N" <?if($ativo=="N") echo "checked";?> /> N&atilde;o <br /><br />
  <input type="hidden" name="cod" value="<?=$cod;?>" />
  <input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
  </form>
<?php
}
if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>