<?php
  define('MPDF_PATH', '../MPDF57/');
  include(MPDF_PATH.'mpdf.php');
  $mpdf=new mPDF();
  
  require_once('barcode.inc.php'); 
  
  new barCodeGenrator("201308301",1,"hello.gif",140,40,false);
  
  $conteudo = '<style>
  				body{margin:0;padding:0;font-family: arial;font-size: 10px}
  				.tabela{background: #000}
  				th,td{background: #fff}
  				h2,h3,h4{font-weight: normal}
				em{font-weight: bold}
  				</style>
  			
			<table>
			<tr>
			<td>
  			  <table class="tabela" border="0" style="float: left" width="250" cellspacing="1" cellpadding="5">
			  <tr>
			  	<th colspan="2"><h1>Calçados Passo Nobre</h1></th>			  	
			  </tr>
			  <tr>
			  	<td><em>Cliente</em><h3>Fulano de Tal</h3></td>
			  	<td><em>CPF</em><h3>123.456.789-09</h3></td>
			  </tr>
			  <tr>			  	
			  	<td><em>Data da compra</em><h3>30/08/2013</h3></td>
			  	<td><em>Valor da compra</em><h3>R$ 650,00</h3></td>
			  </tr>
			  <tr>
			  	<td style="background: #EEE"><em>Vencimento da parcela</em><h3>02/09/2013</h3></td>
			  	<td style="background: #EEE"><em>Valor da parcela</em><h2>R$ 250,00</h2></td>
			  </tr>
			  <tr>
			  	<td height="60" valign="top"><em>Código de barras</em><br><img src="hello.gif"></td>
			  	<td valign="top"><em>Recebido em</em><br><br><br><br><h4>____/____/________</h4></td>
			  </tr>
			  </table>
			</td>
			<td>
			  <table class="tabela" border="0" width="400" cellspacing="1" cellpadding="5">
			  <tr>
			  	<th colspan="2"><h1>Calçados Passo Nobre</h1></th>			  	
			  </tr>
			  <tr>
			  	<td><em>Cliente</em><h3>Fulano de Tal</h3></td>
			  	<td><em>CPF</em><h3>123.456.789-09</h3></td>
			  </tr>
			  <tr>			  	
			  	<td><em>Data da compra</em><h3>30/08/2013</h3></td>
			  	<td><em>Valor da compra</em><h3>R$ 650,00</h3></td>
			  </tr>
			  <tr>
			  	<td style="background: #EEE"><em>Vencimento da parcela</em><h3>02/09/2013</h3></td>
			  	<td style="background: #EEE"><em>Valor da parcela</em><h2>R$ 250,00</h2></td>
			  </tr>
			  <tr>
			  	<td height="60" valign="top"><em>Código de barras</em><br><img src="hello.gif"></td>
			  	<td valign="top"><em>Recebido em</em><br><br><br><br><h4>____/____/________</h4></td>
			  </tr>
			  </table>
			</td>
			</table>';
  $mpdf->WriteHTML($conteudo);
  $mpdf->Output();
  exit();
?>