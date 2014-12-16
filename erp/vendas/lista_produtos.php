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
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th colspan='6'>Produtos</th>
	  </tr>
	  <tr>
		  <th>Código</th>
		  <th>Produto</th>
		  <th>Valor</th>
		  <th>Quantidade</th>
		  <th>Total</th>
		  <th>Ações</th>
	  </tr>
  </thead>   
  <tbody>
  <?php
		$sql = "SELECT pv.codigo, p.nome AS produto, pv.valor, pv.quantidade, pv.valor * pv.quantidade AS total
				FROM produtos_vendas AS pv INNER JOIN produtos AS p ON p.codigo=pv.produto 
				WHERE pv.venda='".$_POST['venda']."' ORDER BY p.nome ";
		$res = mysql_query($sql);		
		while ($dados = mysql_fetch_array($res)) {
  ?>
	<tr>
		<td width="20" class="center"><?php echo $dados['codigo']; ?></td>
		<td><?php echo $dados['produto']; ?></td>
		<td><?php echo $dados['valor']; ?></td>
		<td><?php echo $dados['quantidade']; ?></td>
		<td><?php echo $dados['total']; ?></td>
		<td align="center" width="160">												
			<button class="btn btn-danger" onclick="janelaConfirma2($(this).val());" value="<?php echo $dados['codigo']; ?>">
				<i class="icon-trash icon-white"></i> 
				Excluir
			</button>
		</td>
	</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>