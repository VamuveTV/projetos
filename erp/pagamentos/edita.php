<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}

$query = "SELECT * FROM clientes WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);
$dados['data_nasc'] = converte_data($dados['data_nasc'],'usuario');
?>
<script type="text/javascript">
$("#input-cep").mask("99999-999");
$("#input-telefone").mask("(99)9999-9999");
$("#input-cpf").mask("999.999.999-99");
$("#input-data").mask("99/99/9999");

function buscaCep(cep){
	$('.loader').show();
	cep = cep.replace("-","");
	$.ajax({
		url: "busca_cep.php",
		type: "POST",
		data: {cep : cep},
		success: function(retorno){
			$('.loader').hide();
			dados = retorno.split('#');
			$('#input-endereco').val(dados[0]);
			$('#input-cidade').val(dados[1]);
			$('#input-bairro').val(dados[3]);
			$('#input-estado option').each(function(){
	           if($(this).val() == dados[2]){
	               $(this).attr('selected',true);
	           }
	       });
		}
	})

}

<?php
//buscando as configurações de crediário
$sql = "SELECT maximo_compra, maximo_parcela, parcela_minima FROM config_crediario LIMIT 0,1 ";
$result = mysql_query($sql);
list($maximo_compra,$maximo_parcela,$parcela_minima)=mysql_fetch_row($result);
?>

function mostraLimite(renda){
	var limite = (<?php echo $maximo_compra;?> * renda) / 100;
	$('#input-limite').val(limite); 
}

</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Clientes
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
	  <label class="control-label" for="">E-mail</label>
	  <div class="controls">
	    <input id="input-email" name="input-email" placeholder="" value="<?php echo $dados['email'];?>"  class="input-xlarge" type="email">
	    
	  </div>
	</div>

	<!-- Cep input-->
	<div class="control-group">
	  <label class="control-label" for="">Cep</label>
	  <div class="controls">
	    <input id="input-cep" name="input-cep" placeholder="" onblur="buscaCep(this.value)" value="<?php echo $dados['cep'];?>" class="input-xlarge" required="" type="text">
	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="">Endereço</label>
	  <div class="controls">
	    <input id="input-endereco" name="input-endereco" placeholder=""  value="<?php echo $dados['endereco'];?>" class="input-xlarge" required="" type="text">
	    Número
		<input id="input-numero" name="input-numero" placeholder="" value="<?php echo $dados['numero'];?>" class="input-small" required="" type="text">
		Bairro
		<input id="input-bairro" name="input-bairro" class="input-small" value="<?php echo $dados['bairro'];?>" required="" type="text">
	  </div>
	</div>

	<!-- Complemento input-->
	<div class="control-group">
	  <label class="control-label" for="">Complemento</label>
	  <div class="controls">
	    <input id="input-complemento" name="input-complemento" value="<?php echo $dados['complemento'];?>" type="text">	    
	  </div>
	</div>

	<!-- Cidade input-->
	<div class="control-group">
	  <label class="control-label" for="input-cidade">Cidade</label>
	  <div class="controls">
	    <input id="input-cidade" name="input-cidade" placeholder="" value="<?php echo $dados['cidade'];?>" class="input-xlarge" required="" type="text">
	    
	  </div>
	</div>

	<!-- Estado input-->
	<div class="control-group">
	  <label class="control-label" for="input-estado">Estado</label>
	  <div class="controls">
	    <select name="input-estado" id="input-estado" class="input-xlarge">
			<option>Escolha o Estado</option>
			<option value="AC"<?php echo $dados['estado']=='AC'?' selected':'';?>>Acre</option>
			<option value="AL"<?php echo $dados['estado']=='AL'?' selected':'';?>>Alagoas</option>
			<option value="AP"<?php echo $dados['estado']=='AP'?' selected':'';?>>Amapá</option>
			<option value="AM"<?php echo $dados['estado']=='AM'?' selected':'';?>>Amazonas</option>
			<option value="BA"<?php echo $dados['estado']=='BA'?' selected':'';?>>Bahia</option>
			<option value="CE"<?php echo $dados['estado']=='CE'?' selected':'';?>>Ceará</option>
			<option value="DF"<?php echo $dados['estado']=='DF'?' selected':'';?>>Distrito Federal</option>
			<option value="ES"<?php echo $dados['estado']=='ES'?' selected':'';?>>Espirito Santo</option>
			<option value="GO"<?php echo $dados['estado']=='GO'?' selected':'';?>>Goiás</option>
			<option value="MA"<?php echo $dados['estado']=='MA'?' selected':'';?>>Maranhão</option>
			<option value="MT"<?php echo $dados['estado']=='MT'?' selected':'';?>>Mato Grosso</option>
			<option value="MS"<?php echo $dados['estado']=='MS'?' selected':'';?>>Mato Grosso do Sul</option>
			<option value="MG"<?php echo $dados['estado']=='MG'?' selected':'';?>>Minas Gerais</option>
			<option value="PA"<?php echo $dados['estado']=='PA'?' selected':'';?>>Pará</option>
			<option value="PB"<?php echo $dados['estado']=='PB'?' selected':'';?>>Paraiba</option>
			<option value="PR"<?php echo $dados['estado']=='PR'?' selected':'';?>>Paraná</option>
			<option value="PE"<?php echo $dados['estado']=='PE'?' selected':'';?>>Pernambuco</option>
			<option value="PI"<?php echo $dados['estado']=='PI'?' selected':'';?>>Piauí</option>
			<option value="RJ"<?php echo $dados['estado']=='RJ'?' selected':'';?>>Rio de Janeiro</option>
			<option value="RN"<?php echo $dados['estado']=='RN'?' selected':'';?>>Rio Grande do Norte</option>
			<option value="RS"<?php echo $dados['estado']=='RS'?' selected':'';?>>Rio Grande do Sul</option>
			<option value="RO"<?php echo $dados['estado']=='RO'?' selected':'';?>>Rondônia</option>
			<option value="RR"<?php echo $dados['estado']=='RR'?' selected':'';?>>Roraima</option>
			<option value="SC"<?php echo $dados['estado']=='SC'?' selected':'';?>>Santa Catarina</option>
			<option value="SP"<?php echo $dados['estado']=='SP'?' selected':'';?>>São Paulo</option>
			<option value="SE"<?php echo $dados['estado']=='SE'?' selected':'';?>>Sergipe</option>
			<option value="TO"<?php echo $dados['estado']=='TO'?' selected':'';?>>Tocantis</option>
		</select>
	    
	  </div>
	</div>
	
	<!-- Telefone input-->
	<div class="control-group">
	  <label class="control-label" for="senha">Telefone</label>
	  <div class="controls">
	    <input id="input-telefone" name="input-telefone" placeholder="" class="input-xlarge" value="<?php echo $dados['telefone'];?>" required="" type="tel">
	    
	</div>
    </div>

	<!-- Renda input-->
	<div class="control-group">
	  <label class="control-label" for="input-renda">Renda mensal</label>
	  <div class="controls">
	    <input id="input-renda" name="input-renda" onblur="mostraLimite(this.value)" value="<?php echo $dados['renda'];?>" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- Limite input-->
	<div class="control-group">
	  <label class="control-label" for="input-limite">Limite de crediário</label>
	  <div class="controls">
	    <input id="input-limite" name="input-limite" value="<?php echo $dados['limite'];?>" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- cpf input-->
	<div class="control-group">
	  <label class="control-label" for="input-cpf">CPF</label>
	  <div class="controls">
	    <input id="input-cpf" name="input-cpf" value="<?php echo $dados['cpf'];?>" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- Identidade input-->
	<div class="control-group">
	  <label class="control-label" for="input-identidade">Identidade</label>
	  <div class="controls">
	    <input id="input-identidade" name="input-identidade" value="<?php echo $dados['identidade'];?>" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- Data de nascimento input-->
	<div class="control-group">
	  <label class="control-label" for="input-data">Data de nascimento</label>
	  <div class="controls">
	    <input id="input-data" name="input-data" value="<?php echo $dados['data_nasc'];?>" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
    </div>

	<!-- Conjuge input-->
	<div class="control-group">
	  <label class="control-label" for="input-conjuge">Cônjuge</label>
	  <div class="controls">
	    <input id="input-conjuge" name="input-conjuge" value="<?php echo $dados['conjuge'];?>" placeholder="" class="input-xlarge" type="text">
	  </div>
    </div>

	<!-- Estado civil input-->
	<div class="control-group">
	  <label class="control-label" for="input-civil">Estado civil</label>
	  <div class="controls">
	    <select name="input-civil" id="input-civil" class="input-xlarge">
			<option value="solteiro"<?php echo $dados['estado_civil']=='solteiro'?' selected':'';?>>Solteiro</option>
			<option value="casado"<?php echo $dados['estado_civil']=='casado'?' selected':'';?>>Casado</option>
			<option value="divorciado"<?php echo $dados['estado_civil']=='divorciado'?' selected':'';?>>Divorciado</option>
			<option value="viuvo"<?php echo $dados['estado_civil']=='viuvo'?' selected':'';?>>Viúvo</option>
		</select>
	  </div>
    </div>
    
    <!-- Observacao input-->
	<div class="control-group">
	  <label class="control-label" for="input-observacao">Observação</label>
	  <div class="controls">
	    <textarea id="input-observacao" name="input-observacao"><?php echo $dados['observacao'];?></textarea>
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