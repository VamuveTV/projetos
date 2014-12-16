<?php 
session_start();
include("../conectar.php");

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
		  <th colspan="8">
		  	Resumo

		  </th>
	  </tr>
	  <tr>
		  <th>Código</th>
		  <th>Produto</th>
		  <th>Quantidade</th>
	  </tr>
  </thead>   
  <tbody>
  <?php
		$sql = "SELECT codigo, nome FROM produtos ORDER BY nome ";
		$res = mysql_query($sql);		
		while (list($codP,$nomeP)=mysql_fetch_row($res)) { ?>
	<tr>
		<td class="center"><?php echo $codP; ?></td>
		<td><?php echo $nomeP; ?></td>
		<td>
			<table>
				<tr>
					<th>Unidade</th>
					<th>Quantidade</th>
				</tr>
				<?php
					//buscando as unidades
					$sql2 = "SELECT codigo, nome FROM unidades ORDER BY nome ";
					$res2 = mysql_query($sql2);
					while(list($codU,$nomeU)=mysql_fetch_row($res2)){
						//buscando a quantidade por unidade
						$sql3 = "SELECT SUM(quantidade) FROM estoque WHERE tipo='E' AND produto='$codP' AND unidade='$codU'";
						$res3 = mysql_query($sql3);
						list($total_entrada)=mysql_fetch_row($res3);
						
						$sql3 = "SELECT SUM(quantidade) FROM estoque WHERE tipo='S' AND produto='$codP' AND unidade='$codU'";
						$res3 = mysql_query($sql3);
						list($total_saida)=mysql_fetch_row($res3);
						
						$total = $total_entrada - $total_saida;
						
						echo "<tr>
								<td>$nomeU</td>
								<td>$total</td>
							  </tr>";
					}
				?>				
			</table>		
		</td>
	</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>
<button class="btn btn-large" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>