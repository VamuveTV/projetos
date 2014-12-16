<?php
$titulo = "Cadastro News"; //titulo da página
$modulo = "news"; //módulo atual (mesmo nome da pasta)
$tabela = "news"; //tabela do banco de dados
$campos = array("cliente","nome","email");//nome dos campos na tabela.
$dados = array($_SESSION['cliente_usu'],$_POST['nome'],$_POST['email']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
//SE NENHUM REGISTRO FOI SELECIONADO PARA EDIÇÃO OU NÃO INICIOU NOVO CADASTRO
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
//buscando os registro já gravados
$sql = "SELECT codigo, nome, email FROM $tabela WHERE cliente='$_SESSION[cliente_usu]' ";
if($_POST["nome_busca"])
  $sql.= "WHERE nome LIKE '%$_POST[nome_busca]%' ";
  
$sql.= "ORDER BY codigo ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='38%'>Nome</th>
        <th width='60%'>Email</th>
        </tr>";
  while(list($cod,$nome, $email)=mysql_fetch_row($res))
  {   
      echo "<tr class='tbldados'>
              <td><input type='checkbox' name='lista[]' value='$cod' /></td>
              <td><a href='principal.php?centro=$modulo&cod=$cod'>$nome</a></td>
              <td><a href='principal.php?centro=$modulo&cod=$cod'>$email</a></td>
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
else if($_GET["param"]=="new" || $_GET["cod"])//ÁREA NOVO REGISTRO OU EDITAR
{
  $cod = $_GET["cod"];
  if($cod){//SE EXISTE VARIÁVEL _GET COD, BUSCA DADOS PARA EDIÇÃO
    $fazer="Salvar";
    $sql = "SELECT nome, email FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($nome, $email)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";

?>

  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label>Nome: </label><input type="text" name="nome" value="<?=$nome;?>" class="nome" /><br /><br />
  <label>E-mail: </label><input type="text" name="email" value="<?=$email;?>" class="email" /><br /><br />
  <input type="hidden" name="cod" value="<?=$cod;?>" />
  <input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
  </form>

<?php
}

if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>