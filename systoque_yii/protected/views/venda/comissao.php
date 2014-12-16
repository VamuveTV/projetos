<table class='table table-bordered'>
  <tr>
    <th>Cod. Venda</th>
    <th>Nome</th>
    <th>Data</th>
    <th>Total</th>
    <th>Comissão</th>
  </tr>
  <?php 
  foreach($vendas AS $venda){
  	echo '<tr>
		    <td>'.$venda['codvenda'].'</td>
		    <td>'.$venda['nome'].'</td>
		    <td>'.$venda['data'].'</td>
		    <td>'.$venda['totalvenda'].'</td>
		    <td>'.number_format($venda['comissao'],2).'</td>
		  </tr>';
  }  
  ?>
</table>