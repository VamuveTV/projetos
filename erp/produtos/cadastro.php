<?php
session_start();

include("../classes/zarbmysql.php");
include("../conectar.php");
include("../conectarSoap.php");
$banco = new ZarbMysql();
?>
<link href="../css/select2.css" rel="stylesheet"/>
<script src="../js/select2.js"></script>
<script type="text/javascript">
  $('#marca').select2({
      placeholder: "Selecione a marca"
  });
  $('#frete').select2({
      placeholder: "Selecione o frete"
  });
  $('#lancamento').select2({
      placeholder: "Selecione o lançamento"
  });
  $("#unidades").select2({
      placeholder: "Selecione a unidade"
  });
   $(function() {
	
	//treeview
	$("#browser").treeview({collapsed: true});

	$('#formCadastro').submit(function() {
                var classificacao =	$('#classificacao').val();
                var nome		=	$('#nome').val();
                var descricao	=	$('#descricao').val();
                var frete		=	$('#frete').val();
                var lancamento	=	$('#lancamento').val();
                var peso		=	$('#peso').val();
                var referencia	=	$('#referencia').val();
                var imposto		=	$('#imposto').val();
                var marca		=	$('#marca').val();
                var valor		=	$('#valor').val();

				var categorias = new Array();
				$("input[type=checkbox][name='cat[]']:checked").each(function(){
				    categorias.push($(this).val());
				});

                var unidade = new Array();
                $("#unidades :selected" ).each( function( i, selected ) {
                    unidade[i] = $(selected).val();

                });

                var tamanho = new Array();
				$("select[name='tamanho[]']").each(function(){
				    if($(this).val() != '')
				    	tamanho.push($(this).val());
				});
				
				var cor = new Array();
				$("select[name='cor[]']").each(function(){
				    if($(this).val() != '')
				    	cor.push($(this).val());
				});

                var unidade2 = new Array();
                $("select[name='unidades2[]']").each(function(){
                    unidade2.push($(this).val());
                });
				
				var quantidade = new Array();
				$("input[name='quantidade[]']").each(function(){
				    if($(this).val() != '')
				    	quantidade.push($(this).val());
				});			
                
                    if($("form")[0].checkValidity()) {  //verificando se o form foi validado
						$('.loader').show();
						$.ajax({//método ajax
							url: "ajax_cadastrar.php", //página requisitada
							type: "POST",
							data: {'nome' : nome, 'classificacao': classificacao, 'descricao' : descricao, 'unidade[]' : unidade, 'unidade2[]' : unidade2, 'cor[]': cor, 'tamanho[]': tamanho, 'quantidade[]': quantidade, 'frete': frete, 'lancamento': lancamento, 'peso': peso, 'referencia': referencia, 'imposto': imposto, 'marca': marca, 'valor': valor, 'categorias[]': categorias},
							success: function(retorno){ //em caso de sucesso								
								fecha();
                               	chamaTabela();
                               	$('.log').html('<div class="alert alert-info">'+retorno+'</div>');								
							},
							error: (function(retorno) {
                                fecha();
                                $(".log").html('<div class="alert alert-error">Falha ao cadastrar.</div>'); // seta a frase de erro, caso falhe.
                                chamaTabela();

							})
						});
				    }else console.log("invalid form");		
	})

    });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#valor').maskMoney({decimal:",",thousands:"."});
  });
</script>

<form name="form_cadastro" id="formCadastro" onsubmit="return false;" class=" form-horizontal well ucase" action="ajax_cadastrar.php" enctype="multipart/form-data">
<fieldset>
	<legend>Cadastro de Produtos

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
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="referencia">Referência</label>
	  <div class="controls">
	    <input type="text" id="referencia" name="referencia" class="input-xlarge" required="">	    
	  </div>
	</div>	
	
	<!-- MARCA input-->
	<div class="control-group">
	  <label class="control-label" for="marca">Marca</label>
	  <div class="controls">
	    <select id="marca" name="marca" class="input-xlarge" required="">
			<option value=""></option>
			<?php
			/*
			$result = $client->catalogProductAttributeOptions($session, 'manufacturer');
			foreach($result AS $val){
			  if($val->label != '')
		          echo "<option value='".$val->value."'>".$val->label."</option>";
		      }
			 * 
			 */
			 $sql = "SELECT codigo,nome FROM marca ORDER BY nome ";
			 $res = mysql_query($sql);
			 while(list($codM,$nomeM)=mysql_fetch_row($res)){
			 	echo "<option value='".$codM."'>".$nomeM."</option>";
			 }
			?>
		</select>
	  </div>
	</div>
	
	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="valor">Valor</label>
	  <div class="controls">
	    <input type="text" id="valor" name="valor" class="input-xlarge" required="">	    
	  </div>
	</div>
		
	<!-- FRETE input-->
	<div class="control-group">
	  <label class="control-label" for="frete">Frete Grátis</label>
	  <div class="controls">
	    <select id="frete" name="frete" class="input-xlarge" required="">
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
	    <select id="lancamento" name="lancamento" class="input-xlarge" required="">
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
	  <label class="control-label" for="imposto">Imposto</label>
	  <div class="controls">
	  	<div class="input-append">
	    <input type="text" id="imposto" name="imposto" class="input-xlarge">
	    <span class="add-on">%</span>	 
	    </div>   
	  </div>
	</div>	
	
	<table id="itens" class="table table-striped table-bordered bootstrap-datatable datatable">
		<tr>
			<th colspan="4">Unidades:</th>
		</tr>
		<tr>


            <td colspan="4">
                <select id="unidades" name="unidades" style="width: 100%;" required="" multiple="multiple">
                    <option value=""></option>
                    <?php
                    $query2 = "SELECT codigo,nome FROM unidades ORDER BY nome";
                    $result2 = mysql_query($query2);
                    while(list($codU,$nomeU)=mysql_fetch_row($result2)){
                        echo "<option value=\"$codU\">$nomeU</option>";

                    }
                    ?>

                </select>
			</td>
		</tr>
		<tr>
			<th>Tamanho</th>
			<th>Cor</th>
			<th>Quantidade</th>
            <th>Lojas</th>
			<th></th>
		</tr>
		<?php
			echo "<tr>";
					echo "<td>"; //TAMANHOS
						echo "<select name='tamanho[]'>";
						$query2 = "SELECT codigo,nome FROM tamanhos ORDER BY nome";
						$result2 = mysql_query($query2);
						while(list($codT,$nomeT)=mysql_fetch_row($result2)){
							echo "<option value='$codT'>$nomeT</option>";
						}
						echo "</select>";
					echo "</td>";
					echo "<td>"; //CORES
						echo "<select name='cor[]'>";
						$query2 = "SELECT codigo,nome FROM cores ORDER BY nome";
						$result2 = mysql_query($query2);
						while(list($codC,$nomeC)=mysql_fetch_row($result2)){
							echo "<option value='$codC'>$nomeC</option>";
						}
						echo "</select>";
					echo "</td>";
					echo "<td>"; //QUANTIDADE
						echo "	<input type='text' style='width: 20px' name='quantidade[]'>";
					echo "</td>";
                    echo  "<td>";
                         echo "<select id=\"unidades2[]\" name=\"unidades2[]\" >";
        echo "<option value=\"\"></option>";

        $query2 = "SELECT codigo,nome FROM unidades ORDER BY nome";
        $result2 = mysql_query($query2);
        while(list($codU,$nomeU)=mysql_fetch_row($result2)){
            echo "<option value=\"$codU\">$nomeU</option>";

        }


                          echo "</select>";
                    echo "</td>";
					echo "<td>";
						echo "<input type='button' class='btn btn-mini btn-primary' id='addItem' value='+'>";
					echo "</td>";
			echo "</tr>";	
		
		?>		
	</table>
	
	
	</fieldset>
</fieldset>

<div class="form-actions">
	<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	<!--  <input type="button" id="btnEnviar" onclick="$('#file_upload').uploadify('upload')" class="btn btn-success" value="Enviar Arquivo" /> -->
	<button type="button" id="cancelar" class="btn btn-warning" onclick="chamaTabela()">Cancelar</button>
</div>
</form>