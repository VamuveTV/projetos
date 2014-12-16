<?php
/*
mysql_connect("localhost","root","")// conectando no bando de dados
 or die ('Não foi possível conectar ao banco de dados!'); //comando pra verrifica se conectou no banco de dados e mostra essa mensagem de resposta
mysql_select_db("erp")  // seleciona o banco de dados
 or die ('Base de Dados Danificada');
*/

mysql_connect("calcadospassonobre.com.br","passono_erp","erp@magento")// conectando no bando de dados
 or die ('Não foi possível conectar ao banco de dados!'); //comando pra verrifica se conectou no banco de dados e mostra essa mensagem de resposta
mysql_select_db("passono_nobre2")  // seleciona o banco de dados
 or die ('Base de Dados Danificada');

?>