<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();


$teste = array();

$sql = "SELECT p.codigo, p.nome, gp.foto, p.referencia, gp.descricao FROM produtos AS p, grupo_produtos AS gp WHERE p.grupo=gp.codigo AND p.codigo=".$_POST["cod"]." order by p.nome";
$result = mysql_query($sql);

while(list($codP,$nomeP,$fotoP,$referenciaP,$descricaoP)=mysql_fetch_row($result))
{
    $descricaoP = substr($descricaoP, 0, 200)."...";
    $sql2 = "SELECT AVG(unitario_venda) FROM estoque WHERE produto='$codP'";
    $result2 = mysql_query($sql2);
    list($preco)=mysql_fetch_row($result2);
    $precoP = number_format($preco,2,",",".");

    //$teste[] = array("id"=>$codP,"text"=> $nomeP ."-". $referenciaP ." - R$ ".$precoP);
    $id = $codP;
    $text = $nomeP ."-". $referenciaP ." - R$ ".$precoP;
}
echo $id."#". $text;



?>