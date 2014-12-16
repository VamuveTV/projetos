<?php 
session_start();
include("../conectar.php");
?>
<script type="text/javascript">
$(".campo_busca").keypress(function(event) {
  if(event.which == 13)
	chamaTabela2();     
});
</script>
<p><button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button></p>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th>Código</th>
		  <th width="60%">Nome</th>
		  <th>Sigla</th>
	  </tr>
	  <tr>
		<th><input type="text" style="width: 60px" id="buscaCodigo" class="campo_busca" value="<?php echo $_POST['cod'];?>"></th>
		<th><input type="text" style="width: 100%" id="buscaNome" class="campo_busca" value="<?php echo $_POST['nome'];?>"></th>
		<th><input type="text" style="width: 80px" id="buscaSigla" class="campo_busca" value="<?php echo $_POST['sigla'];?>"></th>
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

        $sql = "SELECT * FROM unidades WHERE codigo > 0 ";
		if($_POST['cod'])
			$sql.= "AND codigo='".$_POST['cod']."' ";
		if($_POST['nome'])
			$sql.= "AND nome LIKE '%".$_POST['nome']."%' ";
		if($_POST['sigla'])
			$sql.= "AND sigla LIKE '%".$_POST['sigla']."%' ";
		$sql.= "ORDER BY codigo, nome $aux";
		$res = mysql_query($sql);		
		while ($dados = mysql_fetch_array($res)) { ?>
	<tr>
		<td class="center"><?php echo $dados['codigo']; ?></td>
		<td><?php echo $dados['nome']; ?></td>
		<td><?php echo $dados['sigla']; ?></td>
		<td align="center">												
			<button class="btn btn-info" onclick="edita(<?php echo $dados['codigo']; ?>)">
				<i class="icon-edit icon-white"></i>  
				Editar                                            
			</button>
			<button class="btn btn-danger" onclick="janelaConfirma($(this).val());" value="<?php echo $dados['codigo']; ?>">
				<i class="icon-trash icon-white"></i> 
				Excluir
			</button>
		</td>
	</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>
<button class="btn btn-small" onclick="novo()"><i class="icon-plus"></i> Adicionar</button>
<?php

//query para ver qual o total de paginas
$sql = "SELECT * FROM unidades";
$res = mysql_query($sql);
$cont = mysql_num_rows($res);
$cont = ceil($cont / 10);

?>

<div class="pagination pagination-centered">
    <ul id="botao">
        <?php
        if($pagina != 1)
            echo "<li><a id=\"anterior\" href=\"#\">Anterior</a></li>";

        if($pagina <=3)
            $aux2 = 1;
        else
            $aux2 = $pagina - 3;
        // Mostrar os links da paginação.

        if($pagina != $cont)
            $proximo = "<li><a id=\"proximo\" href=\"#\">Próximo</a></li>";
        else
            $proximo = "";

        $fim = $pagina + 3;

        if($fim >= $cont)
        {
            $fim = $cont;
        }
        for($i=$aux2; $i<=$fim; $i++)
        {

            echo '<li class="pagination" id="'.$i.'"><a href="#">'.$i.'</a></li>';

        }
        ?>
        <input type="hidden" id="teste" />
        <input type="hidden" id="total" value="<?php echo $i - 1; ?>" />
        <?php
        echo $proximo;
        ?>

    </ul>

</div>
