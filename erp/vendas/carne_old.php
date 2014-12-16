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
				
	$query = "SELECT p.codigo, p.valor, p.data, p.codbarras, v.data, v.total, c.nome, c.cpf
			  FROM parcelas AS p INNER JOIN vendas AS v ON p.venda=v.codigo INNER JOIN clientes AS c
			  ON c.codigo=v.cliente WHERE v.codigo='".$_GET['venda']."' AND p.forma_pagamento='C' AND p.recebido='N' ";
			  
	$result = mysql_query($query);
	$max = mysql_num_rows($result);
	$ct = 1;
	
	while(list($codP,$valorP,$dataP,$codbarrasP,$dataV,$valorV,$nomeC,$cpfC)=mysql_fetch_row($result))
	{
		if($ct == 1){ //exibir capa
			$conteudo.= '<table class="tabela" style="width: 96.5%; margin-left: 3px;">
								<tr>
								<td style="height: 210px;">
								<h1>Calçados Passo Nobre</h1>
								<br>
								<h3>
								Eu ( '.$nomeC.' ) declaro que comprei na Calçados Passo Nobre , loja ________ , os produtos abaixo relacionados : em '.$max.' parcelas de R$'. number_format($valorP,2,",",".").' , estou ciente que em caso de atraso , irei pagar 2 % de multa mensais , e juros de 0,33 % ao dia.
								</h3></td>
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
						  	<td><em>Parcela</em><h3>'.$ct.' / '.$max.'</h3></td>
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
						  	<td><em>Parcela</em><h3>'.$ct.' / '.$max.'</h3></td>
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