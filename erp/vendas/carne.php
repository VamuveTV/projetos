<?php	
	define('MPDF_PATH', '../MPDF57/');
	include(MPDF_PATH.'mpdf.php');
	$mpdf=new mPDF();
  
	require_once('barcode.inc.php'); 	
	//include_once("../conectar.php");
	
	$dbh=mysql_connect ("localhost", "kservido_sirlan", "123mudar")
    			or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("kservido_erp")
    			or die ('I cannot select to the database because: ' . mysql_error());
	/*
	$dbh=mysql_connect ("localhost", "root", "")
    			or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("erp")
    			or die ('I cannot select to the database because: ' . mysql_error());
	*/
	function converte_data($data,$tipo){
	  if($tipo=="usuario")
	    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
	  
	  if($tipo=="banco")
	    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
	  return $data;
	}	

  	$conteudo = '<style>
  				body{margin:0;padding:0;font-family: arial;font-size: 9px}
  				.tabela{background: #000}
  				th,td{background: #fff}
  				em{font-size: 8px}
  				h1,h2,h3,h4{font-weight: normal}
  				</style>';
				
	$query = "SELECT p.codigo, p.valor, p.data, p.codbarras, v.data, v.total, c.nome, c.cpf, p.recebido, CONCAT(c.endereco,' ', c.numero,' ',c.cidade,',',c.estado) AS endereco
			  FROM parcelas AS p INNER JOIN vendas AS v ON p.venda=v.codigo INNER JOIN clientes AS c
			  ON c.codigo=v.cliente WHERE v.codigo='".$_GET['venda']."' AND p.forma_pagamento='C' ";
			  
	$result = mysql_query($query);
	$max = mysql_num_rows($result);
	$ct = 1;
	
	while(list($codP,$valorP,$dataP,$codbarrasP,$dataV,$valorV,$nomeC,$cpfC,$recebidoP,$enderecoC)=mysql_fetch_row($result))
	{
		if($ct == 1){ //exibir capa
			$t = $max * $valorP;
			$conteudo.= '<table class="tabela" style="width: 96.5%; margin-left: 3px;">
								<tr>
								<td style="height: 210px;" valign="top">
								<h1>Calçados Passo Nobre</h1>
								<br>
								<h3>
								Data: '.converte_data($dataV, 'usuario').'<br>
								Eu ( '.$nomeC.' , CPF: '.$cpfC.', Endereço: '.$enderecoC.') declaro que comprei na Calçados Passo Nobre , loja _________________ , 
								os produtos abaixo relacionados, que totalizam R$ '.number_format($t,2).' e pagarei no crediário próprio da loja em '.$max.' parcelas de R$'. number_format($valorP,2,",",".").' cada.<br><br>* Estou ciente que em caso de atraso , irei pagar 2 % de multa, e juros de 0,33 % ao dia.
								</h3><br><br><br>
									<table style="width: 680px" class="tabela">';
									$conteudo.= "<tr>
														<th>Quantidade</th>
														<th>Produto</th>
														<th>Marca</th>
														<th>Cor</th>
														<th>Tamanho</th>
														<th>Total</th>
													</tr>";
									//listando os produtos da venda
									$sql2 = "SELECT p.codigo, p.nome, m.nome AS marca, co.nome AS cor, t.nome AS tamanho, pv.valor * pv.quantidade AS total, pv.quantidade FROM produtos AS p 
											INNER JOIN marca AS m ON p.marca=m.codigo 
											INNER JOIN cores AS co ON p.cor=co.codigo 
											INNER JOIN tamanhos AS t ON p.tamanho=t.codigo 
											INNER JOIN produtos_vendas AS pv ON p.codigo=pv.produto
											INNER JOIN vendas AS v ON pv.venda=v.codigo
											WHERE v.codigo='".$_GET['venda']."' ORDER BY p.nome ";
									$result2 = mysql_query($sql2);
									while(list($codProd,$nomeProd,$marcaProd,$corProd,$tamanhoProd,$precoProd,$qtdProd)=mysql_fetch_row($result2)){
										$conteudo.= "<tr>
														<td align='center'>$qtdProd</td>
														<td>$nomeProd</td>
														<td>$marcaProd</td>
														<td>$corProd</td>
														<td align='center'>$tamanhoProd</td>
														<td align='right'>".number_format($precoProd,2)."</td>
													</tr>";
									}									
									$conteudo.= '</table>
									<br><br><br>
									<table style="width: 680px">
									<tr>
									<td>
									__________________________________________<br>
									'.$nomeC.'
									</td>
									<td align="right">
									<img width="190" height="50" src="logo_calcados.png"><br>
									www.calcadospassonobre.com.br<br>
									</td>
									</tr>
									</table>								
								</td>
								</tr>
						  </table>';			
		}
		
		$dataP = converte_data($dataP,"usuario");
		$dataV = converte_data($dataV,"usuario");
		
		new barCodeGenrator($codbarrasP,1,"codbarras/$codP.gif",140,40,false);
		$conteudo .= '<table>
						<tr>
						<td>
			  			  <table class="tabela" border="0" style="float: left" width="250" cellspacing="1" cellpadding="5">
						  <tr>
						  	<th colspan="2"><h1>Calçados Passo Nobre</h1></th>			  	
						  </tr>
						  <tr>
						  	<td><em>Cliente</em><h3>'.$nomeC.'</h3></td>
						  	<td><em>Parcela</em><h3>'.$ct.' / '.$max;
							if($recebidoP == 'S')
								$conteudo.= '&nbsp;<font color="red" size="3">[RECEBIDO]</font>';						  	
						  	$conteudo.= '</h3></td>
						  </tr>
						  <tr>			  	
						  	<td><em>Data da compra</em><h3>'.$dataV.'</h3></td>
						  	<td><em>Valor da compra</em><h3>R$ '.number_format($valorV,2,",",".").'</h3></td>
						  </tr>
						  <tr>
						  	<td><em>Vencimento da parcela</em><h3>'.$dataP.'</h3></td>
						  	<td><em>Valor da parcela</em><h2>R$ '.number_format($valorP,2,",",".").'</h2></td>
						  </tr>
						  <tr>
						  	<td height="60" valign="top"><em>Código de barras</em><br><img src="codbarras/'.$codP.'.gif"></td>
						  	<td valign="top"><em>Recebido em</em><br><br><br><br><h4>____/____/________</h4></td>
						  </tr>
						  </table>
						</td>
						<td>
						  <table class="tabela" border="0" style="float: left" width="400" cellspacing="1" cellpadding="5">
						  <tr>
						  	<th colspan="2"><h1>Calçados Passo Nobre</h1></th>			  	
						  </tr>
						  <tr>
						  	<td><em>Cliente</em><h3>'.$nomeC.'</h3></td>
						  	<td><em>Parcela</em><h3>'.$ct.' / '.$max;
						  	if($recebidoP == 'S')
								$conteudo.= '&nbsp;<font color="red" size="3">[RECEBIDO]</font>';
								
						  	$conteudo.= '</h3></td>
						  </tr>
						  <tr>			  	
						  	<td><em>Data da compra</em><h3>'.$dataV.'</h3></td>
						  	<td><em>Valor da compra</em><h3>R$ '.number_format($valorV,2,",",".").'</h3></td>
						  </tr>
						  <tr>
						  	<td><em>Vencimento da parcela</em><h3>'.$dataP.'</h3></td>
						  	<td><em>Valor da parcela</em><h2>R$ '.number_format($valorP,2,",",".").'</h2></td>
						  </tr>
						  <tr>
						  	<td height="60" valign="top"><em>Código de barras</em><br><img src="codbarras/'.$codP.'.gif"></td>
						  	<td valign="top"><em>Recebido em</em><br><br><br><br><h4>____/____/________</h4></td>
						  </tr>
						  </table>
						</td>
						</table>';
						$ct++;
	}
	$mpdf->WriteHTML($conteudo);
	$mpdf->Output();
	
	array_map('unlink', glob("codbarras/*.gif"));

	exit();
?>