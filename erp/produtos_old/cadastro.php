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
		if(foto == null){ //se nao tiver foto			
                var classificacao =	$('#classificacao').val();
                var nome		=	$('#nome').val();
                var descricao	=	$('#descricao').val();
                //var unidade		=	$('#unidade').val();                
                var cor			=	$('#cor').val();
                var tamanho		=	$('#tamanho').val();
                var frete		=	$('#frete').val();
                var lancamento	=	$('#lancamento').val();
                var peso		=	$('#peso').val();
                var referencia	=	$('#referencia').val();
                var imposto		=	$('#imposto').val();
                var marca		=	$('#marca').val();

				var categorias = new Array();
				$("input[type=checkbox][name='cat[]']:checked").each(function(){
				    categorias.push($(this).val());
				});

				var unidade = new Array();
				$("#unidade option:selected").each(function(){
				    unidade.push($(this).val());
				});
                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
						$('.loader').show();
						$.ajax({//método ajax
							url: "ajax_cadastrar.php", //página requisitada
							type: "POST",
							data: {'nome' : nome, 'classificacao': classificacao, 'descricao' : descricao, 'unidade[]' : unidade, 'cor': cor, 'tamanho': tamanho, 'frete': frete, 'lancamento': lancamento, 'peso': peso, 'referencia': referencia, 'imposto': imposto, 'marca': marca, 'categorias[]': categorias},
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
                var classificacao =	$('#classificacao').val();
                var nome		=	$('#nome').val();
                var descricao	=	$('#descricao').val();
                var unidade		=	$('#unidade').val();                
                var cor			=	$('#cor').val();
                var tamanho		=	$('#tamanho').val();
                var frete		=	$('#frete').val();
                var lancamento	=	$('#lancamento').val();
                var peso		=	$('#peso').val();
                var referencia	=	$('#referencia').val();
                var imposto		=	$('#imposto').val();
                var marca		=	$('#marca').val();

				var categorias = new Array();
				$("input[type=checkbox][name='cat[]']:checked").each(function(){
				    categorias.push($(this).val());
				});

				var unidade = new Array();
				$("#unidade option:selected").each(function(){
				    unidade.push($(this).val());
				});

                var formData = {'nome' : nome, 'classificacao': classificacao, 'descricao' : descricao, 'unidade[]' : unidade, 'cor': cor, 'tamanho': tamanho, 'frete': frete, 'lancamento': lancamento, 'peso': peso, 'referencia': referencia, 'imposto': imposto, 'marca': marca, 'categorias[]': categorias}
                $('#file_upload').uploadify("settings", "formData", formData);
            }
        });
    });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.multiselect').multiselect({
      buttonClass: 'btn',
      buttonWidth: 'auto',
      buttonContainer: '<div class="btn-group" />',
      maxHeight: false,
      buttonText: function(options) {
        if (options.length == 0) {
          return 'None selected <b class="caret"></b>';
        }
        else if (options.length > 3) {
          return options.length + ' selected  <b class="caret"></b>';
        }
        else {
          var selected = '';
          options.each(function() {
            selected += $(this).text() + ', ';
          });
          return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
        }
      }
    });
  });
</script>

<form name="form_cadastro" id="formCadastro" onsubmit="return false;" class=" form-horizontal well ucase" action="ajax_cadastrar.php" enctype="multipart/form-data">
<fieldset>
	<legend>Cadastro de Produtos
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<!-- Select input-->
	<div class="control-group">
	  <label class="control-label" for="nome">Categoria</label>
	  <div class="controls">
	    <?php
		//funcao para ler cada children da categoria
		function leVetor($vetor){
		  $size = count($vetor);
		  if($size > 0){
		    for($i=0; $i < $size; $i++){
		      echo "\t<li>";
		      echo "<input type='checkbox' name='cat[]' value='".$vetor[$i]->category_id."'> ";
		      echo $vetor[$i]->name;
			  echo " (".count($vetor[$i]->children).")";
				
				if($vetor[$i]->children > 0){
		          echo "\n\t<ul>";
		            leVetor($vetor[$i]->children);
		          echo "\n\t</ul>";
		        }
		      echo "</li>\n";		    
		    }
		  } 
		}
		
		$result = $client->catalogCategoryTree($session);
		echo "<ul id='browser'>\n";
		leVetor($result->children);
		echo "</ul>\n";
		?>
	  </div>
	</div>
	
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
	    <select id="cor" name="cor" required="">
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
	  <label class="control-label" for="marca">Marca</label>
	  <div class="controls">
	    <select id="marca" name="marca" required="">
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
	  <label class="control-label" for="tamanho">Tamanho</label>
	  <div class="controls">
	    <select id="tamanho" name="tamanho" required="">
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
	  <label class="control-label" for="frete">Frete Grátis</label>
	  <div class="controls">
	    <select id="frete" name="frete" required="">
			<option value=""></option>
			<option value="0">Não</option>
			<option value="1">Sim</option>
		</select>
	  </div>
	</div>
	
	<!-- LANCAMENTO input-->
	<div class="control-group">
	  <label class="control-label" for="lancamento">Lançamento</label>
	  <div class="controls">
	    <select id="lancamento" name="lancamento" required="">
			<option value=""></option>
			<option value="0">Não</option>
			<option value="1">Sim</option>
		</select>
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="descricao">Descriçao</label>
	  <div class="controls">
	    <textarea id="descricao" name="descricao" class="input-xlarge" required=""></textarea>
	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="peso">Peso</label>
	  <div class="controls">
	    <input type="text" id="peso" name="peso" class="input-xlarge" required="">	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="referencia">Referência</label>
	  <div class="controls">
	    <input type="text" id="referencia" name="referencia" class="input-xlarge" required="">	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="imposto">Imposto</label>
	  <div class="controls">
	  	<div class="input-append">
	    <input type="text" id="imposto" name="imposto" class="input-xlarge">
	    <span class="add-on">%</span>	 
	    </div>   
	  </div>
	</div>

	<!-- Select input-->
	<div class="control-group">
	  <label class="control-label" for="unidade">Unidade</label>
	  <div class="controls">
	    <select id="unidade" name="unidade[]" class="multiselect" multiple="multiple" required="">
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

	<!-- FOTO -->
	<div class="control-group">
	  <label class="control-label" for="file">Foto</label>
	  <div class="controls">
	    <input type="file" name="file_upload" id="file_upload" required="">
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