<h3>FATURAMENTO</h3>
<form method="post">
<label>Data inicial:</label>
<input type="date" name="data_ini" class="form-control">

<label>Data final:</label>
<input type="date" name="data_fim" class="form-control">

<br>
<input type="submit" name="acao" value="Enviar" class="btn btn-primary">

</form>
<br>
<table class='table table-bordered'>
  <tr>
    <th>Cod. Venda</th>
    <th>Data</th>
    <th>Total</th>
  </tr>
  <?php 
  foreach($vendas AS $venda){
  	echo '<tr>
		    <td>'.$venda->codvenda.'</td>
		    <td>'.$venda->data.'</td>
		    <td>'.$venda->totalvenda.'</td>
		  </tr>';
  }  
  ?>
</table>