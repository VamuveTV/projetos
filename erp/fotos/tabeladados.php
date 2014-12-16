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
	$(document).ready(function(){
		$('.loader').hide();
	})
</script>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th width="5%">Código</th>
		  <th>Produto</th>		  
		  <th width="15%">Ações</th>
	  </tr>
  </thead>   
  <tbody>
  <?php
		$sql = "SELECT p.codigo, p.nome FROM grupo_produtos AS p ORDER BY p.nome ";
		$res = mysql_query($sql);		
		while ($dados = mysql_fetch_array($res)) { ?>
	<tr>
		<td class="center"><?php echo $dados['codigo']; ?></td>
		<td><?php echo $dados['nome']; ?></td>
		<td align="center">												
			<button class="btn btn-info" onclick="cad_foto(<?php echo $dados['codigo']; ?>)">
				<i class="icon-edit icon-white"></i>  
				Fotos                                            
			</button>
		</td>
	</tr>
	<?php
	}
	?>
	
	
  </tbody>
  </table>