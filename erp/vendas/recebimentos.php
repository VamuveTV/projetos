<?php 
session_start();
include("../conectar.php");
$codigo = $_GET["codigo"];
function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}
?>
<link id="bs-css" href="../css/bootstrap-cerulean.css" rel="stylesheet">
<link id="bs-css" href="css/bootstrap-classic.css" rel="stylesheet">
<link href="../css/chosen.css" rel="stylesheet">
<link href="../css/bootstrap-responsive.css" rel="stylesheet">
<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="../css/charisma-app.css" rel="stylesheet">
<link href="../css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
<link href='../css/fullcalendar.css' rel='stylesheet'>
<link href='../css/fullcalendar.print.css' rel='stylesheet'  media='print'>
<link href='../css/uniform.default.css' rel='stylesheet'>
<link href='../css/colorbox.css' rel='stylesheet'>
<link href='../css/jquery.cleditor.css' rel='stylesheet'>
<link href='../css/jquery.noty.css' rel='stylesheet'>
<link href='../css/noty_theme_default.css' rel='stylesheet'>
<link href='../css/elfinder.min.css' rel='stylesheet'>
<link href='../css/elfinder.theme.css' rel='stylesheet'>
<link href='../css/jquery.iphone.toggle.css' rel='stylesheet'>
<link href='../css/opa-icons.css' rel='stylesheet'>
<link href='../css/uploadify.css' rel='stylesheet'>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		<th colspan='5'>
			Histórico de compras

		</th>
	  </tr>
	  <tr>
		  <th>Código</th>
		  <th>Venda</th>
		  <th>Data</th>
		  <th>Valor</th>
		  <th>Valor Atual</th>

	  </tr>
  </thead>   
  <tbody>
  <?php
		$sql = "SELECT p.codigo AS parcela, v.codigo AS venda, p.data, c.nome AS cliente, p.valor, p.recebido, p.recebimento 
				FROM vendas AS v INNER JOIN clientes AS c ON c.codigo=v.cliente 
				INNER JOIN parcelas AS p ON v.codigo=p.venda WHERE c.codigo='".$codigo."' ";
		$sql.= "ORDER BY p.data desc";
		$res = mysql_query($sql);		
		while ($dados = mysql_fetch_array($res)) {
			$id_campo = 'id_' . $dados['parcela'];			
			if($dados['recebido'] == 'S')
				$dados['recebimento'] = converte_data($dados['recebimento'],'usuario');
			else
				$dados['recebimento'] = '';
			
			//calculando os juros (2% + 0,33% ao dia)
			$hoje = date("Y-m-d");
			$time_inicial = strtotime($dados['data']);
			$time_final = strtotime($hoje);
			
			if($time_final > $time_inicial){
				$sql2 = "SELECT DATEDIFF('$hoje','".$dados['data']."')";
				$res2 = mysql_query($sql2);
				list($dias)=mysql_fetch_row($res2);
				
				//calculando o valor
				$multa = $dados['valor'] * 0.02;
				$juros = $dados['valor'] * 0.0033;
				$valor_atual = ($multa) + ($juros * $dias);
				$valor_atual+= $dados['valor'];
			}
			else
				$valor_atual = $dados['valor'];
				
			$dados['data'] = converte_data($dados['data'],'usuario');
				 
  ?>
		<tr>
			<td width="20" class="center"><?php echo $dados['parcela']; ?></td>
			<td width="60"><?php echo $dados['venda']; ?></td>
			<td><?php echo $dados['data']; ?></td>
			<td><?php echo number_format($dados['valor'],2,",","."); ?></td>
			<td><?php echo number_format($valor_atual,2,",","."); ?></td>

		</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>