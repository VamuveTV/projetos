<?php
$titulo = "Clientes"; //titulo da página
$modulo = "clientes"; //módulo atual (mesmo nome da pasta)
$tabela = "clientes"; //tabela do banco de dados
$campos = array("nome","email","endereco","telefone","contato","observacao","ativo");//nome dos campos na tabela.
$dados = array($_POST['nome'],$_POST['email'],$_POST['endereco'],$_POST['telefone'],$_POST['contato'],$_POST['observacao'],$_POST['ativo']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
$sql = "SELECT codigo, nome, email, endereco, telefone, contato, ativo FROM $tabela ";
if($_POST["nome_busca"])
  $sql.= "WHERE nome LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY nome ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='20%'>Nome</th>
        <th width='20%'>E-mail</th>
        <th width='35%'>Endere&ccedil;o</th>
        <th width='10%'>Telefone</th>
        <th width='10%'>Contato</th>
        <th width='3%'>Ativo</th>
        </tr>";
  while(list($cod,$nome,$email,$endereco,$telefone,$contato,$ativo)=mysql_fetch_row($res))
  {

  switch($ativo){
    case 'S':
      $ativo = "Sim";
      break;
    case 'N':
      $ativo = "N&atilde;o";
      break;
  }

    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$nome</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$email</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$endereco</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$telefone</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$contato</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$ativo</a></td>
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
    $sql = "SELECT codigo, nome, email, endereco, telefone, contato, observacao, ativo FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo,$nome,$email,$endereco,$telefone,$contato,$observacao,$ativo)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label>Nome: </label><input type="text" name="nome" class="nome" value="<?=$nome;?>" /><br /><br />
  <label><b>E-mail: </b></label><input type="text" name="email" class="email" value="<?=$email;?>" /><br /><br />
  <label><b>Endere&ccedil;o: </b></label><input type="text" name="endereco" class="endereco" value="<?=$endereco;?>" /><br /><br />
  <label><b>Telefone: </b></label><input type="text" name="telefone" class="phone" value="<?=$telefone;?>" /><br /><br />
  <label><b>Contato: </b></label><input type="text" name="contato" class="campo" value="<?=$contato;?>" /><br /><br />
  <label><b>Observa&ccedil;&atilde;o: </b></label><textarea name="observacao" cols="50" rows="5" class="textarea"><?=$observacao;?></textarea><br /><br />
  <label><b>Ativo: </b></label><input type="radio" name="ativo" value="S" <?if($ativo == "S") echo "checked"; ?> />Sim <br />
                               <input type="radio" name="ativo" value="N" <?if($ativo == "N") echo "checked"; ?> />N&atilde;o <br /><br />
  <input type="hidden" name="cod" value="<?=$cod;?>" />
  <input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
  </form>
<?php
}
if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>