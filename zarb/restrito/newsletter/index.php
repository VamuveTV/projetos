<?php

//include("sessao.php");
include("../bd.php");

$acao = $_POST["acao"];

if($acao == "Enviar Newsletter"){
  extract($_POST);
  
  $headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: Strema Tecnologia <contato@strema.com.br>\r\n";
  
  $query = "SELECT codigo, nome, url, imagem FROM pecas WHERE codigo='$news' ";
  $res = mysql_query($query);
  list($cod, $assunto, $url, $imagem)=mysql_fetch_row($res);
  
  if($url)
    $mensagem = "<a href='http://$url'>";
  
  $mensagem.= "<img src='http://www.zarbsolution.com.br/restrito/newsletter/arquivos/$_SESSION[cliente_usu]/$imagem' border='0' />";
  
  if($url)
    $mensagem.= "</a>";
  
  $sql = "SELECT nome, email FROM news WHERE codigo > 0 AND cliente='$_SESSION[cliente_usu]'";
  if($usuario)
    $sql.= "AND email='$usuario' ";
  
  $res = mysql_query($sql);
  $erro = $ct = 0;
  while(list($nome,$email)=mysql_fetch_row($res))
  {
    if (!mail($email,$assunto,$mensagem,$headers))
      $erro++;
      
      $ct++;
  }
  
  if($erro == 0)
    $msg = "Mensagem enviada com sucesso para $ct.<br>$erro mensagens n&atilde;o puderam ser enviadas";
  
  unset($_POST);
  unset($_GET);
  
}
else if($acao=="Gravar")
{
  extract($_POST);
  $nome_banco = $_FILES['arquivo']['name'];
  $caminho = "../restrito/newsletter/arquivos/$_SESSION[cliente_usu]/$nome_banco";	
  $query = "INSERT INTO pecas(codigo, cliente, nome, imagem, url) VALUES";
  $query.= "('','$_SESSION[cliente_usu]','$nome','$nome_banco','$url')";
  $res = mysql_query($query);
  if($res)
  {
      if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho))
      {
        $msg = "Arquivo enviado com sucesso";
        unset($_POST);
        $funcao = "Gravar";
      }
      else
      {
        $msg = "Falha ao enviar o arquivo";
        $funcao = "Gravar";
      } 
 }else{
  $msg = "Falha no cadastro. Tente mais tarde<br>".mysql_error();
    
    unset($_POST);
	  $funcao = "Gravar";
	}
} 
else if($acao=="Salvar")
{
  extract($_POST);

  $nome_banco = $_FILES['arquivo']['name'];
  $caminho = "../admin/newsletter/arquivos/$_SESSION[cliente_usu]/$nome_banco";
  
  $query = "UPDATE pecas SET nome='$nome', url='$url'";	
  if($nome_banco){
    $query.= ", imagem='$nome_banco'";
    move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho);
  }
    
  $query.= " WHERE codigo='$cod' ";
  $res = mysql_query($query);
  if($res){
    
    $msg = "Newsletter alterada com sucesso.";
  }else
    $msg = "Falha ao alterar.";
    
  $mostra = $tipo;
  unset($_POST);
}else if($_POST["acao"]=="Excluir")
{
  extract($_POST);
  foreach ($pecas as $valor) {
  	mysql_query("DELETE FROM pecas WHERE codigo='$valor'");
  	$msg = "Newsletter removida com sucesso.";
  }
  
  unset($_POST);
  $funcao = "Gravar";
}
else
	$funcao = "Gravar";

?>
<h1>Newsletter</h1>
<script type="text/javascript">
function abre(codigo2)
{
			window.open("visualizarnews.php?codigo="+codigo2, 'banner','top=200,left=400,scrollbars=no,resize=yes,resizable=yes');			
}

</script>
<?php
if(!$_POST["acao"] && !$_GET["cod"] && !$_GET["param"])
{
?>
<form method="post" action="principal.php?centro=newsletter">
<input type="button" value="Novo" class="botao" onclick="document.location='principal.php?centro=newsletter&param=new'"><br /><br />
<font class="label3">Buscar: </font><input type="text" class="campo_simples" name="nome_busca" /> <input type="submit" name="filtro" value="Pesquisar" class="botao" /><br /><br />
<?php
$sql = "SELECT codigo, nome, imagem, url FROM pecas WHERE cliente='$_SESSION[cliente_usu]' ";
if($_POST["nome_busca"])
  $sql.= "WHERE nome LIKE '%$_POST[nome_busca]%' ";
$sql.= "ORDER BY nome ";

$res = mysql_query($sql);
if(mysql_num_rows($res)>0)
{
  echo "<table width='100%'>
        <tr class='tbltitle'>
          <th style='width:3px'></th>
          <th width='33%'>Nome</th>
          <th width='33%'>Imagem</th>
          <th width='33%'>URL</th>
        </tr>";
  while(list($cod,$nome,$imagem,$url)=mysql_fetch_row($res))
  {
      echo "<tr class='tbldados'>
              <td style='width:3px'><input type='checkbox' name='pecas[]' value='$cod' /></td>
              <td><a href='principal.php?centro=newsletter&cod=$cod'>$nome</a></td>
              <td><a href='principal.php?centro=newsletter&cod=$cod'>$imagem</a></td>
              <td><a href='principal.php?centro=newsletter&cod=$cod'>$url</a></td>
            </tr>";
  }
  echo "</table>";
?>
<br />
<input type="submit" name="acao" value="Excluir" class="botao" />
</form>
<br />
<?
}
?>
<h1>Enviar Newsletter</h1>
<form method='post' action='principal.php?centro=newsletter'>
<label>Newsletter:</label> <select name='news' class='campo'>
      <?php
      $sql = "SELECT codigo, nome FROM pecas WHERE cliente='$_SESSION[cliente_usu]' ORDER BY nome ";
      $res = mysql_query($sql);
      while(list($cod,$nome)=mysql_fetch_row($res)){
        echo "<option value='$cod'>$nome</option>";
      }
      ?>
      </select><br /><br />
<label>Para:</label> <select name='usuario' class='campo'>
        <option value=''>Todos</option>
      <?php
      $sql = "SELECT nome, email FROM news ORDER BY nome ";
      $res = mysql_query($sql);
      while(list($nome,$email)=mysql_fetch_row($res)){
        echo "<option value='$email'>$nome</option>";
      }
      ?>
      </select><br /><br />
<input type='submit' name='acao' value='Enviar Newsletter' class='botao3'>
</form>
<br />
<?php
}
else{
if($cod)
{
  $query = "SELECT codigo, nome, imagem, url FROM pecas WHERE codigo='$cod'";
  $res =  mysql_query($query);
  
  list($cod,$nome,$imagem,$url) = mysql_fetch_row($res);
  $funcao="Salvar";
}
?>
<form method="post" name="video" action="principal.php?centro=newsletter" onsubmit="return valida()" enctype="multipart/form-data" >
<label>Nome:</label> <input type="text" name="nome" value="<?=$nome ?>" maxlength="40" class="campo" /><br /><br />
<label>URL:</label> <input type="text" name="url" value="<?=$url ?>" class="campo" /><br /><br />
<label>Imagem:</label> <input type="file" name="arquivo" class="campo" style="margin-left:-3px;" /><br /><br />                    
<?
if($funcao=="Salvar")
  echo "<input type='hidden' name='cod' value='$cod' />";
?>	
<br />		  
<input type="submit" value="<?=$funcao;?>" name="acao" class="botao" /> <input type="reset" value="Limpar" class="botao" />  
</form>
<?
}
if($msg)
  echo "<div id='msg_log'><img src='con_info.png' alt='Mensagem' style='float:left' />&nbsp; $msg</div>";
?>