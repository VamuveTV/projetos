<?php
$titulo = "Meus dados"; //titulo da página
$modulo = "meusdados"; //módulo atual (mesmo nome da pasta)
$tabela = "usuclientes"; //tabela do banco de dados
$campos = array("nome","email","senha");//nome dos campos na tabela.
$dados = array($_POST['nome'],$_POST['email'],$_POST['senha']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
  if(!$_POST['nome'] || !$_POST['email'])
    $msg = "ERRO: Preencha todos os campos.";
  else if(strlen($_POST['senha']) > 5)
    $msg = $conn->atualiza($tabela,$campos,$dados,$cod);
  else
    $msg = "ERRO: Senha deve ter o minimo de 6 caracteres.";

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
  $cod = $_SESSION[cod_usu];
  $fazer = "Salvar";
  $sql = "SELECT codigo, nome, email, senha FROM $tabela WHERE codigo='$cod' ";
  $res = mysql_query($sql);
  list($codigo,$nome,$email,$senha)=mysql_fetch_row($res);
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label><b>Nome: </b></label><input type="text" name="nome" value="<?=$nome;?>" class="campo" /><br /><br />
  <label><b>E-mail: </b></label><input type="text" name="email" value="<?=$email;?>" class="campo" /><br /><br />
  <label><b>Senha: </b></label><input type="password" name="senha" class="campo" /><br /><br />
  <input type="hidden" name="cod" value="<?=$cod;?>" />
  <input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
  </form>
<?php

if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>