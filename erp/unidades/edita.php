<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$('#input-magento').change(function(){
	op = $(this).val();
	if(op == 'S')
		$('#opcoes_magento').slideDown(500);
	else
		$('#opcoes_magento').slideUp(500);
})
</script>
<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM unidades WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);
?>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Unidades
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="nome">Nome</label>
	  <div class="controls">
	    <input id="input-nome" name="input-nome" value="<?php echo $dados['nome'];?>" placeholder="" class="input-xlarge" required="" type="text">
	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="nome">Sigla</label>
	  <div class="controls">
	    <input id="input-sigla" name="input-sigla" value="<?php echo $dados['sigla'];?>" placeholder="" class="input-xlarge" required="" type="text">
	    
	  </div>
	</div>

	<!-- Magento input-->
	<div class="control-group">
	  <label class="control-label" for="input-magento">Utiliza magento</label>
	  <div class="controls">
	    <select id="input-magento" name="input-magento" class="input-xlarge" required="">
			<option value="S"<?php echo $dados['magento']=='S'?' selected':'';?>>Sim</option>
			<option value="N"<?php echo $dados['magento']=='N'?' selected':'';?>>Não</option>
		</select>	    
	  </div>
	</div>

	<div id="opcoes_magento" <?php echo $dados['magento']=='N'?' style="display:none"':'';?>>
		<!-- Url input-->
		<div class="control-group">
		  <label class="control-label" for="input-url">Url loja (com http)</label>
		  <div class="controls">
		    <input id="input-url" name="input-url" value="<?php echo $dados['url'];?>" placeholder="" class="input-xlarge" type="text">	    
		  </div>
		</div>

		<!-- Usuário soap input-->
		<div class="control-group">
		  <label class="control-label" for="input-usu_soap">Usuário SOAP</label>
		  <div class="controls">
		    <input id="input-usu_soap" name="input-usu_soap" value="<?php echo $dados['usuario_soap'];?>" placeholder="" class="input-xlarge" type="text">	    
		  </div>
		</div>

		<!-- Senha soap input-->
		<div class="control-group">
		  <label class="control-label" for="input-senha_soap">Senha SOAP</label>
		  <div class="controls">
		    <input id="input-senha_soap" name="input-senha_soap" placeholder="" class="input-xlarge" type="password">	    
		  </div>
		</div>

		<!-- Servidor bd input-->
		<div class="control-group">
		  <label class="control-label" for="input-servidor_bd">Servidor BD</label>
		  <div class="controls">
		    <input id="input-servidor_bd" name="input-servidor_bd" value="<?php echo $dados['servidor_bd'];?>" placeholder="" class="input-xlarge" type="text">	    
		  </div>
		</div>

		<!-- Usuário bd input-->
		<div class="control-group">
		  <label class="control-label" for="input-usu_bd">Usuário BD</label>
		  <div class="controls">
		    <input id="input-usu_bd" name="input-usu_bd" value="<?php echo $dados['usuario_bd'];?>" placeholder="" class="input-xlarge" type="text">	    
		  </div>
		</div>

		<!-- Senha bd input-->
		<div class="control-group">
		  <label class="control-label" for="input-senha_bd">Senha BD</label>
		  <div class="controls">
		    <input id="input-senha_bd" name="input-senha_bd" placeholder="" class="input-xlarge" type="password">	    
		  </div>
		</div>

		<!-- database input-->
		<div class="control-group">
		  <label class="control-label" for="input-bd">Database</label>
		  <div class="controls">
		    <input id="input-bd" name="input-bd" value="<?php echo $dados['bd'];?>" class="input-xlarge" type="text">	    
		  </div>
		</div>
	</div>
	
	</fieldset>
</fieldset>

<div class="form-actions">
	<input type="hidden" id="input-cod" name="input-cod" value="<?php echo $_POST['cod'];?>" />
	<button type="submit" id="salvar" class="btn btn-success">Salvar</button>
	<button type="button" id="cancelar" class="btn btn-warning">Cancelar</button>
</div>
</form>