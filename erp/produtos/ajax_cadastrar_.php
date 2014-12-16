<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	include("../funcoesSoap.php");
	$banco = new ZarbMysql();
		
	//dados necessarios para o MAGMI
	require_once("../magmi/inc/magmi_defs.php");
	require_once("../magmi/integration/inc/magmi_datapump.php");
	
	// create a Product import Datapump using Magmi_DatapumpFactory
	$dp=Magmi_DataPumpFactory::getDataPumpInstance("productimport");
	$dp->beginImportSession("default","create");


	$_POST['valor'] = str_replace(".", "", $_POST['valor']);
	$_POST['valor'] = str_replace(",", ".", $_POST['valor']);

	//gravando primeiro o grupo de produtos
	$campos =  array("nome","descricao","frete","lancamento","peso","referencia","marca","imposto","preco");
	$dados = array($_POST["nome"],$_POST["descricao"],$_POST["frete"],$_POST["lancamento"],$_POST["peso"],$_POST["referencia"],$_POST["marca"],$_POST["imposto"],$_POST["valor"]);
	$tabela = "grupo_produtos";

	/*	
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
	 */
	 
	//buscando o nome da marca
	$sql2 = "SELECT nome FROM marca WHERE codigo='".$_POST['marca']."'";
    $res2 = mysql_query($sql2);
    list($nome_marca)=mysql_fetch_row($res2);
	
	//verificando se não existe duplicidade do nome
	$sql = "SELECT * FROM $tabela WHERE nome='".$_POST['nome']."' OR (marca='".$_POST["marca"]."' AND referencia='".$_POST["referencia"]."') ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
		exit("ERRO: Já existe este produto cadastrado");
	else
		$msg = $banco->insere($tabela, $campos, $dados);
		
	$cod_grupo = mysql_insert_id();
	$nome_grupo = $_POST['nome'];
	$peso_grupo = $_POST["peso"];
	$referencia_grupo = $_POST['referencia'];
	
	  //gravando o produto configuravel no magento
	  // INSERINDO DADOS NO MAGENTO
	  include("../conectarSoap.php");
	  
	  // get attribute set
	  $sku = rand(0,1000).date("Ymds"); //sku para o magento
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
	  $newProductData->name               = $_POST['nome'].' - '.$_POST["referencia"];
	  $newProductData->description        = $_POST['descricao'];
	  $newProductData->short_description  = $_POST['descricao'];  
	  $newProductData->price        	  = $_POST['valor'];
	  $newProductData->short_description  = '';
	  $newProductData->websites	          = array(1);
	  $newProductData->status             = 1;
	  $newProductData->tax_class_id       = 2;
	     
	  //criando o produto
	  $result = $client->catalogProductCreate(
	      $session,           		// Soap Session
		  'configurable',           // Product Type
		  $attributeSet->set_id,    // Attribute Set Id (Default)
		  $sku,                 	// Product Sku
		  $newProductData     		// Product Data
	  );	  
	  $config_id = $result;
	  //fim do cadastro do produto configuravel
	
	//inserindo todas possibilidades de produtos
	$nomes_magento = $skus_magento = $cores_magento = $tamanhos_magento = $pesos_magento = $estoques_magento = array();
	
	/*
	$sql = "SELECT codigo, nome FROM tamanhos ";
	$res = mysql_query($sql);
	while(list($codT,$nomeT)=mysql_fetch_row($res)){
		$sql2 = "SELECT codigo, nome FROM cores ";
		$res2 = mysql_query($sql2);
		while(list($codC,$nomeC)=mysql_fetch_row($res2)){
			$nome_prod = "$nome_grupo - $referencia_grupo - $nomeC - $nomeT";
			$sku = rand(0,1000).date("Ymds"); //sku para o magento
			$campos =  array("grupo","nome","skumagento","cor","tamanho","peso","referencia");
			$dados = array($cod_grupo,$nome_prod,$sku,$codC,$codT,$peso_grupo,$referencia_grupo);
			$banco->insere("produtos", $campos, $dados);
						
			//guardando dados em array para inserir no magento se a unidade utilizar MAGENTO = S
			$nomes_magento[] = $nome_prod;
			$skus_magento[] = $sku;
			$cores_magento[] = $codC;
			$tamanhos_magento[] = $codT;
			$pesos_magento[] = $peso_grupo;  
		}
	}
	*/
	
	//gravando o estoque
	$hoje = date("Y-m-d");
	$skus_sub = array();	
	foreach($_POST['tamanho'] AS $i => $codT){
		$codC = $_POST['cor'][$i];
		$qtd = $_POST['quantidade'][$i];
        $unidade2 = $_POST['unidade2'][$i];
		
		$sql2 = "SELECT nome FROM cores WHERE codigo='$codC'";
        $res2 = mysql_query($sql2);
        list($nomeC)=mysql_fetch_row($res2);

        $sql3 = "SELECT nome FROM tamanhos WHERE codigo='$codT'";
        $res3 = mysql_query($sql3);
        list($nomeT)=mysql_fetch_row($res3);
		
		//inserindo a possibilidade e guardando os dados para gravar no magento posteriormente - BRAZ 29/10/2013
		$nome_prod = "$nome_grupo - $referencia_grupo - $nomeC - $nomeT";
		
		$sku = rand(0,1000).date("Ymds"); //sku para o magento
		$campos =  array("grupo","nome","skumagento","cor","tamanho","peso","referencia");
		$dados = array($cod_grupo,$nome_prod,$sku,$codC,$codT,$peso_grupo,$referencia_grupo);
		$banco->insere("produtos", $campos, $dados);
		$cod_prod = mysql_insert_id();
					
		//guardando dados em array para inserir no magento se a unidade utilizar MAGENTO = S
		$nomes_magento[] = $nome_prod;
		$skus_magento[] = $sku;
		$cores_magento[] = $codC;
		$tamanhos_magento[] = $codT;
		$pesos_magento[] = $peso_grupo; 
		$skus_sub[] = $sku; //guardando o sku do subproduto para fazer a integracao configuravel->subproduto
		
		//FIM ALTERACAO BRAZ 29/10/2013				
        if($unidade2 != "")
        {
            $codU = $unidade2;

            $campos =  array("unidade","produto","quantidade","tipo","unitario_venda","data");
            $dados = array($codU,$cod_prod,$qtd,'E',$_POST['valor'],$hoje);
            $msg2 = $banco->insere("estoque", $campos, $dados);

            $estoques_magento[$codT][$codC]=$qtd;			
        }
        else
        {
            foreach($_POST['unidade'] AS $codU){

                $campos =  array("unidade","produto","quantidade","tipo","unitario_venda","data");
                $dados = array($codU,$cod_prod,$qtd,'E',$_POST['valor'],$hoje);
                $msg2 = $banco->insere("estoque", $campos, $dados);

                $estoques_magento[$codT][$codC]=$qtd;
            }
		}	
		
	}
		
	 //buscando o código do produto inserido
	//$cod_prod = mysql_insert_id(); //CODIGO ANTIGO ANTES DO CADASTRO COM GRUPO E GRADE
	$cod_prod = $cod_grupo;
	  
	//GRAVANDO AS CATEGORIAS	
	foreach($_POST['categorias'] AS $codCategoria){
		$banco->insere("categorias_produtos", array("categoria","produto"), array($codCategoria,$cod_grupo));
	}	
	 
	//GRAVANDO AS UNIDADES	
	foreach($_POST['unidade'] AS $codUnidade){
		$banco->insere("unidades_produtos", array("unidade","produto"), array($codUnidade,$cod_prod));


        //VERIFICANDO SE A UNIDADE UTILIZA MAGENTO PARA CADASTRAR O PRODUTO NA LOJA
        $sql = "SELECT magento,url,usuario_soap,senha_soap,servidor_bd,usuario_bd,senha_bd,bd FROM unidades WHERE codigo='$codUnidade'";
        $result = mysql_query($sql);
        list($magento,$url,$usuario_soap,$senha_soap,$servidor_bd,$usuario_bd,$senha_bd,$nome_bd)=mysql_fetch_row($result);


        if($magento=='S'){

            foreach($nomes_magento  AS $i => $nomeMagento){
            	
                $sql2 = "SELECT nome FROM cores WHERE codigo='".$cores_magento[$i]."'";
                $res2 = mysql_query($sql2);
                list($nome_cor)=mysql_fetch_row($res2);

                $sql3 = "SELECT nome FROM tamanhos WHERE codigo='".$tamanhos_magento[$i]."'";
                $res3 = mysql_query($sql3);
                list($nome_tamanho)=mysql_fetch_row($res3);

				// TESTE SEM MAGMI - MAGMI NAO FUNCIONOU EM 01/11
				//informacoes de estoque do produto
				  $t = $tamanhos_magento[$i];
                  $c = $cores_magento[$i];
				  
				  if(isset($estoques_magento[$t][$c]))
                    $quantidade = $estoques_magento[$t][$c];
				  else
					$quantidade = 0;
				  
				  $estoque                     = new stdClass();
				  $estoque->qty                = $quantidade;
				  $estoque->is_in_stock        = 1;
				  $estoque->manage_stock       = 1;
				  $estoque->use_config_manage_stock= 1; 
				  		  
				  //informacoes do produto
				  $newProductData                     = new stdClass();
				  $newProductData->name               = $nomeMagento;
				  $newProductData->description        = $_POST['descricao'];
				  $newProductData->short_description  = '';
				  $newProductData->websites	          = array(1);
				  //$newProductData->categories         = array($catmagento);
				  $newProductData->categories         = $codCategoria;
				  $newProductData->status             = 1;
				  $newProductData->tax_class_id       = 2;
				  $newProductData->weight             = $pesos_magento[$i];
				  
				  $newProductData->additional_attributes = array(
				    'single_data' => array(
				      array('key' => 'color', 'value' => $cores_magento[$i]),
				      array('key' => 'frete_gratis', 'value' => $_POST['frete']),
				      array('key' => 'lancamento', 'value' => $_POST['lancamento']),
				      array('key' => 'tamanho', 'value' => $tamanhos_magento[$i]),
				      array('key' => 'manufacturer', 'value' => $_POST['marca'])
				    )
				  ); 
				  
				  $newProductData->stock_data         = $estoque;
				     
				  //criando o produto
				  $result = $client->catalogProductCreate(
				      $session,           // Soap Session
				      'simple',           // Product Type
				      $attributeSet->set_id,                  // Attribute Set Id (Default)
				      $skus_magento[$i],                 // Product Sku
				      $newProductData     // Product Data
				  );
				
				//CRIAR PRODUTO COM MAGMI
				/*
                // Here we define a single "simple" item, with name, sku,price,attribute_set,store,description
                $item=array("name"=>$nomeMagento,
                                "sku"=>$skus_magento[$i],
                                "price"=>$_POST['valor'],
                                "attribute_set"=>"Default",
                                "store"=>"admin",
                                "description"=>$_POST["descricao"],
                                "color"=>$nome_cor,
                                "frete_gratis"=>$_POST['frete'],
                                "lancamento"=>$_POST['lancamento'],
                                "tamanho"=>$nome_tamanho,
                                "manufacturer"=>$nome_marca);

                //verificando se houve entrada de estoque para este produto de acordo com o TAMANHO e COR
                $t = $tamanhos_magento[$i];
                $c = $cores_magento[$i];
                if(isset($estoques_magento[$t][$c]))
                    $item['qty'] = $estoques_magento[$t][$c];

                // Now ingest item into magento
                $dp->ingest($item);
				 */

            }

            // End import Session
            //$dp->endImportSession();
            //FIM DO NOVO CODIGO (INSERIR DIRETO NO BANCO DO MAGENTO)
        }

	}	

	echo $msg;
	
	include("../conectarBDMagento.php");
	
	foreach($skus_sub AS $sub){
		//buscando o id do produto simples
	  	$result = $client->catalogProductInfo($session, $sub,'','','sku');
		$simples_id = $result->product_id;  
		
	  	$sql = "INSERT INTO catalog_product_super_link(product_id,parent_id) VALUES('$simples_id','$config_id')";
		$result = mysql_query($sql);
		
		$sql = "INSERT INTO catalog_product_relation(parent_id,child_id) VALUES('$config_id','$simples_id')";
		$result = mysql_query($sql);
	}
?>