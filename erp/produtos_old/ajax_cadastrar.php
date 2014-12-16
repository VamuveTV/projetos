<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	include("../funcoesSoap.php");
	$banco = new ZarbMysql();

	$campos =  array("nome","descricao","skumagento","cor","tamanho","frete","lancamento","peso","referencia","marca","imposto");
	$sku = rand(0,1000).date("Ymds"); //sku para o magento
	$dados = array($_POST["nome"],$_POST["descricao"],$sku,$_POST["cor"],$_POST["tamanho"],$_POST["frete"],$_POST["lancamento"],$_POST["peso"],$_POST["referencia"],$_POST["marca"],$_POST["imposto"]);
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
	$sql = "SELECT * FROM $tabela WHERE nome='".$_POST['nome']."' OR (marca='".$_POST["marca"]."' AND referencia='".$_POST["referencia"]."') ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
		exit("ERRO: Já existe este produto cadastrado");
	else
		echo $banco->insere($tabela, $campos, $dados);
	
	//buscando o código do produto inserido
	$cod_prod = mysql_insert_id();

	//GRAVANDO AS CATEGORIAS	
	foreach($_POST['categorias'] AS $codCategoria){
		$banco->insere("categorias_produtos", array("categoria","produto"), array($codCategoria,$cod_prod));
	}
	
	//GRAVANDO AS UNIDADES	
	foreach($_POST['unidade'] AS $codUnidade){
		$banco->insere("unidades_produtos", array("unidade","produto"), array($codUnidade,$cod_prod));
		
		//VERIFICANDO SE A UNIDADE UTILIZA MAGENTO PARA CADASTRAR O PRODUTO NA LOJA
		$sql = "SELECT magento,url,usuario_soap,senha_soap,servidor_bd,usuario_bd,senha_bd FROM unidades WHERE codigo='$codUnidade'";
		$result = mysql_query($sql);
		list($magento,$url,$usuario_soap,$senha_soap,$servidor_bd,$usuario_bd,$senha_bd)=mysql_fetch_row($result);
		
		if($magento=='S'){		
		  //include("../conectarSoap.php");		  
		  conectarSoap($url, $usuario_soap, $senha_soap);
		  
		  // get attribute set
		  $attributeSets = $client->catalogProductAttributeSetList($session);
		  $attributeSet = current($attributeSets);
		
		  //informacoes de estoque do produto
		  $estoque                     = new stdClass();
		  $estoque->qty                = 0;
		  $estoque->is_in_stock        = 1;
		  $estoque->manage_stock       = 1;
		  $estoque->use_config_manage_stock= 1; 
		  		  
		  //informacoes do produto
		  $newProductData                     = new stdClass();
		  $newProductData->name               = $_POST['nome'];
		  $newProductData->description        = $_POST['descricao'];
		  $newProductData->short_description  = '';
		  $newProductData->websites	          = array(1);
		  //$newProductData->categories         = array($catmagento);
		  $newProductData->categories         = $_POST['categorias'];
		  $newProductData->status             = 1;
		  $newProductData->tax_class_id       = 2;
		  $newProductData->weight             = $_POST['peso'];
		  
		  $newProductData->additional_attributes = array(
		    'single_data' => array(
		      array('key' => 'color', 'value' => $_POST['cor']),
		      array('key' => 'frete_gratis', 'value' => $_POST['frete']),
		      array('key' => 'lancamento', 'value' => $_POST['lancamento']),
		      array('key' => 'tamanho', 'value' => $_POST['tamanho']),
		      array('key' => 'manufacturer', 'value' => $_POST['marca'])
		    )
		  ); 
		  
		  $newProductData->stock_data         = $estoque;
		     
		  //criando o produto
		  $result = $client->catalogProductCreate(
		      $session,           // Soap Session
		      'simple',           // Product Type
		      $attributeSet->set_id,                  // Attribute Set Id (Default)
		      $sku,                 // Product Sku
		      $newProductData     // Product Data
		  );
		  
		  if(isset($_POST['Filename'])){
			  //enviando a imagem do produto  
				$file = array(
					'name' => $file['name'],
					'content' => base64_encode(file_get_contents($targetFile)),
					'mime' => 'image/jpeg'
				);
			  
				
				$result = $client->catalogProductAttributeMediaCreate(
					$session,
					$sku,
					array('file' => $file, 'label' => $file['name'], 'position' => '100', 'types' => array('image', 'small_image', 'thumbnail' ), 'exclude' => 0),
					$store = null, 
					$identifierType = 'sku'
				);
				
				$banco->atualiza($tabela, array("fotomagento"), array($result), $cod_prod);
		  }
		}
	}	
?>