<?php
//conexao com banco de dados
mysql_connect("localhost","pedro_ingresso","ingresso");
mysql_select_db("pedro_ingresso");

function converte_data($dt){
  $hora = substr($dt,10);
  $dt = substr($dt,0,10);
  return substr($dt,-2).'/'.substr($dt,5,2).'/'.substr($dt,0,4).' '.$hora;
}

//TESTE APAGAR
/*
$conteudo = "id_transacao: ".$posted['id_transacao'];
$conteudo.= "<br>".$posted['status_pagamento'];
$conteudo.= "<br>".$posted['valor'];
$conteudo.= "<br>".$posted['cod_moip'];
$conteudo.= "<br>".$posted['email_consumidor'];

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
$headers .= 'From: MOIP Ingresso Solidário <retorno@ingressosolidario.com>' . "\r\n";            
          
mail('fernando@zarbsolution.com.br', 'Teste 2 Moip', $conteudo, $headers);
*/
//FIM DO TESTE

$pedido = substr($posted['id_transacao'],3);

//wp_posts
//buscando a data do pedido
$sql = "SELECT post_date FROM wp_posts WHERE ID='$pedido'"; 
$result = mysql_query($sql);
list($data_pedido)=mysql_fetch_row($result);

//wp_postmeta
//buscando o email do cliente
$sql = "SELECT meta_value FROM wp_postmeta WHERE post_id='$pedido' AND meta_key='_billing_email' ";
$result = mysql_query($sql);
list($email)=mysql_fetch_row($result);
//buscando o nome do cliente
$sql = "SELECT meta_value FROM wp_postmeta WHERE post_id='$pedido' AND meta_key='_billing_first_name' ";
$result = mysql_query($sql);
list($nome)=mysql_fetch_row($result);
//buscando o sobrenome do cliente
$sql = "SELECT meta_value FROM wp_postmeta WHERE post_id='$pedido' AND meta_key='_billing_last_name' ";
$result = mysql_query($sql);
list($sobrenome)=mysql_fetch_row($result);

//wp_woocommerce_order_items
//buscando os itens
$sql = "SELECT i.order_item_id,i.order_item_name, im.meta_value FROM wp_woocommerce_order_items AS i INNER JOIN wp_woocommerce_order_itemmeta AS im ";
$sql.= "ON im.order_item_id=i.order_item_id AND i.order_id='$pedido' AND im.meta_key='_qty'";
$result = mysql_query($sql);
$conteudo = '<p>Abaixo seu e-ticket, siga as instru&ccedil;&otilde;es a seguir para saber como realizar a troca pelo ingresso principal que dar&aacute; acesso ao evento.</p>';
while(list($id_item,$nome_evento,$quantidade)=mysql_fetch_row($result)){
  //buscando o codigo do produto
  $sql4 = "SELECT im.meta_value FROM wp_woocommerce_order_itemmeta AS im ";
  $sql4.= "WHERE im.order_item_id='$id_item' AND im.meta_key='_product_id'";
  $result4 = mysql_query($sql4);
  list($id_produto)=mysql_fetch_row($result4);
  
  //buscando o local do evento
  $sql5 = "SELECT meta_value FROM wp_postmeta WHERE post_id='$id_produto' AND meta_key='local'";
  $result5 = mysql_query($sql5);
  list($local)=mysql_fetch_row($result5);
  
  //buscando a data do evento
  $sql5 = "SELECT meta_value FROM wp_postmeta WHERE post_id='$id_produto' AND meta_key='data_hora'";
  $result5 = mysql_query($sql5);
  list($data_hora)=mysql_fetch_row($result5);

  //buscando informacoes do evento
  $sql5 = "SELECT meta_value FROM wp_postmeta WHERE post_id='$id_produto' AND meta_key='informacoes'";
  $result5 = mysql_query($sql5);
  list($informacoes)=mysql_fetch_row($result5);

  //gravar na tabela ingressos
  for($i=0;$i<$quantidade;$i++){
    $sql2 = "INSERT INTO ingressos(id_pedido,data,cliente,email,evento,status) VALUES('$pedido','$data_pedido','$nome $sobrenome','$email','$nome_evento','A')";
    $result2 = mysql_query($sql2);
    $cod_ingresso = mysql_insert_id();
    $cod_barras = md5('IS'.$cod_ingresso);
    
    //GRAVANDO O CODIGO DE BARRAS
    $sql3 = "UPDATE ingressos SET cod_barras='$cod_barras' WHERE id='$cod_ingresso'";
    $result3 = mysql_query($sql3);

    //ENVIANDO OS E-TICKETS
    $conteudo.= '<div style="margin: 3px; font-family: arial; font-size: 14; padding: 6px; border: 1px black solid">
                <center><img src="http://ingressosolidario.com/wp-content/uploads/2014/09/logo_site.png"></center>
                <h1 style="text-align: center">e-ticket</h1>
                <h2>'.$nome_evento.'</h2>
                <h3>Pedido: '.$pedido.'</h3>
                <h3>'.$nome.' '.$sobrenome.'</h3>
                <h3>Local: '.$local.'</h3>
                <h3>Data: '.$data_hora.'</h3>
                <img src="http://ingressosolidario.com/codbarra/?cod='.$cod_barras.'">
                <br>
                C&oacute;digo do ingresso: '.$cod_barras.' 
                <hr>
                Comprado em '.converte_data($data_pedido).'<br>
                <h4>Favor imprimir e levar este ingresso</h4>
                </div>';
  }
}

$conteudo .= '<p>'.$informacoes.'</p>
              <p>Ser&aacute; indispens&aacute;vel &agrave; apresenta&ccedil;&atilde;o pelo COMPRADOR:</p>
              <ul>
              <li>Do e-Ticket acima impresso;</li>
              <li>Dos documentos originais ou c&oacute;pia simples do titular da compra: RG, CPF ou CNH;</li>
              <li>Caso o COMPRADOR tenha escolhido cart&atilde;o de cr&eacute;dito como forma de pagamento, o mesmo dever&aacute; apresentar o cart&atilde;o de cr&eacute;dito utilizado na compra, ou ent&atilde;o, uma c&oacute;pia simples da frente do mesmo;</li>
              <li>Somente ser&aacute;(&atilde;o) entregue(s) o(s) ingresso(s), em suas modalidades, para os portadores dos documentos acima descritos, e se os dados constantes dos documentos estiverem em conformidade com o que foi preenchido na proposta eletr&ocirc;nica;</li>
              <li>A n&atilde;o apresenta&ccedil;&atilde;o destes documentos acarretar&aacute; na perda do ingresso sem direito a qualquer reembolso;</li>
              <li>O ingresso adquirido na internet n&atilde;o implica em vantagens, nem prioridade na fila de entrada no evento;</li>
              <li>O controle de ingressos controla a entrada de cada e-Ticket/Ingresso, sendo assim, &eacute; obriga&ccedil;&atilde;o do cliente n&atilde;o permitir c&oacute;pia do e-Ticket impresso pela internet. Se houver duas c&oacute;pias do e-Ticket, o sistema permitir&aacute;, apenas, a entrada do primeiro;</li>
              </ul>';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";  
$headers .= 'From: Ingresso Solidário <contato@ingressosolidario.com>' . "\r\n";


mail($email,"E-ticket Ingresso Solidário",$conteudo,$headers);
mail('pedrodemenezes.tec@gmail.com',"E-ticket Ingresso Solidário [Cópia]",$conteudo,$headers);
mail('fernando@zarbsolution.com.br',"E-ticket Ingresso Solidário [Cópia]",$conteudo,$headers);

?>