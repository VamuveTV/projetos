<?php
$titulo = "Alunos"; //titulo da página
$modulo = "alunos"; //módulo atual (mesmo nome da pasta)
$tabela = "alunos"; //tabela do banco de dados
$campos = array("nome","email","telefone","cpf","uf","cidade","endereco","bairro","numero","complemento","cep","observacao");//nome dos campos na tabela.
$dados = array($_POST['nome'],$_POST['email'],$_POST['telefone'],$_POST['cpf'],$_POST['estado'],$_POST['cidade'],$_POST['endereco'],$_POST['bairro'],$_POST['numero'],$_POST['complemento'],$_POST['cep'],$_POST['observacao']);//nome dos campos do form, devem seguir ordem dos campos da tabela
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
$sql = "SELECT codigo, nome, email, telefone, cpf, observacao FROM $tabela ";
if($_POST["nome_busca"])
  $sql.= "WHERE nome LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY nome ";
$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
        <th width='2%'><input type=checkbox name='selall' onClick='CheckAll($cod)'></th>
        <th width='20%'>Nome</th>
        <th width='20%'>E-mail</th>
        <th width='10%'>Telefone</th>
        <th width='10%'>CPF</th>
        <th width='30%'>Observa&ccedil;&atilde;o</th>
        </tr>";
  while(list($cod, $nome, $email, $telefone, $cpf, $observacao)=mysql_fetch_row($res))
  {
    $telefone = "$ddd $telefone";
    echo "<tr class='tbldados'>
          <td><input type='checkbox' name='lista[]' value='$cod' /></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$nome</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$email</a></td>
          <td align='center'><a href='principal.php?centro=$modulo&cod=$cod'>$telefone</a></td>
          <td align='center'><a href='principal.php?centro=$modulo&cod=$cod'>$cpf</a></td>
          <td><a href='principal.php?centro=$modulo&cod=$cod'>$observacao</a></td>
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
    $sql = "SELECT codigo, nome, email, telefone, cpf, uf, cidade, endereco, bairro, numero, complemento, cep, observacao FROM $tabela WHERE codigo='$cod' ";
    $res = mysql_query($sql);
    list($codigo, $nome, $email, $telefone, $cpf, $uf, $cidade, $endereco, $bairro, $numero, $complemento, $cep, $observacao)=mysql_fetch_row($res);
  }else
    $fazer="Gravar";
?>
  <form method="post" action="principal.php?centro=<?=$modulo;?>" enctype="multipart/form-data">
  <label>Nome: </label> <input type="text" name="nome" value="<?=$nome;?>" class="nome" />
  <font class="label3">E-mail: </font> <input type="text" name="email" value="<?=$email;?>" class="email" /><br /><br />
  <label>Telefone: </label><input type="text" name="telefone" value="<?=$telefone;?>" style="width: 150px" class="phone" />
  <font class="label3">CPF: </font> <input type="text" id="cpf" name="cpf" value="<?=$cpf;?>" class="cpf" /><br /><br />
  <label>Estado: </label>
    <? if(!$estado)$estado="mg"; ?>
    <select name="estado" class="campo" onchange="busca_cidades('city',this.value);">
       <option value="">Selecione o Estado</option>
       <option value="ac" <? echo $estado=="ac"?" selected":"";?>>Acre</option>
       <option value="al" <? echo $estado=="al"?" selected":"";?>>Alagoas</option>
       <option value="ap" <? echo $estado=="ap"?" selected":"";?>>Amapa</option>
       <option value="am" <? echo $estado=="am"?" selected":"";?>>Amazonas</option>
       <option value="ba" <? echo $estado=="ba"?" selected":"";?>>Bahia</option>
       <option value="ce" <? echo $estado=="ce"?" selected":"";?>>Ceara</option>
       <option value="df" <? echo $estado=="df"?" selected":"";?>>Distrito Federal</option>
       <option value="es" <? echo $estado=="es"?" selected":"";?>>Espirito Santo</option>
       <option value="go" <? echo $estado=="go"?" selected":"";?>>Goias</option>
    	 <option value="ma" <? echo $estado=="ma"?" selected":"";?>>Maranhao</option>
    	 <option value="mt" <? echo $estado=="mt"?" selected":"";?>>Mato Grosso</option>
    	 <option value="ms" <? echo $estado=="ms"?" selected":"";?>>Mato Grosso do Sul</option>
    	 <option value="mg" <? echo $estado=="mg"?" selected":"";?>>Minas Gerais</option>
    	 <option value="pa" <? echo $estado=="pa"?" selected":"";?>>Para</option>
    	 <option value="pb" <? echo $estado=="pb"?" selected":"";?>>Paraiba</option>
    	 <option value="pr" <? echo $estado=="pr"?" selected":"";?>>Parana</option>
       <option value="pe" <? echo $estado=="pe"?" selected":"";?>>Pernambuco</option>
       <option value="pi" <? echo $estado=="pi"?" selected":"";?>>Piaui</option>
       <option value="rj" <? echo $estado=="rj"?" selected":"";?>>Rio de Janeiro</option>
       <option value="rn" <? echo $estado=="rn"?" selected":"";?>>Rio Grande do Norte</option>
       <option value="rs" <? echo $estado=="rs"?" selected":"";?>>Rio Grande do Sul</option>
       <option value="ro" <? echo $estado=="ro"?" selected":"";?>>Rondonia</option>
       <option value="rr" <? echo $estado=="rr"?" selected":"";?>>Roraima</option>
       <option value="sc" <? echo $estado=="sc"?" selected":"";?>>Santa Catarina</option>
       <option value="sp" <? echo $estado=="sp"?" selected":"";?>>Sao Paulo</option>
       <option value="se" <? echo $estado=="se"?" selected":"";?>>Sergipe</option>
       <option value="to" <? echo $estado=="to"?" selected":"";?>>Tocantins</option>
    </select>
  <font class="label3">Cidade: </font>
    <span id="city">
  	<select name="cidades" class="campo">
        <?php
        if(!$cidade)
          $cidade = 24100;
        $query = "SELECT id, municipio FROM cidades WHERE uf='$estado' ";
        $result = mysql_query($query);
        while(list($id, $municipio)=mysql_fetch_row($result)){
          echo "<option value='$id'";
            if($id==$cidade)
              echo " selected";
          echo ">$municipio</option>";
        }
        ?>
    </select></span>
  <br /><br />
  <label>Endere&ccedil;o: </label> <input type="text" name="endereco" value="<?=$endereco;?>" class="endereco" />
  <font class="label3">Bairro: </font> <input type="text" name="bairro" value="<?=$bairro;?>" class="campo" /><br /><br />
  <label>CEP: </label> <input type="text" id="cep" name="cep" value="<?=$cep;?>" class="campo" /><br /><br />
  <label>N&uacute;mero: </label> <input type="text" name="numero" value="<?=$numero;?>" style="width: 50px" class="campo" />
  <font class="label3">Complemento:</font> <input type="text" name="complemento" value="<?=$complemento;?>" class="campo" /><br /><br />
  <label>Observação: </label> <textarea name="observacao" rows="6" cols="65" style='border: 1px #444 solid;font-family:verdana;font-size: 11px;padding: 4px'><?=$observacao;?></textarea><br /><br />
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