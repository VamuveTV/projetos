<?php
	session_start();
	
	function converte_data($data,$tipo){
	  if($tipo=="usuario")
	    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
	  
	  if($tipo=="banco")
	    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
	  return $data;
	}

    $_POST['venda'] = str_replace(".", "", $_POST['venda']);
    $_POST['venda'] = str_replace(",", ".", $_POST['venda']);

    $_POST['custo'] = str_replace(".", "", $_POST['custo']);
    $_POST['custo'] = str_replace(",", ".", $_POST['custo']);
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	
	$cod_grupo = $_POST['produto'];
	$estoques_magento = array();

    //gravando o estoque
    $hoje = date("Y-m-d");
    foreach($_POST['tamanho'] AS $i => $codT)
    {
        $codC = $_POST['cor'][$i];
        $qtd = $_POST['quantidade'][$i];
        $unidade2 = $_POST['unidade2'][$i];
        if($unidade2 != "")
        {
            $codU = $unidade2;
            $sql = "SELECT codigo FROM produtos WHERE tamanho='$codT' AND grupo='$cod_grupo' AND cor='$codC'";
            $res = mysql_query($sql);
            list($cod_prod)=mysql_fetch_row($res);

            $campos =  array("unidade","produto","centro","quantidade","tipo","unitario","unitario_venda","data");
            $dados = array($codU,$cod_prod,$_POST['centro'],$qtd,'E',$_POST['custo'],$_POST['venda'],$hoje);
            $msg2 = $banco->insere("estoque", $campos, $dados);

            $estoques_magento[$codT][$codC]=$qtd;
        }
        else
        {
            foreach($_POST['unidade'] AS $codU){
                //buscando o codigo do produto

                $sql = "SELECT codigo FROM produtos WHERE tamanho='$codT' AND grupo='$cod_grupo' AND cor='$codC'";
                $res = mysql_query($sql);
                list($cod_prod)=mysql_fetch_row($res);

                $campos =  array("unidade","produto","centro","quantidade","tipo","unitario","unitario_venda","data");
                $dados = array($codU,$cod_prod,$_POST['centro'],$qtd,'E',$_POST['custo'],$_POST['venda'],$hoje);
                $msg2 = $banco->insere("estoque", $campos, $dados);

                $estoques_magento[$codT][$codC]=$qtd;
            }
        }
    }
	
	echo $msg2;
  
?>