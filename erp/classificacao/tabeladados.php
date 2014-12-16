<?php 
session_start();
include("../conectar.php");
?>
<script type="text/javascript">
$(document).ready(function(){	
  	
	$("#browser").treeview({});
	
	
})
</script>
<table class="table table-striped table-bordered bootstrap-datatable datatable">
  <thead>
	  <tr>
		  <th>Categorias</th>
	  </tr>
  </thead>   
  <tbody>
	<tr>
		<td>
		<?php
		//funcao para ler cada children da categoria
		function leVetor($vetor){
		  $size = count($vetor);
		  if($size > 0){
		    for($i=0; $i < $size; $i++){
		      echo "\t<li>".$vetor[$i]->name;
			  echo " (".count($vetor[$i]->children).")";
				echo '&nbsp;<span onclick="novo('.$vetor[$i]->category_id.',\''.$vetor[$i]->name.'\')" title=".icon  .icon-color  .icon-add " class="icon icon-color icon-plus"></span>';			  
			  	echo '&nbsp;<span onclick="edita('.$vetor[$i]->category_id.')" title=".icon  .icon-color  .icon-edit " class="icon icon-color icon-edit"></span>';
				echo '&nbsp;<span value="'.$vetor[$i]->category_id.'" title=".icon  .icon-color  .icon-close " class="icon icon-color icon-close" onclick="janelaConfirma('.$vetor[$i]->category_id.');"></span>';
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

		</td>
	</tr>
  </tbody>
  </table>