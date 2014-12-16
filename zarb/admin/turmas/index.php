<?php
$titulo = "Turmas"; //titulo da página
$modulo = "turmas"; //módulo atual (mesmo nome da pasta)
$tabela = "turmas"; //tabela do banco de dados 
$campos = array("curso","periodo","titulo","turno","carga","pagamento","observacao","status");//nome dos campos na tabela. 
$dados = array($_POST['curso'],$_POST['periodo'],$_POST['titulo'],$_POST['turno'],$_POST['carga'],$_POST['pagamento'],$_POST['observacao'],$_POST['status']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
<font>Nome:</font><input type="text" class="campo_simples" name="nome_busca" /> <input type="submit" name="filtro" value="Pesquisar" class="botao" /><br /><br />
<?php
$sql = "SELECT t.codigo, c.nome, t.periodo, t.turno, t.pagamento, t.observacao FROM $tabela AS t, cursos AS c WHERE t.curso=c.codigo ";
if($_POST["nome_busca"])
  $sql.= "AND t.turno LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY c.nome, t.turno ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='13%'>Curso</th>
        <th width='25%'>Per&iacute;odo</th>
        <th width='10%'>Turno</th>
        <th width='25%'>Pagamento</th>
        <th width='25%'>Observa&ccedil;&atilde;o</th>
        </tr>";
  while(list($cod, $nomecurso, $periodo, $turno, $pagamento, $obs)=mysql_fetch_row($res))
  {
    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$nomecurso</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$periodo</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$turno</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$pagamento</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$obs</a></td>
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
    $sql = "SELECT codigo, curso, periodo, titulo, turno, carga, pagamento, observacao, status FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo, $curso, $periodo, $titulo, $turno, $carga, $pagamento, $observacao, $status)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label><b>Curso: </b></label> 
    <select name="curso" class="campo">
      <option value=''>Selecione</option>
      <?php
        $sql = "SELECT codigo, nome FROM cursos ORDER BY nome";
        $res = mysql_query($sql);
        while(list($codcurso,$nomecurso)=mysql_fetch_row($res)){
          echo "<option value='$codcurso'";
          echo $curso==$codcurso?" selected":"";
          echo ">$nomecurso</option>";
        }
      ?>
    </select><br /><br />
  <label><b>T&iacute;tulo: </b></label> <input type="text" name="titulo" value="<?=$titulo;?>" class="campo" /><br /><br />
  <label><b>Per&iacute;odo: </b></label> <input type="text" name="periodo" value="<?=$periodo;?>" class="campo" /><br /><br />
  <label><b>Turno: </b></label> <input type="text" name="turno" value="<?=$turno;?>" class="campo" /><br /><br />
  <label><b>Carga horária: </b></label> <input type="text" name="carga" value="<?=$carga;?>" class="campo" /><br /><br />
  <label><b>Forma de Pagamento: </b></label> <input type="text" name="pagamento" value="<?=$pagamento;?>" class="campo" /><br /><br />
  <label><b>Observação: </b></label> <input type="text" name="observacao" value="<?=$observacao;?>" class="campo" /><br /><br />
  <label><b>Status: </b></label> 
    <select name="status" class="campo">
      <option value=''>Selecione</option>
      <option value='N' <? echo $status=='N'?"selected":"";?>>N&atilde;o iniciado</option>
      <option value='E' <? echo $status=='E'?"selected":"";?>>Em andamento</option>
    </select>
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