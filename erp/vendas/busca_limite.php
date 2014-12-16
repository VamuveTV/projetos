<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

//buscando o limite disponivel para crediario do cliente
$query3 = "SELECT limite FROM clientes WHERE codigo='".$_POST['cliente']."'";
$result3 = mysql_query($query3);
list($limite)=mysql_fetch_row($result3);

//buscando o valor de compras por crediario em aberto pelo cliente
$query4 = "SELECT SUM(p.valor) FROM parcelas AS p INNER JOIN vendas AS v ON p.venda=v.codigo 
			INNER JOIN clientes AS c ON c.codigo=v.cliente 
			WHERE c.codigo='".$_POST['cliente']."' AND p.forma_pagamento='C' AND p.recebido='N'";
$result4 = mysql_query($query4);
list($em_aberto)=mysql_fetch_row($result4); 

$disponivel = $limite - $em_aberto;

//valores em atraso
$sql = "SELECT p.valor, DATE_FORMAT(p.data, '%d/%m/%Y') FROM parcelas AS p INNER JOIN vendas AS v ON p.venda=v.codigo
			INNER JOIN clientes AS c ON c.codigo=v.cliente
			WHERE c.codigo='".$_POST['cliente']."' AND p.data<NOW() AND p.recebido='N'";
$resultado = mysql_query($sql);

    while ( list($valor, $data) = mysql_fetch_row($resultado) )
    {
        $valor = number_format($valor,2,",",".");
        echo "<b style=\"color: red\">Parcelas vencidas: </b> R$ $valor - $data <br />";

    }




$valor_total = number_format($disponivel,2,",",".");
echo "<b>Limite disponível</b> $valor_total";


?>