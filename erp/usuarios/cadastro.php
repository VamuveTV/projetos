<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Usuários
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
				echo "<option value='$codU'>$nomeU</option>";
			}
	    	?>	
	    </select>    
	  </div>
	</div>


        <!-- Perfil -->
        <div class="control-group">
            <label class="control-label" for="input-perfil">Perfil</label>
            <div class="controls">
                <select id="input-perfil" name="input-perfil" class="input-xlarge">
                    <option value=""></option>
                    <?php
                    $sql = "SELECT codigo, nome FROM perfil ORDER BY nome";
                    $result = mysql_query($sql);
                    while(list($codU,$nomeU)=mysql_fetch_row($result)){
                        echo "<option value='$codU'>$nomeU</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-nome">Nome</label>
	  <div class="controls">
	    <input id="input-nome" name="input-nome" placeholder="" class="input-xlarge" required="" type="text">	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-login">Login</label>
	  <div class="controls">
	    <input id="input-login" name="input-login" class="input-xlarge" required="" type="text">	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-senha">Senha</label>
	  <div class="controls">
	    <input id="input-senha" name="input-senha" class="input-xlarge" required="" type="password">	    
	  </div>
	</div>
	
	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	<button type="button" id="cancelar" class="btn btn-warning">Cancelar</button>
</div>
</form>