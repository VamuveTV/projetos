<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
session_start();
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();
$query = "SELECT * FROM produtos WHERE codigo='".$_POST['cod']."'";
$resultado = mysql_query($query);
$dados = mysql_fetch_array($resultado);

$_SESSION['produto'] = $_POST['cod'];
?>
<script>
    $(document).ready(function(){
		var caminho = 'upload.php';
        $("#fileUpload").fileUpload({
            'uploader': 'uploader.swf',
            'cancelImg': 'cancel.png',
            'folder': 'fotos',
            'script': caminho,
            'scriptData' : '{teste:123}'
        });
		
    });
</script>
<form name="form_edita" onsubmit="return false;" class=" form-horizontal well ucase">
<fieldset>
	<legend>Foto do Produto
			<button type="button" class="btn" style="float: right" onclick="chamaTabela()">Fechar</button>
	</legend>
	<fieldset id="address-form">
	
	<!-- Foto  -->
	<div class="control-group">
	  <label class="control-label" for="">Foto</label>
	  <div class="controls">
	    <input id="fileUpload" type="file" />
               <br>
				 <a class="btn btn-success" href="javascript:$('#fileUpload').fileUploadStart()">Enviar</a>
	    
	  </div>
	</div>

	<div class="control-group">
	</div>
	
	</div>
	</fieldset>
</fieldset>

<div class="form-actions">
	<input type="hidden" id="input-cod" name="input-cod" value="<?php echo $_POST['cod'];?>" />		
</div>
</form>