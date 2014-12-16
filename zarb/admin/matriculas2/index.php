<?php
$titulo = "Matr&iacute;culas"; //titulo da página
$modulo = "matriculas"; //módulo atual (mesmo nome da pasta)
$tabela = "matriculas"; //tabela do banco de dados
$_POST['data'] = converte_data($_POST['data'],"banco");
$campos = array("curso","turma","aluno","pago","data","observacao");//nome dos campos na tabela.
$dados = array($_POST['curso'],$_POST['turma'],$_POST['aluno'],$_POST['pago'],$_POST['data'],$_POST['observacao']);//nome dos campos do form, devem seguir ordem dos campos da tabela
$conn = new ZarbMysql;
//-------------------------------------------------------------------------
// INICIO DAS FUNCIONALIDADE REFERENTES AO BANCO DE DADOS                //
//-------------------------------------------------------------------------
if($_POST["acao"]=="Gravar")//se selecionado gravar
{
$_POST['data'] = converte_data($_POST['data'],"banco");
  $msg = $conn->insere($tabela,$campos,$dados);
  
  unset($_POST);
}
else if($_POST["acao"]=="Salvar")//se selecionado salvar
{
$_POST['data'] = converte_data($_POST['data'],"banco");
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
<h2>Pesquisar</h2>
<font>Aluno: </font><input type="text" class="campo_simples" name="nome_busca" />
<font>Status: </font>
<select name="status_busca" class="campo_simples">
  <option value="">Todos</option>
  <option value="N">N&atilde;o iniciados</option>
  <option value="E">Em Andamento</option>
</select>
<font>Curso: </font>
<select name="curso_busca" class="campo_simples">
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
</select>
<br /><br />
<input type="submit" name="filtro" value="Pesquisar" class="botao" />
<input type="button" value="Novo" class="botao" onclick="document.location='principal.php?centro=<?=$modulo;?>&param=new'" /><br /><br />
<?php
$sql = "SELECT m.codigo, c.nome, a.nome, m.pago, m.data, m.observacao ";
$sql.= "FROM $tabela AS m, cursos AS c, alunos AS a, turmas AS t ";
$sql.= "WHERE m.curso=c.codigo AND m.turma=t.codigo AND m.aluno=a.codigo ";
if($_POST["nome_busca"])
  $sql.= "AND a.nome LIKE '%$_POST[nome_busca]%' ";
if($_POST["status_busca"])
  $sql.= "AND t.status = '$_POST[status_busca]' ";
if($_POST["curso_busca"])
  $sql.= "AND c.codigo = '$_POST[curso_busca]' ";
$sql.= "ORDER BY c.nome, a.nome, m.data DESC ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='15%'>Data</th>
        <th width='20%'>Curso</th>
        <th width='20%'>Aluno</th>
        <th width='15%'>Pago</th>
        <th width='30%'>Observa&ccedil;&atilde;o</th>
        </tr>";
  
  while(list($cod,$nomecurso,$nomealuno,$pago,$data,$obs)=mysql_fetch_row($res))
  {
    if($curso_old != $nomecurso){
      if($curso_old)
        echo "<tr><td colspan='6'>&nbsp;</td></tr>";
      
      echo "<tr><td colspan='6'><h3>$nomecurso</h3></td></tr>";
    }
    $curso_old = $nomecurso;
    $data = converte_data($data,"usuario");
    $pago = $pago=='S'?"Pago":"Em Aberto";
    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$data</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$nomecurso</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$nomealuno</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$pago</a></td>
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
    $sql = "SELECT codigo, curso, turma, aluno, data, pago, observacao FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo, $curso, $turma, $aluno, $data, $pago, $observacao)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label><b>Data: </b></label> <input type="text" name="data" id="data" value="<?=$data=converte_data($data,"usuario");?>" class="data" /><br /><br />
  <label><b>Curso: </b></label> 
    <select name="curso" class="campo" onchange="busca_turma(this.value)">
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
  <label><b>Turma: </b></label> 
    <span id="areaturma">
    <select name="turma" class="campo">
      <option value=''>Selecione</option>
      <?php
          $sql = "SELECT codigo, periodo FROM turmas ORDER BY codigo";
          $res = mysql_query($sql);
          while(list($codturma,$periodo)=mysql_fetch_row($res)){
            echo "<option value='$codturma'";
            echo $turma==$codturma?" selected":"";
            echo ">$periodo</option>";
        }
      ?>
    </select></span><br /><br />
  <label><b>Aluno: </b></label> 
    <select name="aluno" class="campo">
      <option value=''>Selecione</option>
      <?php
        $sql = "SELECT codigo, nome FROM alunos ORDER BY nome";
        $res = mysql_query($sql);
        while(list($codaluno,$nomealuno)=mysql_fetch_row($res)){
          echo "<option value='$codaluno'";
          echo $aluno==$codaluno?" selected":"";
          echo ">$nomealuno</option>";
        }
      ?>
    </select><br /><br />
  <label><b>Pago: </b></label> 
    <select name="pago" class="campo">	
      <option value=''>Selecione</option>
      <option value='S'<?php echo $pago=='S'?" selected":"";?>>Pago</option>
      <option value='N'<?php echo $pago=='N'?" selected":"";?>>Em Aberto</option>
    </select>
  <br /><br />
  <label><b>Observação: </b></label> <input type="text" name="observacao" value="<?=$observacao;?>" class="campo" /><br /><br />
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