<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM promocoes WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}
?>
<script type="text/javascript">
$(".input-data").mask("99/99/9999");	
$('.input-valor').maskMoney({decimal:",",thousands:"."});
</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Promoções
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">

	<!-- Unidade -->
	<div class="control-group">
	  <label class="control-label" for="input-unidade">Unidade</label>
	  <div class="controls">
	    <select id="input-unidade" name="input-unidade" class="input-xlarge">
	    	<option value=""></option>
	    	<?php
	    	$sql = "SELECT codigo, nome FROM unidades ORDER BY nome";
			$result = mysql_query($sql);
			while(list($codU,$nomeU)=mysql_fetch_row($result)){
				echo "<option value='$codU'";
				echo $dados['unidade']==$codU?' selected':'';
				echo ">$nomeU</option>";
			}
	    	?>	
	    </select>    
	  </div>
	</div>
	
	<!-- Produto -->
	<div class="control-group">
	  <label class="control-label" for="input-unidade">Produto</label>
	  <div class="controls">
	    <select id="input-produto" name="input-produto" class="input-xlarge">
	    	<option value=""></option>
	    	<?php
	    	$sql = "SELECT codigo, nome FROM produtos ORDER BY nome";
			$result = mysql_query($sql);
			while(list($codP,$nomeP)=mysql_fetch_row($result)){
				echo "<option value='$codP'";
				echo $dados['produto']==$codP?' selected':'';
				echo ">$nomeP</option>";
			}
	    	?>	
	    </select>    
	  </div>
	</div>
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-dataini">Data de início</label>
	  <div class="controls">
	    <input id="input-dataini" name="input-dataini" value="<?php echo converte_data($dados['data_inicio'],'usuario');?>" class="input-data" required="" type="text">	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-datafim">Data de término</label>
	  <div class="controls">
	    <input id="input-datafim" name="input-datafim"" value="<?php echo converte_data($dados['data_fim'],'usuario');?>" placeholder="dd/mm/aaaa" class="input-data" required="" type="text">	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-preco">Preço</label>
	  <div class="controls">
	    <input id="input-preco" name="input-preco" class="input-valor" value="<?php echo number_format($dados['preco'],2,",",".");?>" required="" type="text">	    
	  </div>
	</div>

	</fieldset>
</fieldset>

<div class="form-actions">
	<input type="hidden" id="input-cod" name="input-cod" value="<?php echo $_POST['cod'];?>" />
	<button type="submit" id="salvar" class="btn btn-success">Salvar</button>
</div>
</form>