<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	include("../funcoesSoap.php");
	$banco = new ZarbMysql();

    $_POST['preco'] = str_replace(".", "", $_POST['preco']);
    $_POST['preco'] = str_replace(",", ".", $_POST['preco']);

    // grava o grupo de produtos
    $campos =  array("nome","descricao","preco","custo","foto","frete","lancamento","peso","marca","fotomagento","referencia","imposto");
    $sku = rand(0,1000).date("Ymds"); //sku para o magento
    $dados = array($_POST["nome"],$_POST["descricao"],$_POST["preco"],0,0,0,0,0,$_POST["marca"],0,$sku,0);
    $tabela = "grupo_produtos";

    $banco->insere($tabela, $campos, $dados);
    //buscando o código do grupo de produtos inserido
    $codigo_grupo_produtos = mysql_insert_id();


    // grava o produto
    $campos =  array("grupo","nome","skumagento","cor","tamanho","referencia");
	$dados = array($codigo_grupo_produtos,$_POST["nome"],$sku,$_POST["cor"],$_POST["tamanho"],$sku);
	$tabela = "produtos";
	
	if(isset($_POST['Filename'])){
		$campos[]="foto";
		$dados[]=$_POST['Filename'];	
		
		//UPLOAD DA FOTO	
		$file = $_FILES['Filedata'];
		$tempFile = $file['tmp_name'];
		$targetPath = 'fotos/';
		$targetFile = $targetPath.$file['name'];
				
		move_uploaded_file($tempFile,$targetFile);		
	}

	//verificando se não existe duplicidade do nome
	$sql = "SELECT * FROM $tabela WHERE nome='".$_POST['nome']."' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
		exit("ERRO: Já existe este produto cadastrado");
	else
		 $banco->insere($tabela, $campos, $dados);
	//buscando o código do produto inserido
	$cod_prod = mysql_insert_id();		

	$unidade = $_SESSION['unidade_usu'];
	
	$hoje = date("Y-m-d");
	
	$sql = "INSERT INTO estoque(unidade,produto,quantidade,tipo,centro,unitario_venda,data) 
			VALUES('$unidade','$cod_prod','".$_POST['quantidade']."','E','F','".$_POST['preco']."','$hoje')";
echo $sql;
$result = mysql_query($sql);

?>