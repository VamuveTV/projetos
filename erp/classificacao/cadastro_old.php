<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Classificações
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="nome">Nome</label>
	  <div class="controls">
	    <input id="input-nome" name="input-nome" placeholder="" class="input-xlarge" required="" type="text">
	    
	  </div>
	</div>
	
  <div class="control-group">
	  <label class="control-label" for="nome">Categoria(magento)</label>
	  <div class="controls">
	    <select id="input-idmagento" name="input-idmagento" class="input-xlarge">
      <?php
      include("../conectarSoap.php");
	  $result = $client->catalogCategoryTree($session);
      $categorias = $result->children;
      
      foreach($categorias AS $cat){
        echo "<option value='".$cat->category_id."'>".$cat->name."</option>";
      }

      ?>
      </select>	    
	  </div>
	</div>	
	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	<button type="button" id="cancelar" class="btn btn-warning">Cancelar</button>
</div>
</form>