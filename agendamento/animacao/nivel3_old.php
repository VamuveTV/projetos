<?php
header("Content-type: text/html; charset=utf-8");

include('bd.php');

$user = 'tiny';
$pwd = '!@#$q1w2e3r4';
$url = 'http://acdigital.com.br/index.php/api/soap/?wsdl';

try {
	$client = new SoapClient( $url );
} catch( Exception $e ) {
	$retorno['erros'][] = array(
		'codigo' => '4',
		'mensagem' => 'Falha no webservice: ' . $e->getMessage()
	);
}       

try {
	$session = $client->login( $user, $pwd );
} catch( Exception $e ) {
	$retorno['erros'][] = array(
		'codigo' => '3',
		'mensagem' => 'Falha na autenticacao: ' . $e->getMessage()
	);
}

$categoria = $_POST['categoria'];
$sql = "SELECT sku FROM produto WHERE idcategoria='$categoria'";
$res = mysql_query($sql);

//$result = $client->call($session, 'catalog_product.info','0031','','','SKU');

while(list($sku)=mysql_fetch_row($res)){
  $result = $client->call($session, 'catalog_product.info',$sku,'','','SKU');
  $nome = $result['name'];
  $preco = number_format($result['price'],2,",",".");
  $url = 'http://acdigital.com.br/'.$result['url_path'];
  
  $result2 = $client->call($session, 'catalog_product_attribute_media.list', $sku,'','SKU');
  $foto = $result2[0]['url'];
  
  echo "<div class=\"produto\">
                    <p>
                    <img src='$foto' width='64'>
                    </p>
                    <h3>$nome</h3>
                    <h3>R$ $preco</h3>
                    <br>
                    <a href=\"$url?options=cart\" class=\"botao\">COMPRAR</a>
                    </p>
                  </div>";
}