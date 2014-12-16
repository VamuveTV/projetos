<?
@header("Content-Type: text/html;charset=ISO-8859-1",true); 
include ("../bd.php");

echo "<option value=''>Todas cidades</option>";
if (isset($_POST['estado'])){
    $query = 'SELECT id,municipio FROM cidades WHERE uf = \''.$_POST['estado'].'\'';
    $res=mysql_query($query);
   
   while(list($cod,$cidade)=mysql_fetch_row($res)){
      echo "<option value='$cod'>$cidade</option>";
   } 
  
}else{
      echo 'Erro no envio dos dados';
}
?>
