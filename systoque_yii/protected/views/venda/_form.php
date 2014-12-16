	    <form class="form-horizontal" method="post" role="form">
	    <div class="row">
		  <div class="col-md-6">
		  	<div class="form-group">
		      <label for="disabledTextInput">Data do pedido:</label>
		      <input type="date" name="data_venda" id="data_venda" value="" class="form-control" placeholder="Data do pedido">
		    </div>
		  </div>
		  <div class="col-md-6">
		  	<div class="form-group">
			    <label>Previsão de entrega:</label>
			      <input type="date" class="form-control" name="previsao" id="previsao_venda" value="" placeholder="Data prevista para entrega">
			  </div>
			</div>
		</div>
		
		<div class="row">
		  <div class="col-md-6">
		  	<div class="form-group">
		      <label for="disabledTextInput">Vendedor:</label>
		      <select name="vendedor" id="vendedor_venda" class="form-control">
		      	<option></option>
		      	<?php 
		      	foreach($vendedores As $vendedor){
					echo '<option value="'.$vendedor->matricula.'">'.$vendedor->nome.'</option>';	
				}
		      	?>
		      </select>
		    </div>
		  </div>
		  <div class="col-md-6">
		  	<div class="form-group">
			    <label>Status:</label>
			      <input type="text" class="form-control" name="status" id="status_venda" value="" placeholder="Status">
			  </div>
			</div>
		</div>
		
		<h3 style="background: #DDD; padding: 4px;">INCLUIR NO PEDIDO</h3>
		
		<div class="row">
		  <div class="col-md-6">
		  	<div class="form-group">
		      <label>Produto:</label>
			  <select class="form-control" name="nome_prod" id="nome_prod" onchange="buscaValor(this.value)">
			  <option></option>
			  <?php 
		      	foreach($produtos As $produto){
					echo '<option value="'.$produto->cb.'">'.$produto->nome.'</option>';	
				}
		      ?>
			  </select>
		    </div>
		  </div>
		  <div class="col-md-6">
		  	<div class="form-group">			    
			     <label for="disabledTextInput">Código de barras:</label>
		      	<input type="text" class="form-control" name="cod_prod" id="cod_prod" placeholder="Código" readonly>
			  </div>
			</div>
		</div>
		
		<div class="row">
		  <div class="col-md-6">
		  	<div class="form-group">
		      <label for="disabledTextInput">Quantidade:</label>
		      <input type="text" class="form-control" id="qtd_prod" name="qtd_prod" placeholder="Quantidade">
		    </div>
		  </div>
		  <div class="col-md-6">
		  	<div class="form-group">
			    <label>Valor do produto:</label>
			      <input type="text" class="form-control" id="valor" name="valor_prod" placeholder="Valor do produto" readonly>
			  </div>
			</div>
		</div>
		
		  <button type="button" onclick="addProd()" name="acao" class="btn btn-primary">Incluir no Pedido</button>
		  
		  	<div class="row" style="margin-top: 10px">
		  <table class="table table-bordered">
		  <tr>
		  	<th>Código do Produto</th>
		  	<th>Nome do Produto</th>
		  	<th>Valor Unitário</th>
		  	<th>Quantidade</th>
		  	<th>Sub Total</th>
		  </tr>	 
		  <tbody id="itens">
		  
		  </tbody> 
		  </table>
		  <button type="button" onclick="finaliza()" name="acao" class="btn btn-success">Finalizar venda</button>
		  </div>
		  
		  		</form>		
