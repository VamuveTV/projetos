<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<link href="../css/select2.css" rel="stylesheet"/>
<script src="../js/select2.js"></script>
<script type="text/javascript">

$("#cor").select2();
$("#marca").select2();
$("#tamanho").select2();
$('#preco').maskMoney({decimal:",",thousands:"."});

</script>
<form name="form_cadastro" id="formCadastro" onsubmit="return false;" class=" form-horizontal well ucase" action="ajax_cadastrar.php" enctype="multipart/form-data">
<fieldset>
	<legend>Cadastro de Produtos
	</legend>
	<fieldset id="address-form">
		
	<div class="control-group">
	  <label class="control-label" for="nome">Nome</label>
	  <div class="controls">
	    <input id="nome" name="nome" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
	</div>
	
	<!-- COR input-->
	<div class="control-group">
	  <label class="control-label" for="input-cor">Cor</label>
	  <div class="controls">
	    <select id="cor" name="cor" class="input-xlarge">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM cores ORDER BY nome";
			$result = mysql_query($sql);
			while(list($cod,$nome)=mysql_fetch_row($result)){
				echo "<option value='$cod'>$nome</option>";	
			}
			?>
		</select>
	  </div>
	</div>
	
	<!-- MARCA input-->
	<div class="control-group">
	  <label class="control-label" for="marca">Marca</label>
	  <div class="controls">
	    <select id="marca" name="marca" required="" class="input-xlarge">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM marca ORDER BY nome";
			$result = mysql_query($sql);
			while(list($cod,$nome)=mysql_fetch_row($result)){
				echo "<option value='$cod'>$nome</option>";	
			}
			?>
		</select>
	  </div>
	</div>
	
	<!-- TAMANHO input-->
	<div class="control-group">
	  <label class="control-label" for="tamanho">Tamanho</label>
	  <div class="controls">
	    <select id="tamanho" name="tamanho" required="" class="input-xlarge">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM tamanhos ORDER BY nome";
			$result = mysql_query($sql);
			while(list($cod,$nome)=mysql_fetch_row($result)){
				echo "<option value='$cod'>$nome</option>";	
			}
			?>
		</select>
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="descricao">Descriçao</label>
	  <div class="controls">
	    <textarea id="descricao" name="descricao" class="input-xlarge"></textarea>
	    
	  </div>
	</div>	
	
	<div class="control-group">
	  <label class="control-label" for="quantidade">Quantidade</label>
	  <div class="controls">
	    <input id="quantidade" name="quantidade" value="1" class="input-small" required="" type="text">
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="preco">Valor (unitário)</label>
	  <div class="controls">
	    <input id="preco" name="preco" placeholder="" class="input-small" required="" type="text">
	  </div>
	</div>
	
	<?php 
	if(isset($_POST['venda']))
		echo "<input type='hidden' name='venda' id='venda' value='".$_POST['venda']."'>";
	else
		echo "<input type='hidden' name='venda' id='venda' value=''>";
	?>
	</fieldset>
</fieldset>

</form>