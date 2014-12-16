<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}
	
$tabela = "parcelas";

//buscando as configurações de crediário
$sql = "SELECT maximo_compra, maximo_parcela, parcela_minima FROM config_crediario LIMIT 0,1 ";
$result = mysql_query($sql);
list($maximo_compra,$maximo_parcela,$parcela_minima)=mysql_fetch_row($result);

$query = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
$result = mysql_query($query);
list($total)=mysql_fetch_row($result);

$query2 = "SELECT SUM(valor) FROM parcelas WHERE venda='".$_POST['cod']."'";
$result2 = mysql_query($query2);
list($sub_total)=mysql_fetch_row($result2);


$dif = $total - $sub_total;

if($dif < $_POST['totalC'])
	echo "ERRO1#";
else{
		//buscando o limite disponivel para crediario do cliente
		$query3 = "SELECT c.limite, c.renda FROM clientes AS c INNER JOIN vendas AS v 
					ON c.codigo=v.cliente WHERE v.codigo='".$_POST['cod']."'";
		$result3 = mysql_query($query3);
		list($limite,$renda)=mysql_fetch_row($result3);
		
		$val_max_parcela = round(($maximo_parcela * $renda) / 100);
		
		//buscando o valor de compras por crediario em aberto pelo cliente
		$query4 = "SELECT SUM(p.valor) FROM parcelas AS p INNER JOIN vendas AS v ON p.venda=v.codigo 
					INNER JOIN clientes AS c ON c.codigo=v.cliente 
					WHERE v.codigo='".$_POST['cod']."' AND p.forma_pagamento='C' AND p.recebido='N'";
		$result4 = mysql_query($query4);
		list($em_aberto)=mysql_fetch_row($result4); 
		
		if(($em_aberto + $_POST['totalC']) > $limite){ //nao possui limite para crediario
			$disponivel = $limite - $em_aberto; //limite disponivel
			echo "ERRO2#$disponivel#";				
		}
		else{
			//gravando as parcelas
			$val_parcela = $_POST['totalC'] / $_POST['parcelasC'];
			
			//verificando se o valor da parcela estão de acordo com os parametros do sistema
			if($val_parcela < $parcela_minima)
				exit("ERRO3#$parcela_minima#".$_POST["cod"]);
			else if($val_parcela > $val_max_parcela)
				exit("ERRO4#$val_max_parcela#".$_POST["cod"]);				
			else{
				//atualizando a tabela de vendas
				$_POST['dataC'] = converte_data($_POST['dataC'],'banco');
				$banco->atualiza("vendas", array("parcelasCred","totalCred","vencimento"), array($_POST['parcelasC'],$_POST['totalC'],$_POST['dataC']), $_POST['cod']);
							
				for($i = 1; $i <= $_POST['parcelasC']; $i++){
					$campos =  array("venda","forma_pagamento","valor","data");
					$dados = array($_POST["cod"],"C",$val_parcela,$_POST["dataC"]);				
					$banco->insere($tabela, $campos, $dados);
					$cod_parcela = mysql_insert_id();
					
					//adicionando na parcela o codigo de barras
					$cod_barras = date("Ymd").$cod_parcela;
					$banco->atualiza($tabela, array("codbarras"), array($cod_barras), $cod_parcela);
					
					//alterando a proxima data de vencimento
					$date = new DateTime($_POST["dataC"]);
					$date->modify('+1 month');
					$_POST["dataC"] = $date->format('Y-m-d');
				}			
			}
			//atualizando o total
			$query = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
			$result = mysql_query($query);
			list($total)=mysql_fetch_row($result);
			$banco->atualiza("vendas", array("total"), array($total), $_POST['cod']);
		}
}
echo $_POST["cod"];
	
?>