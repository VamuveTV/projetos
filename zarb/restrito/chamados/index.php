<?php
$tit = "Chamados"; //titulo da página
$modulo = "chamados"; //módulo atual (mesmo nome da pasta)
define("CODADMIN","1");//código da Zarb Solution na tabela clientes
$horainteracao = date("H:i");

//-------------------------------------------------------------------------
// INICIO DAS FUNCIONALIDADE REFERENTES AO BANCO DE DADOS                //
//-------------------------------------------------------------------------
if($_GET['reabrir']==1 && $_GET['cod']){
  $cod = $_GET['cod'];
  $sql = "UPDATE chamado SET status='A' WHERE codigo='$cod' ";
  $res = mysql_query($sql);         
  if($res){
    $msg = "Chamado modificado com sucesso.";
    $sql2 = "INSERT INTO interacoes (chamado_id, cliente_id, usuario_id, data, hora, texto) ";
    $sql2.= "VALUES ('$cod', '$_SESSION[cliente_usu]', '$_SESSION[cod_usu]', '$hoje', '$horainteracao', 'Status Retornado para Em Aberto') ";
    $res2 = mysql_query($sql2);
  }
  else
    $msg = "Falha: ".mysql_error();
}
if($_POST["acao"]=="Gravar")//se selecionado opção de inserir novo registro
{
  extract($_POST);
  $sql = "INSERT INTO chamado(data, hora, cliente, usuario, sistema, tipo, setor, descricao, status, aprovado) ";
  $sql.= "VALUES ('$hoje','$hora','$_SESSION[cliente_usu]','$_SESSION[cod_usu]','$sistema','$tipo','$setor','$descricao','A','N')";
  $res = mysql_query($sql);
  if($res){
      $msg = "Chamado cadastrado com sucesso.";
  }
  else
    $msg = "Falha: ".mysql_error();

  unset($_POST['acao']);
}
else if($_POST["acao"]=="Salvar")//se selecionado opção de alterar registro
{
  extract($_POST);
  if($aprovado == "")
     $aprovado = "N";
  if($aprovado == "S")
    $status = "C";
  $hora = date("H:i");
  
  //buscand o status atual para verificar se haverá mudança de status. Se sim, deve gravar um interação
  $sql = "SELECT status FROM chamado WHERE codigo='$cod'";
  $res = mysql_query($sql);
  list($status_old)=mysql_fetch_row($res);
  if($status && ($status_old != $status)){
    switch($status){
    case "A":
      $stat = "Aberto";
      break;
    case "E":
      $stat = "Em Andamento";
      break;
    case "C":
      $stat = "Conclu&iacute;do";
      break;
    }
        
    $sql2 = "INSERT INTO interacoes (chamado_id, cliente_id, usuario_id, data, hora, texto) ";
    $sql2.= "VALUES ('$cod', '$_SESSION[cliente_usu]', '$_SESSION[cod_usu]', '$hoje', '$horainteracao', 'Status Alterado para $stat') ";
    $res2 = mysql_query($sql2);
  }
  
  $sql = "UPDATE chamado SET data='$hoje', hora='$hora', sistema='$sistema', ";
  $sql.= "tipo='$tipo', setor='$setor', descricao='$descricao' ";
  if($status)
    $sql.= ", status='$status' ";
  if($aprovado)
    $sql.= ", aprovado='$aprovado' ";
    
  $sql.= "WHERE codigo='$cod' ";
  $res = mysql_query($sql);         
  if($res){
    $msg = "Chamado modificado com sucesso.";
  }
  else
    $msg = "Falha: ".mysql_error();

  unset($_POST['acao']);
}else if($_POST["acao"]=="Excluir")//se selecionado opção de excluir registros
{
  extract($_POST);
  foreach ($lista as $valor) {
  	mysql_query("DELETE FROM chamado WHERE codigo='$valor'");
  }

  unset($_POST['acao']);
}
//----------------------------------------------------------------------------
// FIM DAS FUNCIONALIDADE REFERENTES AO BANCO DE DADOS E INICIO DO CONTEÚDO //
//----------------------------------------------------------------------------
?>
<h1><?=$tit;?></h1>
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
  Buscar: <input type="text" class="campo_simples" name="nome_busca" />
  Status:  
    <select name='status_busca' class='campo_simples'>
      <option value=''>Todos</option>
      <option value='A'>Abertos</option>
      <option value='E'>Em andamento</option>
      <option value='C'>Conclu&iacute;dos</option>
    </select>
  Aprovado:  
    <select name='aprovado_busca' class='campo_simples'>
      <option value=''>Todos</option>
      <option value='S'>Sim</option>
      <option value='N'>N&atilde;o</option>
    </select><br /><br />
  <input type="submit" name="filtro" value="Pesquisar" class="botao" /><br /><br />
  <?php
  //buscando os registro já gravados
  $sql = "SELECT c.codigo, cl.nome, u.nome, s.sistema, c.tipo, c.setor, c.status, c.aprovado ";
  $sql.= "FROM chamado As c Inner Join clientes As cl On c.cliente = cl.codigo ";
  $sql.= "INNER JOIN usuclientes As u On c.usuario = u.codigo ";
  $sql.= "INNER JOIN sistema As s On c.sistema = s.codigo WHERE c.codigo > 0 ";
  if($_SESSION[cliente_usu] != CODADMIN) //SE for alguem da zarb logado lista todos chamados
      $sql.= "AND c.cliente='$_SESSION[cliente_usu]' ";
  if($_POST["nome_busca"])
    $sql.= "AND (cl.nome Like '%$_POST[nome_busca]%' OR c.descricao LIKE '%$_POST[nome_busca]%')";
  if($_POST['status_busca'])
    $sql.= "AND c.status='$_POST[status_busca]' ";
  if($_POST['aprovado_busca'])
    $sql.= "AND c.aprovado='$_POST[aprovado_busca]' ";
  
  $sql.= "ORDER BY c.codigo DESC ";
  $res = mysql_query($sql);
  if(mysql_num_rows($res)>0)
  {
    echo "<table width='100%'>
          <tr class='tbltitle'>
          <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
          <th width='3%'>C&oacute;digo</th>
          <th width='15%'>Cliente</th>
          <th width='15%'>Usu&aacute;rio</th>
          <th width='15%'>Sistema</th>
          <th width='15%'>Tipo</th>
          <th width='15%'>Setor</th>
          <th width='15%'>Status</th>
          <th width='15%'>Aprovado</th>
          </tr>";
    while(list($cod,$cliente,$usuario,$sistema,$tipo,$setor,$status,$aprovado)=mysql_fetch_row($res))
    {
      switch($aprovado){
        case 'S':
          $aprovado = "Sim";break;
        case 'N':
          $aprovado = "N&atilde;o";
      }
      switch($tipo){
        case 'S':
          $tipo = "Suporte";break;
        case 'D':
          $tipo = "Desenvolvimento";break;
        case 'O':
          $tipo = "Or&ccedil;amento";break;
        case 'V':
          $tipo = "Visita";break;
  
          default;
  
      }
  
      switch($setor){
        case 'T':
          $setor = "T&eacute;cnico";break;
        case 'C':
          $setor = "Comercial";break;
        case 'D':
          $setor = "Diretoria";
  
      }
  
      switch($status){
        case "A":
          $status = "Aberto";
          break;
        case "E":
          $status = "Em Andamento";
          break;
        case "C":
          $status = "Conclu&iacute;do";
          break;
        }
  
      if($status == "Aberto"){
        echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td align='center'><a class='aberto' href='principal.php?centro=$modulo&cod=$cod'>$cod</a></td>
          <td><a class='aberto' href='principal.php?centro=$modulo&cod=$cod'>$cliente</a></td>
          <td><a class='aberto' href='principal.php?centro=$modulo&cod=$cod'>$usuario</a></td>
          <td><a class='aberto' href='principal.php?centro=$modulo&cod=$cod'>$sistema</a></td>
          <td><a class='aberto' href='principal.php?centro=$modulo&cod=$cod'>$tipo</a></td>
          <td><a class='aberto' href='principal.php?centro=$modulo&cod=$cod'>$setor</a></td>
          <td><a class='aberto' href='principal.php?centro=$modulo&cod=$cod'>$status</a></td>
          <td><a class='aberto' href='principal.php?centro=$modulo&cod=$cod'>$aprovado</a></td>
        </tr>";
      }
      if($status == "Em Andamento"){
        echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td align='center'><a class='andamento' href='principal.php?centro=$modulo&cod=$cod'>$cod</a></td>
          <td><a class='andamento' href='principal.php?centro=$modulo&cod=$cod'>$cliente</a></td>
          <td><a class='andamento' href='principal.php?centro=$modulo&cod=$cod'>$usuario</a></td>
          <td><a class='andamento' href='principal.php?centro=$modulo&cod=$cod'>$sistema</a></td>
          <td><a class='andamento' href='principal.php?centro=$modulo&cod=$cod'>$tipo</a></td>
          <td><a class='andamento' href='principal.php?centro=$modulo&cod=$cod'>$setor</a></td>
          <td><a class='andamento' href='principal.php?centro=$modulo&cod=$cod'>$status</a></td>
          <td><a class='andamento' href='principal.php?centro=$modulo&cod=$cod'>$aprovado</a></td>
        </tr>";
      }
      if($status == "Conclu&iacute;do"){
        echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td align='center'><a class='concluido' href='principal.php?centro=$modulo&cod=$cod'>$cod</a></td>
          <td><a class='concluido' href='principal.php?centro=$modulo&cod=$cod'>$cliente</a></td>
          <td><a class='concluido' href='principal.php?centro=$modulo&cod=$cod'>$usuario</a></td>
          <td><a class='concluido' href='principal.php?centro=$modulo&cod=$cod'>$sistema</a></td>
          <td><a class='concluido' href='principal.php?centro=$modulo&cod=$cod'>$tipo</a></td>
          <td><a class='concluido' href='principal.php?centro=$modulo&cod=$cod'>$setor</a></td>
          <td><a class='concluido' href='principal.php?centro=$modulo&cod=$cod'>$status</a></td>
          <td><a class='concluido' href='principal.php?centro=$modulo&cod=$cod'>$aprovado</a></td>
        </tr>";
     }
    }
    echo "</table>";
  ?>
  <br />
  <input type="submit" name="acao" value="Excluir" class="botao" />
  </form>
  <?
  }
  else
    echo "Nenhum Chamado foi encontrado";
}
else if($_GET["param"]=="new" || $_GET["cod"])//ÁREA NOVO REGISTRO OU EDITAR
{
  $cod = $_GET["cod"];
  if($cod){//SE EXISTE VARIÁVEL _GET COD, BUSCA DADOS PARA EDIÇÃO
    $fazer="Salvar";
    $sql = "SELECT cliente, usuario, sistema, tipo, setor, descricao, status, aprovado ";
    $sql.= "FROM chamado WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($cliente,$usuario,$sistema,$tipo,$setor,$descricao,$status,$aprovado)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";

  $hoje = converte_data($hoje,"usuario");
  $hora = date("H:i");

?>
<form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
<label>Data: <font style="font-size:11"><?=$hoje;?></font></label><font class="label3">Hora: <font style="font-size:11"><?=$hora;?></font></font><br /><br />
<label>Sistema: </label>
  <select name="sistema" class="campo">
    <option value="">Selecione </option>
      <?php
        $sql = "SELECT codigo, descricao FROM sistema ORDER BY descricao";
        $res = mysql_query($sql);
        while(list($codi_sistema,$nome_sistema)=mysql_fetch_row($res)){
          if($codi_sistema == $sistema)
            echo " <option value= '$codi_sistema' selected >$nome_sistema</option>";
          else
            echo " <option value= '$codi_sistema'>$nome_sistema</option>";
        }
      ?>
  </select><br /><br />
<label>Tipo: </label>
  <select name="tipo" class="campo">
    <option value="">Selecione </option>
    <option value="S" <? if($tipo == 'S') echo "selected"; ?> >Suporte</option>
    <option value="D" <? if($tipo == 'D') echo "selected"; ?> >Desenvolvimento</option>
    <option value="O" <? if($tipo == 'O') echo "selected"; ?> >Or&ccedil;amento</option>
    <option value="V" <? if($tipo == 'V') echo "selected"; ?> >Visita</option>
  </select><br /><br />
<label>Setor: </label>
  <select name="setor" class="campo">
    <option value="" >Selecione </option>
    <option value="T" <? if($setor == 'T') echo "selected"; ?> >T&eacute;cnico</option>
    <option value="C" <? if($setor == 'C') echo "selected"; ?> >Comercial</option>
    <option value="D" <? if($setor == 'D') echo "selected"; ?> >Diretoria</option>
  </select><br /><br />
<label>Descri&ccedil;&atilde;o: </label>
<?
//incluindo textarea com recurso javascript de editor (spaw)
include("spaw2/spaw.inc.php");
$spaw1 = new SpawEditor("descricao","$descricao","","","","","160");
$spaw1->show();
?><br /><br />
<?
if($cod){
?>
<label>Status: </label>
    <?php
    if($_SESSION[cliente_usu] != CODADMIN) //Se for alguem da zarb exibe select para edição do status, senao apenas exibe o status
      {
      switch($status){
        case "A":
          $status = "Aberto";
          break;
        case "E":
          $status = "Em Andamento";
          break;
        case "C":
          $status = "Conclu&iacute;do";
          break;
        }
      echo "<font class=\"label3\">$status</font>";
      }
    else{
      if($status != "C"){
        echo "<input type=\"radio\" name=\"status\" value=\"A\" "; if($status == "A") echo "checked"; echo "/>Aberto 
              <input type=\"radio\" name='status' value='E' "; if($status == "E") echo "checked"; echo "/>Em Andamento 
              <input type=\"radio\" name='status' value='C' "; if($status == "C") echo "checked"; echo "/>Conclu&iacute;do <br />";
        }
      else{
        if($status == "C"){
          echo "Conclu&iacute;do";
          echo "<a href='principal.php?centro=$modulo&cod=$cod&reabrir=1' style='margin-left: 30px;color:blue;font-weight:bold'>Retornar chamado para 'Em Aberto'</a>";
        }
      }
    }
    echo "<br /><br />";

  if(($status == "C" || $status == "Conclu&iacute;do") && $_SESSION[cliente_usu] != CODADMIN){
    echo "<label>Aprovado: </label>
      <input type=\"radio\" name=\"aprovado\" value=\"S\" "; if($aprovado == "S") echo "checked"; echo "/>Sim <br />
      <input type=\"radio\" name=\"aprovado\" value=\"N\" "; if($aprovado == "N") echo "checked"; echo "/>N&atilde;o <br /><br /> ";
  }
}
?>
<input type="hidden" name="cod" value="<?=$cod;?>" />
<input type="submit" name="acao" value="<?=$fazer;?>" class="botao" />
</form>
<?php
if($cod){
  echo "<div id=\"bordertop\"></div><br />
  <h1 style=\"float:left\">Intera&ccedil;&otilde;es</h1>
  <input type=\"button\" value=\"Ver conversa\" class=\"botaodireita\" onclick=\"window.open('chamados/conversa.php?cod=$cod')\" />
  <div class=\"clear\"></div> ";

}

if($_POST["acao"]=="Enviar"){
  $hoje = converte_data($hoje,"banco");
  $sql = "INSERT INTO interacoes (chamado_id, cliente_id, usuario_id, data, hora, texto) ";
  $sql.= "VALUES ('$cod', '$_SESSION[cliente_usu]', '$_SESSION[cod_usu]', '$hoje', '$horainteracao', '$texto') ";
  $res = mysql_query($sql);
}

unset($_POST['acao']);
?>
<form method="post" action="" enctype="multipart/form-data">
<?
if($cod){//se estiver editando o chamado, exibe as interações
$sql = "SELECT i.chamado_id, c.nome, u.nome, i.data, i.hora, i.texto FROM interacoes AS i ";
$sql.= "INNER JOIN clientes AS c ON i.cliente_id = c.codigo INNER JOIN usuclientes AS u ON i.usuario_id = u.codigo ";
$sql.= "INNER JOIN chamado AS ch ON i.chamado_id = ch.codigo WHERE i.chamado_id = '$cod' ORDER BY i.codigo DESC LIMIT 0,5";
$res = mysql_query($sql);
if(mysql_num_rows($res) > 0)
{
  echo "<div id='interacoes'> ";
  while(list($cod,$cliente,$usuario,$data,$hora,$texto)=mysql_fetch_row($res)){
    $data = converte_data($data,"usuario");
    echo "<label class=\"interacoes\">$cliente - $usuario<br />$data - $hora : $texto<br /></label><br /><br /><br />";
  }
  echo "</div>";
}
?>
<font class="label3">Data: <font style="font-size:11"><?=$hoje;?></font></font><font class="label3">Hora: <font style="font-size:11"><?=$horainteracao;?></font></font><br /><br />
<font class="label3">Texto: </font><textarea name="texto" cols="50" rows="4" class="textarea"></textarea><br /><br />
<input type="submit" name="acao" value="Enviar" class="botao" />
</form>
<?php
}
}
if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>