<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM fornecedores WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);
?>
<script language="text/javascript">
    $("#input-cep").mask("99999-999");
    $("#input-telefone").mask("(99)9999-9999");
    $("#input-data").mask("99/99/9999");
    $("#input-cnpj").mask("99.999.999/9999-99");

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
</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Fornecedores
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
	    <input id="input-email" name="input-email" placeholder="" value="<?php echo $dados['email'];?>"  class="input-xlarge" required="" type="email">
	    
	  </div>
	</div>


        <!-- Cep input-->
        <div class="control-group">
            <label class="control-label" for="">Cep</label>
            <div class="controls">
                <input id="input-cep" name="input-cep" placeholder="" onblur="buscaCep(this.value)" pattern="[0-9]{5}(\-[0-9]{3})?" class="input-small" value="<?php echo $dados['cep'];?>" required="" type="text">

            </div>
        </div>

        <!-- Endereco input-->
        <div class="control-group">
            <label class="control-label" for="">Endereço</label>
            <div class="controls">
                <input id="input-endereco" name="input-endereco" value="<?php echo $dados['endereco'];?>" placeholder="" class="input-xlarge" required="" type="text">
                Número
                <input id="input-numero" name="input-numero" value="<?php echo $dados['numero'];?>" placeholder="" class="input-small" required="" type="text">
                Bairro
                <input id="input-bairro" name="input-bairro" value="<?php echo $dados['bairro'];?>" class="input-small" required="" type="text">
            </div>
        </div>

        <!-- Complemento input-->
        <div class="control-group">
            <label class="control-label" for="">Complemento</label>
            <div class="controls">
                <input id="input-complemento" value="<?php echo $dados['complemento'];?>" name="input-complemento" type="text">
            </div>
        </div>

        <!-- Cidade input-->
        <div class="control-group">
            <label class="control-label" for="input-cidade">Cidade</label>
            <div class="controls">
                <input id="input-cidade" name="input-cidade"  placeholder="" value="<?php echo $dados['cidade'];?>" class="input-xlarge" required="" type="text">

            </div>
        </div>

        <!-- Estado input-->
        <div class="control-group">
            <label class="control-label" for="input-estado">Estado</label>
            <div class="controls">
                <select name="input-estado" id="input-estado" class="input-xlarge" required="">
                    <option value="">Escolha o Estado</option>
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
            <label class="control-label" for="input-telefone">Telefone</label>
            <div class="controls">
                <input id="input-telefone" name="input-telefone" value="<?php echo $dados['telefone'];?>" placeholder="" class="input-medium" required="" type="tel">

            </div>
        </div>

        <!-- I.E input-->
        <div class="control-group">
            <label class="control-label" for="input-ie">I.E</label>
            <div class="controls">
                <input id="input-ie" name="input-ie" placeholder="" value="<?php echo $dados['ie'];?>" class="input-medium" required="" >
            </div>
        </div>

        <!-- CNPJ input-->
        <div class="control-group">
            <label class="control-label" for="input-cnpj">CNPJ</label>
            <div class="controls">
                <input id="input-cnpj" name="input-cnpj" placeholder="" value="<?php echo $dados['cnpj'];?>" class="input-medium" required="" >
            </div>
        </div>

        <!-- Contato input-->
        <div class="control-group">
            <label class="control-label" for="input-contato">Contato</label>
            <div class="controls">
                <input id="input-contato" name="input-contato" placeholder="" value="<?php echo $dados['contato'];?>" class="input-medium" >
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