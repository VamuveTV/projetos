<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
include("../conectarSoap.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM produtos WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);
?>
<script type="text/javascript">
    $(function() {

	//treeview
	$("#browser").treeview({collapsed: true});
	
	$('#formCadastro').submit(function() {
		var foto = $('.fileName').html();
		if(foto == null){ //se nao tiver foto		
				var cod	=	$('#input-cod').val();
                var classificacao	=	$('#input-classificacao').val();
                var nome		=	$('#input-nome').val();
                var descricao	=	$('#input-descricao').val();
                //var unidade		=	$('#input-unidade').val();
                
                var cor		=	$('#input-cor').val();
                var tamanho		=	$('#input-tamanho').val();
                var frete		=	$('#input-frete').val();
                var lancamento	=	$('#input-lancamento').val();
                var peso		=	$('#input-peso').val();
                var referencia	=	$('#input-referencia').val();
                var imposto		=	$('#input-imposto').val();
                var marca		=	$('#input-marca').val();

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
							url: "ajax_editar.php", //página requisitada
							type: "POST",
							data: {'cod': cod, 'nome' : nome, 'classificacao': classificacao, 'descricao' : descricao, 'unidade[]' : unidade, 'cor': cor, 'tamanho': tamanho, 'frete': frete, 'lancamento': lancamento, 'peso': peso, 'referencia': referencia, 'imposto': imposto, 'marca': marca, 'categorias[]': categorias},
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
                var cod	=	$('#input-cod').val();
                var classificacao	=	$('#input-classificacao').val();
                var nome		=	$('#input-nome').val();
                var descricao	=	$('#input-descricao').val();
                //var unidade		=	$('#input-unidade').val();
                
                var cor		=	$('#input-cor').val();
                var tamanho		=	$('#input-tamanho').val();
                var frete		=	$('#input-frete').val();
                var lancamento	=	$('#input-lancamento').val();
                var peso		=	$('#input-peso').val();
                var referencia	=	$('#input-referencia').val();
                var imposto		=	$('#input-imposto').val();
                var marca		=	$('#input-marca').val();

				var categorias = new Array();
				$("input[type=checkbox][name='cat[]']:checked").each(function(){
				    categorias.push($(this).val());
				});

				var unidade = new Array();
				$("#unidade option:selected").each(function(){
				    unidade.push($(this).val());
				});

                var formData = {'cod': cod,'nome' : nome, 'classificacao': classificacao, 'descricao' : descricao, 'unidade[]' : unidade, 'cor': cor, 'tamanho': tamanho, 'frete': frete, 'lancamento': lancamento, 'peso': peso, 'referencia': referencia, 'imposto': imposto, 'marca': marca, 'categorias[]': categorias}
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
<form name="form_cadastro" id="formCadastro" onsubmit="return false;" class=" form-horizontal well ucase">
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
		//buscando as categorias do produto
		$sql = "SELECT categoria FROM categorias_produtos WHERE produto='".$_POST['cod']."'";
		$res = mysql_query($sql);
		$categorias_prod = array();
		while(list($cat)=mysql_fetch_row($res)){
			$categorias_prod[] = $cat;			
		}
			    	
		//funcao para ler cada children da categoria
		function leVetor($vetor){
		  global $categorias_prod;
		  $size = count($vetor);
		  if($size > 0){
		    for($i=0; $i < $size; $i++){
		      echo "\t<li>";
		      echo "<input type='checkbox' name='cat[]' value='".$vetor[$i]->category_id."'";
		      if(in_array($vetor[$i]->category_id, $categorias_prod))
		      	echo " checked";
		      echo "> ";
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
		
		//conexao com soap
		include("../conectarSoap.php");
		
		$result = $client->catalogCategoryTree($session);
		echo "<ul id='browser'>\n";
		leVetor($result->children);
		echo "</ul>\n";
		?>
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="nome">Nome</label>
	  <div class="controls">
	    <input id="input-nome" name="input-nome" placeholder="" value="<?php echo $dados['nome'];?>" class="input-xlarge" required="" type="text">
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
		          echo "<option value='".$val->value."'";
				  echo $val->value==$dados['cor']?' selected':'';
		          echo ">".$val->label."</option>";
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
		          echo "<option value='".$val->value."'";
		          echo $val->value==$dados['marca']?' selected':'';
		          echo ">".$val->label."</option>";
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
		          echo "<option value='".$val->value."'";
		          echo $val->value==$dados['tamanho']?' selected':'';
		          echo ">".$val->label."</option>";
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
			<option value="0"<?php echo $dados['frete']=='0'?' selected':''; ?>>Não</option>
			<option value="1"<?php echo $dados['frete']=='1'?' selected':''; ?>>Sim</option>
		</select>
	  </div>
	</div>
	
	<!-- LANCAMENTO input-->
	<div class="control-group">
	  <label class="control-label" for="input-lancamento">Lançamento</label>
	  <div class="controls">
	    <select id="input-lancamento" name="input-lancamento" required="">
			<option value=""></option>
			<option value="0"<?php echo $dados['lancamento']=='0'?' selected':''; ?>>Não</option>
			<option value="1"<?php echo $dados['lancamento']=='1'?' selected':''; ?>>Sim</option>
		</select>
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="">Descriçao</label>
	  <div class="controls">
	    <textarea id="input-descricao" name="input-descricao" class="input-xlarge" required=""><?php echo $dados['descricao'];?></textarea>	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="">Peso</label>
	  <div class="controls">
	    <input type="text" id="input-peso" name="input-peso" class="input-xlarge" required="" value="<?php echo $dados['peso'];?>">
	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="referencia">Referência</label>
	  <div class="controls">
	    <input type="text" id="input-referencia" name="input-referencia" class="input-xlarge" required="" value="<?php echo $dados['referencia'];?>">
	    
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="imposto">Imposto</label>
	  <div class="controls">
	  	<div class="input-append">		
	    <input type="text" id="imposto" name="imposto" class="input-small" value="<?php echo $dados['imposto'];?>">
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
				//verificando se a unidade já foi marcada
				$sql2 = "SELECT * FROM unidades_produtos WHERE produto='".$_POST['cod']."' AND unidade='$codU'";
				$res2 = mysql_query($sql2);
				$comp = mysql_num_rows($res2)>0?' selected':'';
				echo "<option value='$codU' $comp>$nomeU</option>";
			}
			?>
		</select>
	  </div>
	</div>

	<!-- FOTO -->
	<div class="control-group">
	  <label class="control-label" for="file">Foto</label>
	  <div class="controls">
	    <input type="file" name="file_upload" id="file_upload" required="" value="<?php echo $dados['foto'];?>">
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