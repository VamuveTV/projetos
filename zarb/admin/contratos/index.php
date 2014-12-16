<?php
$titulo = "Contratos"; //titulo da página
$modulo = "contratos"; //módulo atual (mesmo nome da pasta)
$tabela = "contratos"; //tabela do banco de dados
$campos = array("cliente_id","servico_id","inicio","fim","vencimento","valor");//nome dos campos na tabela.
$_POST['inicio'] = converte_data($_POST['inicio'],'banco');
$_POST['fim'] = converte_data($_POST['fim'],'banco');
$dados = array($_POST['cliente_id'],$_POST['servico_id'],$_POST['inicio'],$_POST['fim'],$_POST['vencimento'],$_POST['valor']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
$sql = "SELECT c.codigo, cli.nome, s.nome, c.inicio, c.fim, c.vencimento, c.valor FROM $tabela AS c, clientes AS cli, servicos AS s WHERE c.cliente_id = cli.codigo AND c.servico_id = s.codigo ";
if($_POST["nome_busca"])
  $sql.= "AND cli.nome LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY c.cliente_id ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo  "$sql<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='25%'>Cliente</th>
        <th width='25%'>Nome Servi&ccedil;o</th>
        <th width='10%'>Inicio</th>
        <th width='10%'>Fim</th>
        <th width='10%'>Vencimento</th>
        <th width='10%'>Valor</th>
        </tr>";
  while(list($cod, $nomecliente, $nomeservico, $inicio, $fim, $vencimento, $valor)=mysql_fetch_row($res))
  {
     $inicio = converte_data($inicio,'usuario');
     $fim = converte_data($fim,'usuario');
      echo "<tr class='tbldados'>
            <td><input type='checkbox' name='lista[]' value='$cod' /></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$nomecliente</a></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$nomeservico</a></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$inicio</a></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$fim</a></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$vencimento</a></td>
            <td><a href='principal.php?centro=$modulo&cod=$cod'>$valor</a></td>
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
    $sql = "SELECT codigo, cliente_id, servico_id, inicio, fim, vencimento, valor FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo, $cliente_id, $servico_id, $inicio, $fim, $vencimento, $valor )=mysql_fetch_row($res);
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
       echo " </select><br /><br />";
         ?>

            <label><b>Servi&ccedil;o: </b></label>
            <select name="servico_id" class="campo">
            <option value=''>Selecione</option>"
        <?
       $sql2 = "SELECT codigo, nome FROM servicos ORDER BY nome";
        $res2 = mysql_query($sql2);
        while(list($codservico,$nomeservico)=mysql_fetch_row($res2)){
          echo "<option value='$codservico'";
          echo $servico_id==$codservico?" selected":"";
          echo ">$nomeservico</option>";
        }
      ?>
    </select><br /><br />
  <label><b>Inicio: </b></label>     <input type="text"   name="inicio"     value="<?=$inicio;?>"      class="data"/><br /><br />
  <label><b>Fim: </b></label>        <input type="text"   name="fim"        value="<?=$fim;?>"         class="data"/><br /><br />
  <label><b>Vencimento: </b></label> <input type="text"   name="vencimento" value="<?=$vencimento;?>"  class="uf"/><br /><br />
  <label><b>Valor: </b></label>      <input type="text"   name="valor"      value="<?=$valor;?>"       class="valor"/><br /><br />
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