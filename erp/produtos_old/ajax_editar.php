<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	include("../funcoesSoap.php");
	$banco = new ZarbMysql();
	
	$campos =  array("nome","descricao","cor","tamanho","frete","lancamento","peso","referencia","marca","imposto");
	$dados = array($_POST["nome"],$_POST["descricao"],$_POST["cor"],$_POST["tamanho"],$_POST["frete"],$_POST["lancamento"],$_POST["peso"],$_POST["referencia"],$_POST["marca"],$_POST["imposto"]);
	$tabela = "produtos";
	
	// ATUALIZANDO DADOS NO MAGENTO
    include("../conectarSoap.php");
  
	if(isset($_POST['Filename'])){
		$campos[]="foto";
		$dados[]=$_POST['Filename'];
	}	
	
	//buscando a imagem anterior para excluir e o nome do magento
	$sql = "SELECT foto, fotomagento FROM produtos WHERE codigo='".$_POST['cod']."'";
	$result = mysql_query($sql);
	list($foto_old,$fotomagento)=mysql_fetch_row($result);
	
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);
	
	//EXCLUINDO E GRAVANDO AS CATEGORIAS
	mysql_query("DELETE FROM categorias_produtos WHERE produto='".$_POST['cod']."'");	
	foreach($_POST['categorias'] AS $codCategoria){
		$banco->insere("categorias_produtos", array("categoria","produto"), array($codCategoria,$_POST['cod']));
	}
	
	//EXCLUINDO E GRAVANDO AS CATEGORIAS
	mysql_query("DELETE FROM unidades_produtos WHERE produto='".$_POST['cod']."'");
	foreach($_POST['unidade'] AS $codUnidade){
		$banco->insere("unidades_produtos", array("unidade","produto"), array($codUnidade,$_POST['cod']));
		
		//VERIFICANDO SE A UNIDADE UTILIZA MAGENTO PARA CADASTRAR O PRODUTO NA LOJA
		$sql = "SELECT magento,url,usuario_soap,senha_soap,servidor_bd,usuario_bd,senha_bd FROM unidades WHERE codigo='$codUnidade'";
		$result = mysql_query($sql);
		list($magento,$url,$usuario_soap,$senha_soap,$servidor_bd,$usuario_bd,$senha_bd)=mysql_fetch_row($result);
		
		if($magento=='S'){		
		  //include("../conectarSoap.php");		  
		  conectarSoap($url, $usuario_soap, $senha_soap);
		
		
		  //atualizando no magento
		  $newProductData                     = new stdClass();
		  $newProductData->name               = $_POST['nome'];
		  $newProductData->description        = $_POST['descricao'];
		  $newProductData->short_description  = '';
		  $newProductData->websites	          = array(1);
		  $newProductData->categories         = $_POST['categorias'];
		  $newProductData->status             = 1;  
		  $newProductData->tax_class_id       = 2;
		  $newProductData->weight             = 1;
		  
		  $newProductData->additional_attributes = array(
		    'single_data' => array(
		      array('key' => 'color', 'value' => $_POST['cor']),
		      array('key' => 'frete_gratis', 'value' => $_POST['frete']),
		      array('key' => 'lancamento', 'value' => $_POST['lancamento']),
		      array('key' => 'tamanho', 'value' => $_POST['tamanho']),
		      array('key' => 'manufacturer', 'value' => $_POST['marca'])
		    )
		  ); 
		  
		  //buscando o codigo sku do produto
		  $sql = "SELECT skumagento FROM produtos WHERE codigo='".$_POST['cod']."'";
		  $res = mysql_query($sql);
		  list($sku)=mysql_fetch_row($res);
		  
		  //atualizando produto no magento
		  $result = $client->catalogProductUpdate($session, $sku,$newProductData,$store = null, $identifierType = 'sku');
		  
		  if(isset($_POST['Filename'])){				
					if($foto_old != $_POST['Filename'] && $foto_old)//caso tenha atualizado a foto
						unlink("fotos/".$foto_old);	
				
					//UPLOAD DA FOTO
					$file = $_FILES['Filedata'];
					$tempFile = $file['tmp_name'];
					$targetPath = 'fotos/';
					$targetFile = $targetPath.$file['name'];
					
					move_uploaded_file($tempFile,$targetFile);		
				
					if($foto_old)
					{
						//enviando a imagem do produto  
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
						
						$banco->atualiza($tabela, array("fotomagento"), array($result), $_POST['cod']);
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
	}
?>