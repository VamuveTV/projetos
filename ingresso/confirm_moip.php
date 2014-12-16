<?php
$dados = '';
foreach($_POST AS $i => $val){
  $dados.= "$i --- $val<br>";
}

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
$headers .= 'From: MOIP Ingresso Solidário <retorno@ingressosolidario.com>' . "\r\n";            
          
if(mail('fernando@zarbsolution.com.br', 'Retorno Moip', $dados, $headers))
  $msg = "Realizado com sucesso";
else
  $msg = "Falha ao enviar";
  
echo $msg;
?>