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
<script type="text/javascript">
$("#buscaData").mask("99/99/9999");
$(".input-data").mask("99/99/9999");
$(".campo_busca").keypress(function(event) {
  if(event.which == 13)
	chamaTabela2();     
});
</script>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		<th colspan='5'>
			Histórico de compras
			<button type="button" class="btn" style="float: right; margin: 0 5px" onclick="chamaTabela()">Fechar</button>
		</th>
	  </tr>
	  <tr>
		  <th>Código</th>
		  <th>Venda</th>
		  <th>Data</th>
		  <th>Valor</th>
		  <th>Valor atual</th>
		  <th>Recebimento</th>
	  </tr>
  </thead>   
  <tbody>
  <?php
		$sql = "SELECT p.codigo AS parcela, v.codigo AS venda, p.data, c.nome AS cliente, p.valor, p.recebido, p.recebimento 
				FROM vendas AS v INNER JOIN clientes AS c ON c.codigo=v.cliente 
				INNER JOIN parcelas AS p ON v.codigo=p.venda WHERE c.codigo='".$_POST['cliente']."' ";
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
			<td><?php echo number_format($valor_atual,2,",",".");?></td>
			<td align="center" width="200">												
				<input type="text" id="<?php echo $id_campo;?>" class="input-small input-data" value="<?php echo $dados['recebimento'];?>">	
				<?php
				if($dados['recebido']=='N')
					echo "<button class=\"btn btn-mini btn-success\" onclick=\"recebe_pag('#$id_campo','".$_POST['cliente']."')\">Receber</button>";
				else
					echo "<button class=\"btn btn-mini btn-danger\" onclick=\"exclui_pag('#$id_campo','".$_POST['cliente']."')\">Remover</button>";
				?>
			</td>
		</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>