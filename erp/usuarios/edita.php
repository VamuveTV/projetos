<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM usuarios WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);
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
				echo "<option value='$codU'";
				echo $dados['unidade']==$codU?' selected':'';
				echo ">$nomeU</option>";
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
                        echo "<option value='$codU'";
                        echo $dados['perfil']==$codU?' selected':'';
                        echo ">$nomeU</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
		
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-nome">Nome</label>
	  <div class="controls">
	    <input id="input-nome" name="input-nome" value="<?php echo $dados['nome']; ?>" class="input-xlarge" required="" type="text">	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-login">Login</label>
	  <div class="controls">
	    <input id="input-login" name="input-login" value="<?php echo $dados['login']; ?>" class="input-xlarge" required="" type="text">	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="input-senha">Senha</label>
	  <div class="controls">
	    <input id="input-senha" name="input-senha" value="<?php echo $dados['senha']; ?>" class="input-xlarge" required="" type="password">	    
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