<?php
$titulo = "Usu&aacute;rio de Clientes"; //titulo da página
$modulo = "usuclientes"; //módulo atual (mesmo nome da pasta)
$tabela = "usuclientes"; //tabela do banco de dados
$campos = array("cliente","nome","email","senha","ativo");//nome dos campos na tabela.
$dados = array($_POST['cliente'],$_POST['nome'],$_POST['email'],$_POST['senha'],$_POST['ativo']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
<font class="label3">Nome:</font><input type="text" class="campo_simples" name="nome_busca" /> <input type="submit" name="filtro" value="Pesquisar" class="botao" /><br /><br />
<?php
$sql = "Select u.codigo, c.nome, u.nome, u.email From usuclientes As u ";
$sql.= "Inner Join clientes As c On u.cliente = c.codigo Where u.ativo = 'S' ";
if($_POST["nome_busca"])
  $sql.= "And u.nome Like '%$_POST[nome_busca]%' ";
$sql.= "Order By u.nome ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='27%'>Cliente</th>
        <th width='27%'>Nome</th>
        <th width='46%'>E-mail</th>
        </tr>";
  while(list($cod, $cliente, $nome, $email)=mysql_fetch_row($res))
  {
    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$cliente</a></td>
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
else if($_GET["param"]=="new" || $_GET["cod"])
{
  $cod = $_GET["cod"];
  if($cod){
    $fazer="Salvar";
    $sql = "Select codigo, cliente, nome, email, senha, ativo From $tabela Where codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo, $cliente, $nome, $email, $senha, $ativo)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label>Cliente: </label>
    <select name="cliente" class="campo">
      <option value=''>Selecione</option>
      <?php
        $sql = "Select codigo, nome From clientes Order By nome";
        $res = mysql_query($sql);
        while(list($codcliente,$nomecliente)=mysql_fetch_row($res)){
          echo "<option value='$codcliente'";
          echo $cliente==$codcliente?" selected":"";
          echo ">$nomecliente</option>";
        }
      ?>
    </select><br /><br />
  <label><b>Nome: </b></label> <input type="text" name="nome" value="<?=$nome;?>" class="nome"<br /><br />
  <label><b>E-mail: </b></label> <input type="text" name="email" value="<?=$email;?>" class="email" /><br /><br />
  <label><b>Senha: </b></label> <input type="password" name="senha" value="<?=$senha;?>" class="campo" /><br /><br />
  <label><b>Ativo: </b></label><input type="radio" name="ativo" value="S" <? if($ativo=='S')echo "checked";?> />Sim <br />
                               <input type="radio" name="ativo" value="N" <? if($ativo=='N')echo "checked";?> />N&atilde;o 
  <br /><br />
  <?php
  if($cod){
    echo "<input type='hidden' name='cod' value='$cod' />";
  }
  ?>
  <input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
  </form>
<?php
}



if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>