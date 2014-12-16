<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#cadastrar').click(function() {
		$('.loader').show();
		$('#file_upload').uploadify('upload');		
	})
	
	$('#file_upload').uploadify({
            'auto'     : false,
            'swf'      : 'uploadify.swf',
            'uploader' : 'ajax_cadastrar.php',
            'onUploadSuccess' : function(file, data, response) {
            	//alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);				
				fecha();
               	chamaTabela();
               	$('.log').html('<div class="alert alert-info">Foto cadastrada com sucesso</div>');								
            },
            'onUploadStart' : function(file)
            {
                var produto =	$('#produto').val();
                var cor 	=	$('#cor').val();
                
                var formData = {'produto' : produto, 'cor' : cor}
                $('#file_upload').uploadify("settings", "formData", formData);
            }
        });
})
</script>
<form name="form_cadastro" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Cadastro de Fotos
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<!-- Produto -->
	<div class="control-group">
	  <label class="control-label" for="input-unidade">Produto</label>
	  <div class="controls">	    
	    	<?php
	    	$sql = "SELECT nome FROM grupo_produtos WHERE codigo='".$_POST['cod']."'";
			$result = mysql_query($sql);
			list($nomeP)=mysql_fetch_row($result);
			echo "<b>$nomeP</b>";
	    	?>	
	  </div>
	</div>
	
	<!-- Cor -->
	<div class="control-group">
	  <label class="control-label" for="cor">Cor</label>
	  <div class="controls">	    
	    	<select name='cor' id='cor'>
	    		<?php
	    		$query2 = "SELECT codigo,nome FROM cores ORDER BY nome";
				$result2 = mysql_query($query2);
				while(list($codC,$nomeC)=mysql_fetch_row($result2)){
					echo "<option value='$codC'>$nomeC</option>";
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
	
	<div class="form-actions">
		<input type="hidden" name="produto" id="produto" value="<?php echo $_POST['cod'];?>">
		<button type="submit" id="cadastrar" class="btn btn-success">Cadastrar</button>
	</div>
		
		<?php
		$sql = "SELECT cores.nome, fotos.foto FROM cores INNER JOIN fotos ON cores.codigo=fotos.cor WHERE fotos.produto='".$_POST['cod']."'";
		$res = mysql_query($sql);
		$qtd = mysql_num_rows($res);
		if($qtd > 0){
			$ct_geral = $ct = 0;				
			echo "<table width='600' class='table table-striped table-bordered'>
					<tr>";
			while(list($nome_cor,$foto)=mysql_fetch_row($res)){
				$ct++;
				echo "<td width='200'>$nome_cor</td>
					  <td width='100'><img src='fotos/$foto' width='100'></td>";
				if($ct == 2 || $ct_geral == $qtd){
					$ct = 0;
					echo "</tr>";
					if($ct_geral < $qtd)
						echo '<tr>';
				}
				else if($ct_geral == $qtd){
					echo '<td>&nbsp;</td>';
					echo '</tr>';
				}
			}
			echo "</table>";
		}
		?>		
	
	</fieldset>
</fieldset>
</form>