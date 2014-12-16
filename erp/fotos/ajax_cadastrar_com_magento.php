<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	include("../conectarSoap.php");
	
	function converte_data($data,$tipo){
	  if($tipo=="usuario")
	    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
	  
	  if($tipo=="banco")
	    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
	  return $data;
	}
	
	$banco = new ZarbMysql();
		
	//limpando a foto anterior para estar e produto
	mysql_query("DELETE FROM fotos WHERE produto='".$_POST['produto']."' AND cor='".$_POST['cor']."'");
	
	//inserindo a nova foto
	$sql = "INSERT INTO fotos(produto,cor,foto) VALUES('".$_POST['produto']."','".$_POST['cor']."','".$_POST['Filename']."')";
	$res = mysql_query($sql);
	
	//buscando o primeiro produto do grupo para ser o modelo e cadastrar a foto no magento, os demais sera feito apenas mudancas no banco logo abaixo
	$sql = "SELECT codigo, nome, skumagento, foto, fotomagento FROM produtos WHERE grupo='".$_POST['produto']."' AND cor='".$_POST['cor']."' ";
	$res = mysql_query($sql);
	
	$ct = 1;
	$skus_magento = array();
	while(list($codP,$nomeP,$skuP,$fotoP,$fotomagentoP)=mysql_fetch_row($res)){
		//fazendo update na base local
		$sql2 = "UPDATE produtos SET foto='".$_POST['Filename']."' WHERE codigo='$codP' ";
		$res2 = mysql_query($sql2);
				
		if($ct == 1){ // E O PRIMEIRO FAZ A OPERACAO ATRAVES DA API DO MANGENTO, OS DEMAIS SOMENTE ARMAZENA O CODIGO SKU		
			//atualizando produto no magento
			$file 		= $_FILES['Filedata'];
			$tempFile 	= $file['tmp_name'];
			$targetPath = 'fotos/';
			$targetFile = $targetPath.$file['name'];
			
			move_uploaded_file($tempFile,$targetFile);
			
			if($fotoP != ''){	 //ja existe (fazer update)
				//enviando a imagem do produto  
				$file = array(
					'name' => $file['name'],
					'content' => base64_encode(file_get_contents($targetFile)),
					'mime' => 'image/jpeg'
				);
				
				$result = $client->catalogProductAttributeMediaUpdate(
					$session,
					$skuP,
					$fotomagentoP,
					array('file' => $file, 'label' => $file['name'], 'position' => '100', 'types' => array('image', 'small_image', 'thumbnail' ), 'exclude' => 0),
					$store = null, 
					$identifierType = 'sku'
				);
				/* NAO E NECESSARIO ATUALIZAR O CAMPO fotomagento POIS AO EDITAR O MAGENTO NAO MODIFICA O NOME DA FOTO */
				/*
				//buscando o caminho da imagem no magento
				$result2 = $client->catalogProductAttributeMediaList($session, $skuP,'','sku');
				$foto_magento = $result2[0]->file;
				
				$banco->atualiza("produtos", array("fotomagento"), array($foto_magento), $codP);
				 * 
				 */
				 $fotomagentoP_ok = $fotomagentoP;
			}
			else{
				//nao existe (cadastrar a imagem)
				//enviando a imagem do produto  
				$file = array(
					'name' => $file['name'],
					'content' => base64_encode(file_get_contents($targetFile)),
					'mime' => 'image/jpeg'
				);
				
				$result = $client->catalogProductAttributeMediaCreate(
					$session,
					$skuP,
					array('file' => $file, 'label' => $file['name'], 'position' => '100', 'types' => array('image', 'small_image', 'thumbnail' ), 'exclude' => 0),
					$store = null, 
					$identifierType = 'sku'
				);
				
				$banco->atualiza("produtos", array("fotomagento"), array($result), $codP);
				$fotomagentoP_ok = $result;
				
			}
		}
		else { //NAO E O PRIMEIRO APENAS ARMAZENA O CODIGO SKU PARA SER USADO POSTERIORMENTE
			$skus_magento[] = $skuP; 
			$banco->atualiza("produtos", array("fotomagento"), array($fotomagentoP_ok), $codP);			
		}
		$ct++;
	}	

	//APOS CADASTRAR O PRIMEIRO DE MODELO CADASTRAR A MESMA IMAGEM PARA OS OUTROS PRODUTOS DIRETO NO BANCO DO MAGENTO
	include("../conectarBDMagento.php");
	
	//buscando os codigos de (media_gallery, image, small_image, thumbnail)
	$sql = "SELECT attribute_id FROM eav_attribute WHERE attribute_code='media_gallery'";
	$res = mysql_query($sql);
	list($media)=mysql_fetch_row($res);
	
	$sql = "SELECT attribute_id FROM eav_attribute WHERE attribute_code='image'";
	$res = mysql_query($sql);
	list($image)=mysql_fetch_row($res);
	
	$sql = "SELECT attribute_id FROM eav_attribute WHERE attribute_code='small_image'";
	$res = mysql_query($sql);
	list($small)=mysql_fetch_row($res);
	
	$sql = "SELECT attribute_id FROM eav_attribute WHERE attribute_code='thumbnail'";
	$res = mysql_query($sql);
	list($thumb)=mysql_fetch_row($res);
	
	//FAZER OS CADASTROS PARA CADA PRODUTO DO GRUPO E COR
	foreach ($skus_magento as $sku_prod) {
		//buscando o entity_id do produto
		$sql = "SELECT entity_id FROM catalog_product_entity WHERE sku='$sku_prod'";
		$res = mysql_query($sql);
		list($entity_id)=mysql_fetch_row($res);
		
		//cadastrando em catalog_product_entity_media_gallery o codigo de media_gallery e da entidade
		$sql = "INSERT INTO catalog_product_entity_media_gallery(attribute_id,entity_id,value)
				VALUES('$media','$entity_id','$fotomagentoP_ok')";
		$res = mysql_query($sql);
		
		//cadastrando em catalog_product_entity_varchar um registro para cada um dos 3 atributos (image, small_image, thumbnail ) 
		//com entity_type_id=4 e store_id=0
		$sql = "INSERT INTO catalog_product_entity_varchar(entity_type_id,attribute_id,entity_id,value) 
				VALUES (4, $image, $entity_id, '$fotomagentoP_ok')";
		$res = mysql_query($sql);
		
		$sql = "INSERT INTO catalog_product_entity_varchar(entity_type_id,attribute_id,entity_id,value) 
				VALUES (4, $small, $entity_id, '$fotomagentoP_ok')";
		$res = mysql_query($sql);
		
		$sql = "INSERT INTO catalog_product_entity_varchar(entity_type_id,attribute_id,entity_id,value) 
				VALUES (4, $thumb, $entity_id, '$fotomagentoP_ok')";
		$res = mysql_query($sql);	
	}

	
?>