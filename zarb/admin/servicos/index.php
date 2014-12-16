<?php
$titulo = "Servi&ccedil;os"; //titulo da página
$modulo = "servicos"; //módulo atual (mesmo nome da pasta)
$tabela = "servicos"; //tabela do banco de dados
$campos = array("cliente_id","nome","descricao");//nome dos campos na tabela.
$dados = array($_POST['cliente_id'],$_POST['nome'],$_POST['descricao']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
$sql = "SELECT s.codigo, c.nome, s.nome, s.descricao FROM $tabela AS s, clientes AS c WHERE s.cliente_id = c.codigo ";
if($_POST["nome_busca"])
  $sql.= "WHERE c.nome LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY c.nome ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='28%'>Cliente</th>
        <th width='28%'>Nome Servi&ccedil;o</th>
        <th width='70%'>Descri&ccedil;&atilde;o</th>
        </tr>";
  while(list($cod, $nomecliente, $nome, $desc)=mysql_fetch_row($res))
  {
      $desc = strip_tags($desc);
      $desc = substr($desc,0,100)."...";
      echo "<tr class='tbldados'>
            <td><input type='checkbox' name='lista[]' value='$cod' /></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$nomecliente</a></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$nome</a></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$desc</a></td>
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
    $sql = "SELECT codigo, cliente_id, nome, descricao FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo, $cliente_id, $nome, $desc)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label><b>Cliente: </b></label>
    <select name="cliente_id" class="campo">
      <option value=''>Selecione</option>
      <?php
        $sql = "SELECT codigo, nome FROM clientes ORDER BY nome";
        $res = mysql_query($sql);
        while(list($codcliente,$nomecliente)=mysql_fetch_row($res)){
          echo "<option value='$codcliente'";
          echo $cliente_id==$codcliente?" selected":"";
          echo ">$nomecliente</option>";
        }
      ?>
    </select><br /><br />
  <label><b>Nome: </b></label> <input type="text" name="nome" value="<?=$nome;?>" class="nome" /><br /><br />
  <label><b>Descri&ccedil;&atilde;o: </b></label> <textarea name="descricao" class="textarea"> <?=$desc;?> </textarea> <br /><br />

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