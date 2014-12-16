<h3>Estoque Atual</h3>
<table class='table'>
<tr>
	<th>Cod. Barras</th>
	<th>Nome</th>
	<th>Quantidade</th>
</tr>
<?php 
foreach($produtos As $produto){
	echo '<tr>
			<td>'.$produto->cb.'</td>
			<td>'.$produto->nome.'</td>
			<td>'.$produto->qtde.'</td>	
			</tr>';	
}
?>
</table>

