<?php
$acao  = $_POST["acao"];
if($acao=="Enviar")
{
  if($nome && $email && $assunto && $msg)
  {
  $headers = "From: Zarb Solution <zarbsolution@zarbsolution.com.br>\n";

  $mensagem = "Dados: \n";
  $mensagem.= "Nome: $nome\n";
  $mensagem.= "Email: $email\n";
  $mensagem.= "Assunto: $assunto\n";
  $mensagem.= "Mensagem: $msg\n";
  $mensagem.= "****************\n";
  
  $mail_sent = @mail( "fernando@zarbsolution.com.br", "CONTATO VIA SITE", $mensagem, $headers );
  
  if($mail_sent)
    $log = "Seus dados foram enviados com sucesso.";
  else
    $log = "Falha ao enviar dados. Tente mais tarde";
  }
  else
    $log = "Preencha todos os campos.";
}
?>
<h1>Envie sua mensagem</h1>
<form action="index.php?c=contact" method="post">
<table class="tbl" cellpadding="3" cellspacing="1" align="center">
  <tr class="tbl_body">
    <td><b>Nome:</b> </td>
    <td><input type="text" name="nome" size="40" class="campo" /></td>
  </tr>
  <tr class="tbl_body">
    <td><b>Email:</b></td>
    <td><input type="text" name="email" size="40" class="campo" /></td>
  </tr>
  <tr class="tbl_body">
    <td><b>Assunto:</b></td>
    <td><input type="text" name="assunto" size="40" class="campo" /></td>
  </tr>
  <tr class="tbl_body">
    <td><b>Mensagem:</b></td>
    <td>
      <textarea name="msg" class="campo" rows="6" cols="40"></textarea>
    </td>
  </tr>
  <tr class="tbl_body">
    <td colspan="2">
      <input type="submit" name="acao" value="Enviar" class="botao" />
      <input type="reset" name="acao" value="Limpar" class="botao" />
    </td>
  </tr>
</table>
<center><?=$log;?></center>
<br />
<p><b>Telefone:</b> 31 3309-1900<br /></p>
<p><b>E-mail:</b> contato@zarbsolution.com.br</p>
</form>