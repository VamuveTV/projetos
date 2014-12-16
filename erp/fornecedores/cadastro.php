<script language="text/javascript">
    $("#input-cep").mask("99999-999");
    $("#input-telefone").mask("(99)9999-9999");
    $("#input-cnpj").mask("99.999.999/9999-99");
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
	    <input id="input-nome" name="input-nome" placeholder="" class="input-xlarge" required="" type="text">
	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="">E-mail</label>
	  <div class="controls">
	    <input id="input-email" name="input-email" placeholder="" class="input-xlarge" required="" type="email">
	    
	  </div>
	</div>

        <!-- Cep input-->
        <div class="control-group">
            <label class="control-label" for="">Cep</label>
            <div class="controls">
                <input id="input-cep" name="input-cep" placeholder="" onblur="buscaCep(this.value)" pattern="[0-9]{5}(\-[0-9]{3})?" class="input-small" required="" type="text">

            </div>
        </div>

        <!-- Endereco input-->
        <div class="control-group">
            <label class="control-label" for="">Endereço</label>
            <div class="controls">
                <input id="input-endereco" name="input-endereco" placeholder="" class="input-xlarge" required="" type="text">
                Número
                <input id="input-numero" name="input-numero" placeholder="" class="input-small" required="" type="text">
                Bairro
                <input id="input-bairro" name="input-bairro" class="input-small" required="" type="text">
            </div>
        </div>

        <!-- Complemento input-->
        <div class="control-group">
            <label class="control-label" for="">Complemento</label>
            <div class="controls">
                <input id="input-complemento" name="input-complemento" type="text">
            </div>
        </div>

        <!-- Cidade input-->
        <div class="control-group">
            <label class="control-label" for="input-cidade">Cidade</label>
            <div class="controls">
                <input id="input-cidade" name="input-cidade" placeholder="" class="input-xlarge" required="" type="text">

            </div>
        </div>

        <!-- Estado input-->
        <div class="control-group">
            <label class="control-label" for="input-estado">Estado</label>
            <div class="controls">
                <select name="input-estado" id="input-estado" class="input-xlarge">
                    <option>Escolha o Estado</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espirito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraiba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantis</option>
                </select>

            </div>
        </div>
	
	<!-- Telefone input-->
	<div class="control-group">
	  <label class="control-label" for="input-telefone">Telefone</label>
	  <div class="controls">
	    <input id="input-telefone" name="input-telefone" placeholder="" class="input-medium" required="" type="tel">
	    
	</div>
    </div>

    <!-- I.E input-->
    <div class="control-group">
        <label class="control-label" for="input-ie">I.E</label>
            <div class="controls">
                <input id="input-ie" name="input-ie" placeholder="" class="input-medium" required="" >
            </div>
    </div>

    <!-- CNPJ input-->
    <div class="control-group">
        <label class="control-label" for="input-cnpj">CNPJ</label>
            <div class="controls">
                <input id="input-cnpj" name="input-cnpj" placeholder="" class="input-medium" required="" >
            </div>
    </div>

    <!-- Contato input-->
    <div class="control-group">
        <label class="control-label" for="input-contato">Contato</label>
            <div class="controls">
                <input id="input-contato" name="input-contato" placeholder="" class="input-medium" >
            </div>
    </div>

    </fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	<button type="button" id="cancelar" class="btn btn-warning">Cancelar</button>
</div>
</form>