<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome","descricao","preco","skumagento");
	$sku = rand(0,1000).date("Ymds"); //sku para o magento
	$dados = array($_POST["nome"],$_POST["descricao"],$_POST['preco'],$sku);
	$tabela = "produtos_config";
	
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

	echo $banco->insere($tabela, $campos, $dados);
	//buscando o código do produto inserido
	$cod_prod = mysql_insert_id();

  // INSERINDO DADOS NO MAGENTO
  include("../conectarSoap.php");
  
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
  $newProductData->short_description  = $_POST['descricao'];  
  $newProductData->price        	  = $_POST['preco'];
  $newProductData->short_description  = '';
  $newProductData->websites	          = array(1);
  $newProductData->status             = 1;
  $newProductData->tax_class_id       = 2;
  
  //$newProductData->stock_data         = $estoque;
     
  //criando o produto
  $result = $client->catalogProductCreate(
      $session,           		// Soap Session
      'configurable',           // Product Type
      $attributeSet->set_id,    // Attribute Set Id (Default)
      $sku,                 	// Product Sku
      $newProductData     		// Product Data
  );
  
  $config_id = $result;
  
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
  
  //gravando os produtos associados
  if(isset($_POST['sub'])){
	  foreach($_POST['sub'] AS $sub){
	  	//buscando o codigo do produto
	  	$sql = "SELECT codigo FROM produtos WHERE skumagento='$sub'";
		$result = mysql_query($sql);
		list($cod_associado)=mysql_fetch_row($result);
		
	  	$sql = "INSERT INTO produtos_associados(produto,associado) VALUES ('$cod_prod','$cod_associado')";
		$result = mysql_query($sql);	  	
	  }
  }
  
  //gravando os atributos do produto
  if(isset($_POST['attr'])){
	  foreach($_POST['attr'] AS $attr){
	  	$sql = "INSERT INTO atributos_associados(produto,atributo) VALUES ('$cod_prod','$attr')";
		$result = mysql_query($sql);
	  }
  }
  
  //INSERINDO NO DATABASE DO MAGENTO A LIGACAO ENTRE SIMPLES E CONFIGURAVEL
  include('../conectarBDMagento.php');
  
  //gravando na tabela catalog_product_super_link e catalog_product_relation
  if(isset($_POST['sub'])){
	  foreach($_POST['sub'] AS $sub){
	  	//buscando o id do produto simples
	  	$result = $client->catalogProductInfo($session, $sub,'','','sku');
		$simples_id = $result->product_id;  
		
	  	$sql = "INSERT INTO catalog_product_super_link(product_id,parent_id) VALUES('$simples_id','$config_id')";
		$result = mysql_query($sql);
		echo $sql;
		
		$sql = "INSERT INTO catalog_product_relation(parent_id,child_id) VALUES('$config_id','$simples_id')";
		$result = mysql_query($sql);
		echo $sql;	
	  }
  }
  
  //gravando na tabela catalog_product_super_attribute
  if(isset($_POST['attr'])){
	  foreach($_POST['attr'] AS $attr){
	  	$sql = "INSERT INTO catalog_product_super_attribute(product_id,attribute_id,position) VALUES('$config_id','$attr','0')";
		$result = mysql_query($sql);	
		echo $sql;
	  }
  }

	
?>