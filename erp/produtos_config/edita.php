<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
include("../conectarSoap.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM produtos_config WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);
?>
<script type="text/javascript">
    $(function() {

	//treeview
	$("#browser").treeview({collapsed: true});
	
	$('#formCadastro').submit(function() {
		var foto = $('.fileName').html();
		if(foto == null){
			var cod			=	$('#input-cod').val();
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
						url: "ajax_editar.php", //página requisitada
						type: "POST",
						data: {'cod': cod, 'nome' : nome, 'descricao' : descricao, 'preco' : preco, 'sub[]': sub, 'attr[]': attr},
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
            'uploader' : 'ajax_editar.php',
            'onUploadSuccess' : function(file, data, response) {
            	//alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
				$('.loader').hide();
				fecha();
				$('.log').html('<div class="alert alert-info">'+data+'</div>');
				chamaTabela();
            },
            'onUploadStart' : function(file)
            {
                var cod			=	$('#input-cod').val();
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

                var formData = {'cod': cod, 'nome' : nome, 'descricao' : descricao, 'preco' : preco, 'sub[]': sub, 'attr[]': attr}
                $('#file_upload').uploadify("settings", "formData", formData);
            }
        });
    });
</script>
<form name="form_cadastro" id="formCadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Produtos
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<div class="control-group">
	  <label class="control-label" for="nome">Nome</label>
	  <div class="controls">
	    <input id="nome" name="nome" value="<?php echo $dados['nome'];?>" placeholder="" class="input-xlarge" required="" type="text">
	  </div>
	</div>
	
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="descricao">Descriçao</label>
	  <div class="controls">
	    <textarea id="descricao" name="descricao" class="input-xlarge" required=""><?php echo $dados['descricao'];?></textarea>
	    
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="preco">Preço</label>
	  <div class="controls">
	    <input id="preco" name="preco" value="<?php echo $dados['preco'];?>" placeholder="" class="input-xlarge" required="" type="text">
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
		$sql = "SELECT codigo, skumagento, nome FROM produtos ORDER BY nome";
		$result = mysql_query($sql);
		while(list($cod_prod,$sku_prod,$nome_prod)=mysql_fetch_row($result)){
			$sql2 = "SELECT * FROM produtos_associados WHERE produto='".$_POST['cod']."' AND associado='$cod_prod' ";
			$result2 = mysql_query($sql2);
			$comp = mysql_num_rows($result2) > 0 ?'checked':'';
			echo "<input type='checkbox' name='sub[]' value='$sku_prod' $comp> $nome_prod<br>";
		}
	    ?>
	  </div>
	</div>

	<!-- ATRIBUTOS -->
	<div class="control-group">
	  <label class="control-label" for="file">Atributos</label>
	  <div class="controls">
	    <?php
		//buscando os atributos do produto
		$sql2 = "SELECT atributo FROM atributos_associados WHERE produto='".$_POST['cod']."'";
		$result2 = mysql_query($sql2);
		$attrs = array();
		while(list($attr_prod)=mysql_fetch_row($result2))
			$attrs[] = $attr_prod;
			
					
		//color		
		$result = $client->catalogProductAttributeInfo($session, 'color');
		$comp = in_array($result->attribute_id, $attrs) ?'checked':'';
	    echo "<input type='checkbox' name='attr[]' value='".$result->attribute_id."' $comp> Cor<br>";
		
		//tamanho
		$result = $client->catalogProductAttributeInfo($session, 'tamanho');
		$comp = in_array($result->attribute_id, $attrs) ?'checked':'';
	    echo "<input type='checkbox' name='attr[]' value='".$result->attribute_id."' $comp> Tamanho<br>";
		
		//marca
		$result = $client->catalogProductAttributeInfo($session, 'manufacturer');
		$comp = in_array($result->attribute_id, $attrs) ?'checked':'';
	    echo "<input type='checkbox' name='attr[]' value='".$result->attribute_id."' $comp> Marca<br>";
		
	    ?>
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