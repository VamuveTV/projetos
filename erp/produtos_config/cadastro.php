<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
include("../conectarSoap.php");
$banco = new ZarbMysql();
?>
<script type="text/javascript">
    $(function() {
	
	//treeview
	$("#browser").treeview({collapsed: true});

	$('#formCadastro').submit(function() {
		var foto = $('.fileName').html();
		if(foto == null){
			var nome		=	$('#nome').val();
            var descricao	=	$('#descricao').val();
			var preco		=	$('#preco').val();
            //subprodutos
            var sub = new Array();
			$("input[type=checkbox][name='sub[]']:checked").each(function(){
			    sub.push($(this).val());
			});
			
			//atributos
			var attr = new Array();
			$("input[type=checkbox][name='attr[]']:checked").each(function(){
			    attr.push($(this).val());
			});
            
                if($("form")[0].checkValidity()) {  //verificando se o form foi validado
					$('.loader').show();
					$.ajax({//método ajax
						url: "ajax_cadastrar.php", //página requisitada
						type: "POST",
						data: {'nome' : nome, 'descricao' : descricao, 'preco' : preco, 'sub[]': sub, 'attr[]': attr},
						success: function(retorno){ //em caso de sucesso
							$('.loader').hide();
							fecha();
                           	$('.log').html('<div class="alert alert-info">'+retorno+'</div>');
							chamaTabela();
						},
						error: (function(retorno) {
                            fecha();
                            $(".log").html('<div class="alert alert-error">Falha ao cadastrar.</div>'); // seta a frase de erro, caso falhe.
                            chamaTabela();

						})
					});
			    }else console.log("invalid form");

		}
		else{
			$('.loader').show();
			$('#file_upload').uploadify('upload');
		}
	})

        $('#file_upload').uploadify({
            'auto'     : false,
            'swf'      : 'uploadify.swf',
            'uploader' : 'ajax_cadastrar.php',
            'onUploadSuccess' : function(file, data, response) {
            	//alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
				$('.loader').hide();
				fecha();
				$('.log').html('<div class="alert alert-info">'+data+'</div>');
				chamaTabela();
            },
            'onUploadStart' : function(file)
            {
                var nome		=	$('#nome').val();
                var descricao	=	$('#descricao').val();
				var preco		=	$('#preco').val();
                //subprodutos
                var sub = new Array();
				$("input[type=checkbox][name='sub[]']:checked").each(function(){
				    sub.push($(this).val());
				});
				
				//atributos
				var attr = new Array();
				$("input[type=checkbox][name='attr[]']:checked").each(function(){
				    attr.push($(this).val());
				});
				
                var formData = {'nome' : nome, 'descricao' : descricao, 'preco' : preco, 'sub[]': sub, 'attr[]': attr};
                $('#file_upload').uploadify("settings", "formData", formData);
            }
        });
    });
</script>
<form name="form_cadastro" id="formCadastro" onsubmit="return false;" class=" form-horizontal well ucase" action="ajax_cadastrar.php" enctype="multipart/form-data">
<fieldset>
	<legend>Cadastro de Produtos Configuráveis
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<div class="control-group">
	  <label class="control-label" for="nome">Nome</label>
	  <div class="controls">
	    <input id="nome" name="nome" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
	</div>
	
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="descricao">Descriçao</label>
	  <div class="controls">
	    <textarea id="descricao" name="descricao" class="input-xlarge" required=""></textarea>
	    
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="preco">Preço</label>
	  <div class="controls">
	    <input id="preco" name="preco" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
	</div>
	
	<!-- FOTO -->
	<div class="control-group">
	  <label class="control-label" for="file">Foto</label>
	  <div class="controls">
	    <input type="file" name="file_upload" id="file_upload" required="">
	  </div>
	</div>

	<!-- PRODUTOS ASSOCIADOS -->
	<div class="control-group">
	  <label class="control-label" for="file">Produtos Associados</label>
	  <div class="controls">
	    <?php
		$sql = "SELECT skumagento, nome FROM produtos ORDER BY nome";
		$result = mysql_query($sql);
		while(list($sku_prod,$nome_prod)=mysql_fetch_row($result)){
			echo "<input type='checkbox' name='sub[]' value='$sku_prod'> $nome_prod<br>";
		}
	    ?>
	  </div>
	</div>

	<!-- ATRIBUTOS -->
	<div class="control-group">
	  <label class="control-label" for="file">Atributos</label>
	  <div class="controls">
	    <?php
		//color
		$result = $client->catalogProductAttributeInfo($session, 'color');
	    echo "<input type='checkbox' name='attr[]' value='".$result->attribute_id."'> Cor<br>";
		
		//tamanho
		$result = $client->catalogProductAttributeInfo($session, 'tamanho');
	    echo "<input type='checkbox' name='attr[]' value='".$result->attribute_id."'> Tamanho<br>";
		
		//marca
		$result = $client->catalogProductAttributeInfo($session, 'manufacturer');
	    echo "<input type='checkbox' name='attr[]' value='".$result->attribute_id."'> Marca<br>";
		
	    ?>
	  </div>
	</div>
	
	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	<!--  <input type="button" id="btnEnviar" onclick="$('#file_upload').uploadify('upload')" class="btn btn-success" value="Enviar Arquivo" /> -->
	<button type="button" id="cancelar" class="btn btn-warning">Cancelar</button>
</div>
</form>