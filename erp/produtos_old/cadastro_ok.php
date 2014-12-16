<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
include("../conectarSoap.php");
$banco = new ZarbMysql();
?>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase" action="ajax_cadastrar.php" enctype="multipart/form-data">
<fieldset>
	<legend>Cadastro de Produtos
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<!-- Select input-->
	<div class="control-group">
	  <label class="control-label" for="nome">Categoria</label>
	  <div class="controls">
	    <select id="input-classificacao" name="input-classificacao" required="">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM classificacao ORDER BY nome ";
			$result = mysql_query($sql);
			while(list($codC,$nomeC)=mysql_fetch_row($result)){
				echo "<option value='$codC'>$nomeC</option>";
			}
			?>
		</select>
	  </div>
	</div>
	
	<div class="control-group">
	  <label class="control-label" for="nome">Nome</label>
	  <div class="controls">
	    <input id="input-nome" name="input-nome" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
	</div>
	
	<!-- COR input-->
	<div class="control-group">
	  <label class="control-label" for="input-cor">Cor</label>
	  <div class="controls">
	    <select id="input-cor" name="input-cor" required="">
			<option value=""></option>
			<?php
			$result = $client->catalogProductAttributeOptions($session, 'color');
			foreach($result AS $val){
			  if($val->label != '')
          echo "<option value='".$val->value."'>".$val->label."</option>";
      }
			?>
		</select>
	  </div>
	</div>
	
	<!-- MARCA input-->
	<div class="control-group">
	  <label class="control-label" for="input-marca">Marca</label>
	  <div class="controls">
	    <select id="input-marca" name="input-marca" required="">
			<option value=""></option>
			<?php
			$result = $client->catalogProductAttributeOptions($session, 'manufacturer');
			foreach($result AS $val){
			  if($val->label != '')
          echo "<option value='".$val->value."'>".$val->label."</option>";
      }
			?>
		</select>
	  </div>
	</div>
	
	<!-- TAMANHO input-->
	<div class="control-group">
	  <label class="control-label" for="input-tamanho">Tamanho</label>
	  <div class="controls">
	    <select id="input-tamanho" name="input-tamanho" required="">
			<option value=""></option>
			<?php
			$result = $client->catalogProductAttributeOptions($session, 'tamanho');
			foreach($result AS $val){
			  if($val->label != '')
          echo "<option value='".$val->value."'>".$val->label."</option>";
      }
			?>
		</select>
	  </div>
	</div>
	
	<!-- FRETE input-->
	<div class="control-group">
	  <label class="control-label" for="input-frete">Frete Grátis</label>
	  <div class="controls">
	    <select id="input-frete" name="input-frete" required="">
			<option value=""></option>
			<option value="0">Não</option>
			<option value="1">Sim</option>
		</select>
	  </div>
	</div>
	
	<!-- LANCAMENTO input-->
	<div class="control-group">
	  <label class="control-label" for="input-lancamento">Lançamento</label>
	  <div class="controls">
	    <select id="input-lancamento" name="input-lancamento" required="">
			<option value=""></option>
			<option value="0">Não</option>
			<option value="1">Sim</option>
		</select>
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="">Descriçao</label>
	  <div class="controls">
	    <textarea id="input-descricao" name="input-descricao" class="input-xlarge" required=""></textarea>
	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="">Peso</label>
	  <div class="controls">
	    <input type="text" id="input-peso" name="input-peso" class="input-xlarge" required="">	    
	  </div>
	</div>

	<!-- Select input-->
	<div class="control-group">
	  <label class="control-label" for="nome">Unidade</label>
	  <div class="controls">
	    <select id="input-unidade" name="input-unidade" required="">
			<option value=""></option>
			<?php
			$sql = "SELECT codigo, nome FROM unidades ORDER BY nome ";
			$result = mysql_query($sql);
			while(list($codU,$nomeU)=mysql_fetch_row($result)){
				echo "<option value='$codU'>$nomeU</option>";
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