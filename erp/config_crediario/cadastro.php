<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	
	$sql = "SELECT * FROM config_crediario LIMIT 0,1 ";
	$result = mysql_query($sql);
	$dados = mysql_fetch_array($result);
	$dados['parcela_minima'] = number_format($dados['parcela_minima'],2,",",".");
?>
<script type="text/javascript">
$('.input-valor').maskMoney({decimal:",",thousands:"."});
</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Informe os valores
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-maximo-compra">Máximo de </label>
	  <div class="controls">
		  <div class="input-append">		
		    <input id="input-maximo-compra" name="input-maximo-compra" value="<?php echo $dados['maximo_compra'];?>" placeholder="" class="span2" required="" type="text">
			<span class="add-on">%</span>
		    da renda para compra
		  </div>
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-maximo-parcela">Máximo de</label>
	  <div class="controls">
		<div class="input-append">
	    <input id="input-maximo-parcela" name="input-maximo-parcela" value="<?php echo $dados['maximo_parcela'];?>" placeholder="" class="span2" required="" type="text">
		<span class="add-on">%</span>
	    da renda para parcela
		</div>
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-minimo-parcela">M&iacute;nimo de</label>
	  <div class="controls">
	    <div class="input-prepend">
		<span class="add-on">R$</span>
		<input id="input-minimo-parcela" name="input-minimo-parcela" value="<?php echo $dados['parcela_minima'];?>" placeholder="" class="input-small input-valor" required="" type="text">
		por parcela
	    </div>
	  </div>
	</div>
	
	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="salvar" class="btn btn-success">Salvar</button>
	<button type="button" id="cancelar" class="btn btn-warning">Cancelar</button>
</div>
</form>