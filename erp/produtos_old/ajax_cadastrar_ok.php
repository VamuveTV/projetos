<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome","classificacao","unidade","descricao","skumagento","cor","tamanho","frete","lancamento","peso","marca");
	$sku = rand(0,1000).date("Ymds"); //sku para o magento
	$dados = array($_POST["nome"],$_POST["classificacao"],$_POST["unidade"],$_POST["descricao"],$sku,$_POST["cor"],$_POST["tamanho"],$_POST["frete"],$_POST["lancamento"],$_POST["peso"],$_POST["marca"]);
	$tabela = "produtos";
	echo $banco->insere($tabela, $campos, $dados);

  //BUSNCANDO A CATEGORIA DO MAGENTO 
  $sql = "SELECT idmagento FROM classificacao WHERE codigo='".$_POST["classificacao"]."'";
  $result = mysql_query($sql);
  list($catmagento)=mysql_fetch_row($result);

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
  
  $atributos['color'] = 'Azul'; 

  //informacoes do produto
  $newProductData                     = new stdClass();
  $newProductData->name               = $_POST['nome'];
  $newProductData->description        = $_POST['descricao'];
  $newProductData->short_description  = '';
  $newProductData->websites	          = array(1);
  $newProductData->categories         = array($catmagento);
  $newProductData->status             = 1;
  $newProductData->price              = $_POST['preco'];
  $newProductData->tax_class_id       = 2;
  $newProductData->weight             = $_POST['peso'];
  /* ESTE FUNCIONA
  $newProductData->additional_attributes = array(
    'single_data' => array(
      array('key' => 'color', 'value' => '3')
    )
  );*/
  
  $newProductData->additional_attributes = array(
    'single_data' => array(
      array('key' => 'color', 'value' => $_POST['cor']),
      array('key' => 'frete_gratis', 'value' => $_POST['frete']),
      array('key' => 'lancamento', 'value' => $_POST['lancamento']),
      array('key' => 'tamanho', 'value' => $_POST['tamanho']),
      array('key' => 'manufacturer', 'value' => $_POST['marca'])
    )
  ); 
  /*
  $newProductData->additional_attributes = array(
    'multi_data' => array(
      array('key' => 'color', 'value' => $_POST['cor']),
      array('key' => 'frete_gratis', 'value' => $_POST['frete']),
      array('key' => 'lancamento', 'value' => $_POST['lancamento']),
      array('key' => 'tamanho', 'value' => $_POST['tamanho']),
      array('key' => 'manufacturer', 'value' => $_POST['marca'])
    )
  );
  */
  
  /*
  $newProductData->additional_attributes = array
            (
              array('key' => 'color', 'value' => $_POST['cor']),
              array('key' => 'frete_gratis', 'value' => $_POST['frete']),
              array('key' => 'lancamento', 'value' => $_POST['lancamento']),
              array('key' => 'tamanho', 'value' => $_POST['tamanho']),
              array('key' => 'manufacturer', 'value' => $_POST['marca'])
              
            );*/
  $newProductData->stock_data         = $estoque;
     
  /**
   * Create Product Using V2 API
   */
  
  $result = $client->catalogProductCreate(
      $session,           // Soap Session
      'simple',           // Product Type
      $attributeSet->set_id,                  // Attribute Set Id (Default)
      $sku,                 // Product Sku
      $newProductData     // Product Data
  );

	
?>