<?php
$titulo = "Livro Caixa"; //titulo da página
$modulo = "livrocaixa"; //módulo atual (mesmo nome da pasta)
$tabela = "livrocaixa"; //tabela do banco de dados
$data = converte_data($_POST['data'],"banco");
$campos = array("tipo","data","descricao","valor");//nome dos campos na tabela.
$dados = array($_POST['tipo'],$data,$_POST['descricao'],$_POST['valor']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
<form method="post" action="principal.php?centro=livrocaixa" name="index">
<input type="button" value="Novo" class="botao" onclick="document.location='principal.php?centro=livrocaixa&param=new'" /><br /><br />
<font class="label3">Nome:</font><input type="text" class="campo_simples" name="nome_busca" /> <input type="submit" name="filtro" value="Pesquisar" class="botao" /><br /><br />
<?php
$sql = "SELECT codigo, tipo, data, descricao, valor FROM $tabela ";
if($_POST["nome_busca"])
  $sql.= "WHERE descricao LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY data ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='8%'>Data</th>
        <th width='60%'>Descri&ccedil;&atilde;o</th>
        <th width='15%'>Tipo</th>
        <th width='15%'>Valor</th>
        </tr>";
  while(list($cod, $tipo, $data, $descricao, $valor)=mysql_fetch_row($res))
  {
        $tipo = $tipo=='E'?"Entrada":"Sa&iacute;da";
        $data = converte_data($data,"usuario");
        echo "<tr>
              <td><input type='checkbox' name='movimento[]' value='$cod' /></td>
              <td align='center'><a href='principal.php?centro=livrocaixa&cod=$cod'>$data</a></td>
              <td><a href='principal.php?centro=livrocaixa&cod=$cod'>$descricao</a></td>
              <td><a href='principal.php?centro=livrocaixa&cod=$cod'>$tipo</a></td>
              <td align='right'><a href='principal.php?centro=livrocaixa&cod=$cod'>R$ ".number_format($valor,2,",",".")."</a></td>
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
    $sql = "SELECT codigo, tipo, data, descricao, valor FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo, $tipo, $data, $descricao, $valor)=mysql_fetch_row($res);
    $data = converte_data($data,"usuario");
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=livrocaixa" enctype="multipart/form-data">
  <label>Data: </label>
    <input type="text" name="data" id="data" value="<?=$data;?>" class="data" /><br /><br />
  <label>Descri&ccedil;&atilde;o: </label>
    <input type="text" name="descricao" value="<?=$descricao;?>" style="width:300px" class="campo" /><br /><br />
  <label>Valor: </label>
    <input type="text" name="valor" value="<?=$valor;?>" class="valor" /><br /><br />
  <label>Tipo: </label>
    <input type="radio" name="tipo" value="E" <? echo $tipo=='E'?"checked":"";?>/> Entrada
    <input type="radio" name="tipo" value="S" <? echo $tipo=='S'?"checked":"";?>/> Sa&iacute;da
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