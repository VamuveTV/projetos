<?
@header("Content-Type: text/html;charset=ISO-8859-1",true); 
include ("bd.php");

extract($_GET);

$query = "SELECT id, municipio FROM cidades WHERE uf = '$estado'";

echo "<select name='cidades' class='campo'>";
if(isset($estado)){
    $query = "SELECT id, municipio FROM cidades WHERE uf = '$estado'";
    $res=mysql_query($query);
    
   while(list($cod,$cidade)=mysql_fetch_row($res)){
      echo "<option value='$cod'>$cidade</option>";
   } 
echo "</select>";  
}else{
      echo 'Erro no envio dos dados';
}
?>
