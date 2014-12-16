<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome","descricao","preco");
	$dados = array($_POST["nome"],$_POST["descricao"],$_POST['preco']);
	$tabela = "produtos_config";
	
	if(isset($_POST['Filename'])){
		$campos[]="foto";
		$dados[]=$_POST['Filename'];		
	}
	
	//buscando a imagem anterior para excluir e o nome do magento
	$sql = "SELECT foto, fotomagento FROM produtos_config WHERE codigo='".$_POST['cod']."'";
	$result = mysql_query($sql);
	list($foto_old,$fotomagento)=mysql_fetch_row($result);
	
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);
	
	// ATUALIZANDO DADOS NO MAGENTO
  	include("../conectarSoap.php");
	
	  //atualizando no magento
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
	  
	  //buscando o codigo sku do produto
	  $sql = "SELECT skumagento FROM produtos_config WHERE codigo='".$_POST['cod']."'";
	  $res = mysql_query($sql);
	  list($sku)=mysql_fetch_row($res);
	  
	  //atualizando produto no magento
	  $result = $client->catalogProductUpdate($session,$sku,$newProductData,$store = null, $identifierType = 'sku');
		
	//EXCLUINDO E GRAVANDO OS ASSOCIADOS
	mysql_query("DELETE FROM produtos_associados WHERE produto='".$_POST['cod']."'");	
	foreach($_POST['sub'] AS $sub){
		//buscando o codigo do produto
	  	$sql = "SELECT codigo FROM produtos WHERE skumagento='$sub'";
		$result = mysql_query($sql);
		list($cod_associado)=mysql_fetch_row($result);
		
		$banco->insere("produtos_associados", array("produto","associado"), array($_POST['cod'],$cod_associado));
	}	
	
	//EXCLUINDO E GRAVANDO OS ATRIBUTOS
	mysql_query("DELETE FROM atributos_associados WHERE produto='".$_POST['cod']."'");	
	foreach($_POST['attr'] AS $attr){
		$banco->insere("atributos_associados", array("produto","atributo"), array($_POST['cod'],$attr));
	}
	
	//UPLOAD DA FOTO
	if(isset($_POST['Filename'])){
		if($foto_old != $_POST['Filename'] && $foto_old)//caso tenha atualizado a foto
		{
			//excluindo a antiga
			unlink("fotos/".$foto_old);
				
			$file = $_FILES['Filedata'];
			$tempFile = $file['tmp_name'];
			$targetPath = 'fotos/';
			$targetFile = $targetPath.$file['name'];
			
			// Uncomment the following line if you want to make the directory if it doesn't exist
			// mkdir(str_replace('//','/',$targetPath), 0755, true);
			
			move_uploaded_file($tempFile,$targetFile);
			
			//enviando a imagem do produto pro magento
			if($foto_old){
				$file = array(
					'name' => $file['name'],
					'content' => base64_encode(file_get_contents($targetFile)),
					'mime' => 'image/jpeg'
				);
				
				$result = $client->catalogProductAttributeMediaUpdate(
					$session,
					$sku,
					$fotomagento,
					array('file' => $file, 'label' => $file['name'], 'position' => '100', 'types' => array('image', 'small_image', 'thumbnail' ), 'exclude' => 0),
					$store = null, 
					$identifierType = 'sku'
				);
			}
			else{
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
				
				$banco->atualiza($tabela, array("fotomagento"), array($result), $_POST['cod']);
			}
		}
	}

	  //ATUALIZANDO NO DATABASE DO MAGENTO A LIGACAO ENTRE SIMPLES E CONFIGURAVEL
	  include('../conectarBDMagento.php');
	  
	  //gravando na tabela catalog_product_super_link e catalog_product_relation
	  if(isset($_POST['sub'])){
	  	  //LIMPANDO AS LIGACOES ANTIGAS
	  	  //buscando o id do produto simples
		  $result = $client->catalogProductInfo($session, $sku,'','','sku');
		  $config_id = $result->product_id; 
	  	  mysql_query("DELETE FROM catalog_product_super_link WHERE parent_id='$config_id'");
		  mysql_query("DELETE FROM catalog_product_relation WHERE parent_id='$config_id'");
		  
		  foreach($_POST['sub'] AS $sub){		  
		  	//buscando o id do produto simples
		  	$result = $client->catalogProductInfo($session, $sub,'','','sku');
			$simples_id = $result->product_id;  
			
		  	$sql = "INSERT INTO catalog_product_super_link(product_id,parent_id) VALUES('$simples_id','$config_id')";
			$result = mysql_query($sql);
			
			$sql = "INSERT INTO catalog_product_relation(parent_id,child_id) VALUES('$config_id','$simples_id')";
			$result = mysql_query($sql);	
		  }
	  }
	  
	  //gravando na tabela catalog_product_super_attribute
	  //LIMPANDO AS LIGACOES ANTIGAS
	  mysql_query("DELETE FROM catalog_product_super_attribute WHERE product_id='$config_id'");
	  if(isset($_POST['attr'])){
		  foreach($_POST['attr'] AS $attr){
		  	$sql = "INSERT INTO catalog_product_super_attribute(product_id,attribute_id,position) VALUES('$config_id','$attr','0')";
			$result = mysql_query($sql);	
		  }
	  }
	
?>