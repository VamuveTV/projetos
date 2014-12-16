<?php
session_start();
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM empresas WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);
?>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Trocar senha

	</legend>
	<fieldset id="address-form">
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="nome">Senha atual</label>
	  <div class="controls">
          <input id="senha_atual" name="senha_atual" placeholder="" class="input-xlarge" required="" onblur="vSenha2()" type="password" />
          <input type="hidden" id="codigo" value="<?php echo $_SESSION["codigo"]; ?>" />
	    
	  </div>
	</div>

        <div class="control-group">
            <label class="control-label" for="senha">Nova Senha</label>
            <div class="controls">
                <input id="novasenha" name="novasenha" placeholder="" class="input-xlarge" required="" type="password" />

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="senha2">Repetir Senha</label>
            <div class="controls">
                <input id="senha2" name="senha2" placeholder="" onblur="vSenha()" class="input-xlarge" required="" type="password">

            </div>
        </div>

    </fieldset>
</fieldset>

<div class="form-actions">
	<input type="hidden" id="input-cod" name="input-cod" value="<?php echo $_POST['cod'];?>" />
	<button type="submit" id="salvar" class="btn btn-success">Salvar</button>

</div>
</form>