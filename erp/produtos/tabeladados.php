<?php 
session_start();
include("../conectar.php");
?>
<script type="text/javascript">
$(document).ready(function(){
	$('.loader').hide();
})
$(".campo_busca").keypress(function(event) {
  if(event.which == 13)
	chamaTabela2();     
});
</script>
<p>
	<button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
	<!-- <button class="btn btn-small" onclick="editarVarios()"><i class="icon-edit"></i> Editar selecionados</button> -->
</p>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
	  	  <th></th>
		  <th>Código</th>
		  <th width="65%">Nome</th>
		  <th></th>
	  </tr>
	  <tr>
	  	  <th></th>
		  <th><input type="text" id="buscaCodigo" class="campo_busca" value="<?php echo $_POST['cod'];?>"></th>
		  <th><input type="text" id="buscaNome" class="campo_busca" value="<?php echo $_POST['nome'];?>"></th>
		  <th width="180px"></th>
	  </tr>
  </thead>   
  <tbody>
  <?php

          $por_pagina = 10;
          $pagina = $_REQUEST['page'];
          $inicio = ($pagina-1)*$por_pagina;
          if($pagina == "undefined")
              $aux = "";
          else
              $aux = "LIMIT $inicio,$por_pagina";

		$sql = "SELECT p.codigo, p.nome 
				FROM grupo_produtos AS p WHERE p.codigo > 0 ";
			if($_POST['cod'])
				$sql.= "AND p.codigo='".$_POST['cod']."' ";
			if($_POST['nome'])
				$sql.= "AND p.nome LIKE '%".$_POST['nome']."%' ";
		$sql.= "ORDER BY p.nome $aux";
  		$res = mysql_query($sql);
		while ($dados = mysql_fetch_array($res)) { ?>
	<tr>
		<td><input type="checkbox" name="cod[]" value="<?php echo $dados['codigo']; ?>"></td>
		<td class="center"><?php echo $dados['codigo']; ?></td>
		<td><?php echo $dados['nome']; ?></td>
		<td align="center">												
			<button class="btn btn-info" onclick="edita(<?php echo $dados['codigo']; ?>)">
				<i class="icon-edit icon-white"></i>  
				Editar                                            
			</button>
			<button class="btn btn-danger" onclick="janelaConfirma($(this).val());" value="<?php echo $dados['codigo']; ?>">
				<i class="icon-trash icon-white"></i> 
				Excluir
			</button>
			<!-- <button onclick="carregaFoto(<?php echo $dados['codigo'];?>)" class="btn btn-success"><i class="icon-camera"></i> Foto</button> -->
		</td>
	</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>
<button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
<?php
$sql = "SELECT * FROM grupo_produtos ORDER BY codigo, nome";
$res = mysql_query($sql);
$cont = mysql_num_rows($res);
$por_pagina = 10;
$paginas = ceil($cont/$por_pagina);
?>

<div class="pagination pagination-centered">
    <ul id="botao">
        <li><a id="anterior" href="#">Anterior</a></li>
        <?php

        // Mostrar os links da paginação.
        for($i=1; $i<=$paginas; $i++)
        {
            echo '<li class="pagination" id="'.$i.'"><a href="#">'.$i.'</a></li>';
        }
        ?>
        <input type="hidden" id="teste" />
        <input type="hidden" id="total" value="<?php echo $i - 1; ?>" />
        <li><a id="proximo" href="#">Próximo</a></li>

    </ul>

</div>

