<?php
$titulo = "Pagamento de Funcion&aacute;rio"; //titulo da página
$modulo = "pagamentos"; //módulo atual (mesmo nome da pasta)
$tabela = "pagamentos"; //tabela do banco de dados
$pag_mensal = str_replace(",",".",$_POST['pag_mensal']);
$adiantamento = str_replace(",",".",$_POST['adiantamento']);
$vale_transporte = str_replace(",",".",$_POST['vale_transporte']);
$valor_comissao = str_replace(",",".",$_POST['valor_comissao']);
$almoco = str_replace(",",".",$_POST['almoco']);
$data = converte_data($data,"banco");
$campos = array("data","funcionario_id","pag_mensal","adiantamento","vale_transporte","almoco","comissao_id","valor_comissao");//nome dos campos na tabela.
$dados = array($data,$_POST['funcionario_id'],$pag_mensal,$adiantamento,$vale_transporte,$almoco,$_POST['comissao_id'],$valor_comissao);//nome dos campos do form, devem seguir ordem dos campos da tabela
$conn = new ZarbMysql;
//-------------------------------------------------------------------------
// INICIO DAS FUNCIONALIDADE REFERENTES AO BANCO DE DADOS                //
//-------------------------------------------------------------------------
if($_POST["acao"]=="Gravar")//se selecionado gravar
{
  $pag_mensal = str_replace(",",".",$_POST['pag_mensal']);
  $adiantamento = str_replace(",",".",$_POST['adiantamento']);
  $vale_transporte = str_replace(",",".",$_POST['vale_transporte']);
  $valor_comissao = str_replace(",",".",$_POST['valor_comissao']);
  $almoco = str_replace(",",".",$_POST['almoco']);
  $data = converte_data($data,"banco");
  $msg = $conn->insere($tabela,$campos,$dados);

  unset($_POST);
}
else if($_POST["acao"]=="Salvar")//se selecionado salvar
  {
  $pag_mensal = str_replace(",",".",$_POST['pag_mensal']);
  $adiantamento = str_replace(",",".",$_POST['adiantamento']);
  $vale_transporte = str_replace(",",".",$_POST['vale_transporte']);
  $valor_comissao = str_replace(",",".",$_POST['valor_comissao']);
  $almoco = str_replace(",",".",$_POST['almoco']);
  $data = converte_data($data,"banco");
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
<?
$data_hoje = date("Y-mm-dd");
$data_hoje = converte_data($data_hoje,"usuario");
?>
<form method="post" action="principal.php?centro=<?=$modulo;?>" name="index">
<input type="button" value="Novo" class="botao" onclick="document.location='principal.php?centro=<?=$modulo;?>&param=new'" /><br /><br />
<font class="label3">Funcion&aacute;rio: </font>
  <select name="funcionario_busca" class="campo" >
      <option value="">Selecione</option>
      <?
        $sql = "SELECT codigo, nome FROM funcionarios ORDER BY nome ";
        $res = mysql_query($sql);
          while(list($cod_funcionario,$nome_funcionario)=mysql_fetch_row($res)){
              echo "<option value=\"$cod_funcionario\" >$nome_funcionario</option>";
          }
      ?>
    </select>
<font class="label3">Data incial: </font>
  <input type="text" class="data" name="datai" />
<font class="label3">Data final: </font>
  <input type="text" class="data" name="dataf" value="<?=$data_hoje;?>" /><br /><br />
<input type="submit" name="filtro" value="Pesquisar" class="botao" /><br /><br />
<?php
$datai = converte_data($datai,"banco");
$dataf = converte_data($dataf,"banco");
$sql = "SELECT p.codigo, p.data, f.nome, p.pag_mensal, p.adiantamento, p.vale_transporte, p.comissao_id, p.valor_comissao, s.nome ";
$sql.= "FROM $tabela AS p INNER JOIN funcionarios AS f ON p.funcionario_id = f.codigo LEFT JOIN servicos AS s ON s.codigo=p.comissao_id WHERE p.codigo > 0 ";
  if($_POST[funcionario_busca])
    $sql.= "AND p.funcionario_id = '$funcionario_busca' ";
  if($_POST[datai])
      $sql.= "AND p.data >= '$datai' ";
  if($_POST[dataf])
    $sql.= "AND p.data <= '$dataf' ";
$sql.= "ORDER BY p.data ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='1%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='10%'>Data</th>
        <th width='20%'>Funcion&aacute;rio</th>
        <th width='10%'>Pagamento</th>
        <th width='10%'>Adiantamento</th>
        <th width='10%'>Vale Transporte</th>
        <th width='10%'>Almo&ccedil;o</th>
        <th width='10%'>Comissao</th>
        <th width='10%'>Valor Comissao</th>
        </tr>";
  while(list($cod,$data,$nome_funcionario,$pag_mensal,$adiantamento,$vale_transporte,$comissao_id,$valor_comissao,$nome_comissao)=mysql_fetch_row($res))
  {

  $data = converte_data($data,"usuario");

    if(!$nome_comissao)
      $nome_comissao = "Sem comiss&atilde;o";

    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td align='center'><a href='principal.php?centro=$modulo&cod=$cod'>$data</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$nome_funcionario</a></td>
          <td align='right'><a href='principal.php?centro=$modulo&cod=$cod'>R$ ".str_replace(".",",",$pag_mensal)."</a></td>
          <td align='right'><a href='principal.php?centro=$modulo&cod=$cod'>R$ ".str_replace(".",",",$adiantamento)."</a></td>
          <td align='right'><a href='principal.php?centro=$modulo&cod=$cod'>R$ ".str_replace(".",",",$vale_transporte)."</a></td>
          <td align='right'><a href='principal.php?centro=$modulo&cod=$cod'>R$ ".str_replace(".",",",$almoco)."</a></td>
          <td align='right'><a href='principal.php?centro=$modulo&cod=$cod'>$nome_comissao</a></td>
          <td align='right'><a href='principal.php?centro=$modulo&cod=$cod'>R$ ".str_replace(".",",",$valor_comissao)."</a></td>
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
    $sql = "SELECT codigo, data, funcionario_id, pag_mensal, adiantamento, vale_transporte, almoco, comissao_id, valor_comissao FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo,$data,$funcionario_id,$pag_mensal,$adiantamento,$vale_transporte,$almoco,$comissao_id,$valor_comissao)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";

    $_POST["funcionario_id"] = $funcionario_id;
    if(!$_POST['funcionario_id']){
?>
<form method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="cod" value="<?=$cod?>" />
  <label>Funcion&aacute;rio: </label>
    <select name="funcionario_id" class="campo" >
      <option value="">Selecione</option>
      <?
        $sql = "SELECT codigo, nome FROM funcionarios ORDER BY nome ";
        $res = mysql_query($sql);
          while(list($cod_funcionario,$nome_funcionario)=mysql_fetch_row($res)){
            if($cod_funcionario==$funcionario_id)
              echo "<option value=\"$cod_funcionario\" selected >$nome_funcionario</option>";
            else
              echo "<option value=\"$cod_funcionario\" >$nome_funcionario</option>";
          }
      ?>
    </select><br /><br />
  <input type="submit" name="acao" value="Selecionar" class="botao" />
  <?
  }
  if($_POST['funcionario_id']){
    $sql = "SELECT nome FROM funcionarios ";
    $sql.= "WHERE codigo = $funcionario_id ";
    $res = mysql_query($sql);
      list($nome_funcionario)=mysql_fetch_row($res);
  ?>
<form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label>Funcion&aacute;rio: </label><font class="campo4"><?=$nome_funcionario;?></font><br /><br />
    <input type="hidden" name="funcionario_id" value="<?=$funcionario_id;?>" />
  <label>Data: </label>
    <input type="text" name="data" class="data" value="<?=$data=converte_data($data,"usuario");?>" /><br /><br />
  <label>Pagamento: </label>
    <input type="text" name="pag_mensal" class="valor" value="<?=$pag_mensal;?>" /><br /><br />
  <label>Adiantamento: </label>
    <input type="text" name="adiantamento" class="valor" value="<?=$adiantamento;?>" /><br /><br />
  <label>Vale Transporte: </label>
    <input type="text" name="vale_transporte" class="valor" value="<?=$vale_transporte;?>" /><br /><br />
  <label>Almo&ccedil;o: </label>
    <input type="text" name="almoco" class="valor" value="<?=$almoco;?>" /><br /><br />

<?
  $sql2 = "SELECT * FROM funcionarios WHERE comissao = 'S' AND codigo = '$funcionario_id' ";
  $res2 = mysql_query($sql2);
    if(mysql_num_rows($res2)>0){
?>
  <label>Comiss&atilde;o: </label>
    <select name="comissao_id" class="campo">
    <option value="">Selecione</option>
    <?
      $sql = "SELECT codigo, nome FROM servicos ORDER BY nome ";
      $res = mysql_query($sql);
        while(list($cod_comissao,$nome_comissao)=mysql_fetch_row($res)){
          if($cod_comissao==$comissao_id)
            echo "<option value=\"$cod_comissao\" selected >$nome_comissao</option>";
          else
            echo "<option value=\"$cod_comissao\" >$nome_comissao</option>";
        }
    ?>
    </select>
  <font class="label3">Valor: </font>
    <input type="text" name="valor_comissao" class="valor" value="<?=$valor_comissao;?>" /><br /><br />
<?
  }
?>
  <input type="hidden" name="cod" value="<?=$cod;?>" />
  <input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
  </form>
  <?
  }
  ?>
  </form>
<?php
}
if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>