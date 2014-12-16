<?php 
session_start();
include("../conectar.php");

function converte_data($data,$tipo){
  if($tipo=="usuario")
    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
  
  if($tipo=="banco")
    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
  return $data;
}
?>
<script type="text/javascript">
    $("#buscaDataInicio").mask("99/99/9999");
    $("#buscaDataFim").mask("99/99/9999");

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
		  <th>Unidade</th>
		  <th>Produto</th>
		  <th>Data inicio</th>
		  <th>Data fim</th>
		  <th>Preço</th>
		  <th>Ações</th>
	  </tr>
      <tr>
          <th><input type="text" style="width: 30px" id="buscaCodigo" class="campo_busca" value="<?php echo $_POST['cod'];?>"></th>
          <th><input type="text" id="buscaUnidade" class="campo_busca" value="<?php echo $_POST['unidade'];?>"></th>
          <th><input type="text" id="buscaProduto" class="campo_busca" value="<?php echo $_POST['produto'];?>"></th>
          <th><input type="text" style="width: 80px" id="buscaDataInicio" class="campo_busca" value="<?php echo $_POST['data_inicio'];?>"></th>
          <th><input type="text" style="width: 80px" id="buscaDataFim" class="campo_busca" value="<?php echo $_POST['data_fim'];?>"></th>
          <th></th>
          <th></th>


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


        $sql = "SELECT p.codigo, u.nome AS unidade, prod.nome AS produto, p.data_inicio, p.data_fim, p.preco
				FROM promocoes AS p INNER JOIN produtos AS prod ON prod.codigo = p.produto
				INNER JOIN unidades AS u ON u.codigo=p.unidade";

          if($_POST['cod'])
              $sql.= " AND p.codigo='".$_POST['cod']."' ";
          if($_POST['produto'])
              $sql.= " AND prod.nome LIKE '%".$_POST['produto']."%' ";
          if($_POST['unidade'])
              $sql.= " AND u.nome='".$_POST['unidade']."' ";
          if($_POST['data_inicio'])
          {
              // Formatando data //
              $data = $_POST['data_inicio']; // Formato Mysql(YYYY/MM/DD)
              $data = explode("/", $data);
              $novadata = $data[2]."-".$data[1]."-".$data[0]; // Formato PT-BR(DD/MM/YYYY

              $sql.= " AND p.data_inicio='".$novadata."' ";
          }
          if($_POST['data_fim'])
          {
              // Formatando data //
              $data2 = $_POST['data_fim']; // Formato Mysql(YYYY/MM/DD)
              $data2 = explode("/", $data2);
              $novadata2 = $data2[2]."-".$data2[1]."-".$data2[0]; // Formato PT-BR(DD/MM/YYYY

              $sql.= " AND p.data_fim='".$novadata2."' ";
          }
          $sql.= " ORDER BY data_inicio DESC $aux";

        $res = mysql_query($sql);
		while ($dados = mysql_fetch_array($res)) { ?>
	<tr>
		<td class="center"><?php echo $dados['codigo']; ?></td>
		<td><?php echo $dados['unidade']; ?></td>
		<td><?php echo $dados['produto']; ?></td>
		<td><?php echo converte_data($dados['data_inicio'],"usuario"); ?></td>
		<td><?php echo converte_data($dados['data_fim'],"usuario"); ?></td>
		<td><?php echo number_format($dados['preco'],2,",","."); ?></td>
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
$sql = "SELECT * FROM promocoes";
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
