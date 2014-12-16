<?php
include("../classes/zarbmysql.php");
include("../conectar.php");
$banco = new ZarbMysql();

$limite = intval($_GET['page_limit']);
$pagina = intval($_GET['page']);
$inicio = ($pagina - 1) * $limite;
$teste = array();


//mesma query so para pegar a quantidade total
$sql2 = "SELECT gp.codigo, gp.nome, gp.foto, gp.referencia, gp.descricao FROM grupo_produtos AS gp WHERE gp.nome LIKE '%".$_GET["q"]."%' order by gp.nome";
$result2 = mysql_query($sql2);
$cont = mysql_num_rows($result2);

if($cont > 0)
    $teste[] = array('total'=>$cont);

$keyword = explode(" ",$_GET["q"]);
$ct = 0;
while(list($key,$val)=each($keyword))
{
    $ct++;
    if($val != " " and strlen($val) > 0)
    {
        $q2 .= " gp.nome like '%$val%' ";
        if($ct <  count($keyword))
            $q2.= " or ";
    }
}

$sql = "SELECT gp.codigo, gp.nome, gp.foto, gp.referencia, gp.descricao FROM grupo_produtos AS gp WHERE ($q2) order by gp.nome LIMIT $inicio, $limite";
$result = mysql_query($sql);

while(list($codP,$nomeP,$fotoP,$referenciaP,$descricaoP)=mysql_fetch_row($result))
{
    $descricaoP = substr($descricaoP, 0, 200)."...";
    $descricaoP = strip_tags($descricaoP);

    $teste[] = array("id"=>$codP,"foto"=>$fotoP,"comentario"=>$descricaoP,"text"=> $nomeP ."-". $referenciaP);
}
echo json_encode($teste);



?>