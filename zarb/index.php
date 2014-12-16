<?PHP
include("bd.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="stylesheet" type="text/css" href="rotator.css" />
  <title>Zarb Solution - Solu&ccedil;&otilde;es em TI</title>
  <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
  <script type="text/javascript">
$(document).ready(function() {

	//Show Banner
	$(".main_image .desc").show(); //Show Banner
	$(".main_image .block").animate({ opacity: 0.85 }, 1 ); //Set Opacity

	//Click and Hover events for thumbnail list
	$(".image_thumb ul li:first").addClass('active'); 
	$(".image_thumb ul li").click(function(){ 
		//Set Variables
		var imgAlt = $(this).find('img').attr("alt"); //Get Alt Tag of Image
		var imgTitle = $(this).find('a').attr("href"); //Get Main Image URL
		var imgDesc = $(this).find('.block').html(); 	//Get HTML of block
		var imgDescHeight = $(".main_image").find('.block').height();	//Calculate height of block	
		
		if ($(this).is(".active")) {  //If it's already active, then...
			return false; // Don't click through
		} else {
			//Animate the Teaser				
			$(".main_image .block").animate({ opacity: 0, marginBottom: -imgDescHeight }, 250 , function() {
				$(".main_image .block").html(imgDesc).animate({ opacity: 0.85,	marginBottom: "0" }, 250 );
				$(".main_image img").attr({ src: imgTitle , alt: imgAlt});
			});
		}
		
		$(".image_thumb ul li").removeClass('active'); //Remove class of 'active' on all lists
		$(this).addClass('active');  //add class of 'active' on this list only
		return false;
		
	}) .hover(function(){
		$(this).addClass('hover');
		}, function() {
		$(this).removeClass('hover');
	});
			
	//Toggle Teaser
	$("a.collapse").click(function(){
		$(".main_image .block").slideToggle();
		$("a.collapse").toggleClass("show");
	});
	
});//Close Function
</script>
  </head>
  <body>
  <div id="tudo">
    <div id="topo">
      <img src="img/logo.png" id="logo" />
    </div>
    <div id="menu">
      <div id="conteudo_menu">
				<a href="index.php" class="comum">Home</a>
				<a href="cursos.php" class="comum">Cursos</a>
				<a href="servicos.php" class="comum">Servi&ccedil;os</a>
				<a href="produtos.php" class="comum">Produtos</a>
				<a href="portfolio.php" class="comum">Portfolio</a>
                <a href="noticias.php" class="comum">Not&iacute;cias</a>
        <a href="trabalhe.php" class="comum">Trabalhe Conosco</a>
				<a href="contato.php">Contato</a>
			</div>
    </div>
    <div id="rotator">
      <?php
      include("rotator.php");
      include("lib.php");
      ?>
    </div>
    <div id="baixo1">
      <div id="box1">
        <a href='noticias.php'><h1 class="titulo1">Notícias</h1></a>
        <?
          $sql = "SELECT codigo, titulo, data, noticia FROM noticias ORDER BY data DESC LIMIT 0,4 ";
          $res = mysql_query($sql);
            while(list($cod,$titulo,$data,$noticia)=mysql_fetch_row($res)){

              $data = converte_data($data,"usuario");

              echo "<a href='noticias.php?not=$cod'>";
              echo "<div class=\"destaques\" style='color: #1A81E9'>";
              echo "<h2>$titulo</h2>";
              echo "<small>$data</small>";
              echo "</div>";
              echo "</a>";

           }
             echo "<font style='float:right'><a href='noticias.php' style='color:#1a81e9'>Ver todas</a></font><br>";
      ?>
      </div>
      <div id="box2">
        <a href='produtos.php'><h1 class="titulo2">Produtos</h1></a>
        <div class="destaques">
        <h2>ZarbFood</h2> Software para bares, lanchonetes e restaurantes
        </div>
        <div class="destaques">
        <h2>ZarbHotel</h2> Software para pousadas, hotéis e motéis
        </div>
        <div class="destaques">
        <h2>ZarbTur</h2> Software para empresas e profissionais de Turismo
        </div>
        <div class="destaques">
        <h2>ZarbPonto</h2> Software para controle de ponto de funcionários
        </div>
      </div>
      <div id="box3">
        <a href='portfolio.php'><h1 class="titulo3">Portfolio</h1></a>
        <?
          $sql = "SELECT nome, url, descricao FROM portifolio ORDER BY codigo DESC LIMIT 0,4 ";
          $res = mysql_query($sql);
            while(list($nome,$url,$descricao)=mysql_fetch_row($res)){
              echo "<div class='destaques'>";
              echo "<h2><a href='portfolio.php'>$nome</a></h2> <a href='http://$url' target='blank'>$url</a>";
              echo "</div>";
            }
        ?>
      </div>
      <div id="box4">
        <h1 class="titulo4">Encontre-nos</h1>
        <img src="img/ico_orkut.jpg" alt="Orkut" class="icones" />
        <img src="img/ico_twitter.jpg" alt="Twitter" class="icones" />
        <img src="img/ico_facebook.jpg" alt="Facebook" class="icones" />
      </div>
    </div>
  </div>
  <div class='limpa'></div>
  <div id="rodape">
    <div id="conteudo_rodape">
      <div id="rodape1">
        <img src="img/logo_transp2.png" alt="Zarb Solution" />
        <p>
        Zarb Solution Ltda. - Solu&ccedil;&otilde;es em TI<br />
        31 3789-3201 - contato@zarbsolution.com.br<br />
        Av. Francisco Sá, 787 lj. 237 - Prado - Belo Horizonte/MG
        </p>
      </div>
      <div id="rodape2">
        <h2>Navegaçăo</h2>
        <a href="index.php">Home</a><br />
        <a href="cursos.php">Cursos</a><br />
        <a href="servicos.php">Serviços</a><br />
        <a href="produtos.php">Produtos</a><br />
        <a href="portfolio.php">Portfolio</a><br />
        <a href="trabalhe.php">Trabalhe Conosco</a><br />
        <a href="contato.php">Contato</a>
      </div>
      <div id="rodape3">
        <h2>Produtos</h2>                                     
        <a href="produtos.php?prod=zarbfood">ZarbFood</a><br />
        <a href="produtos.php?prod=zarbhotel">ZarbHote</a><br />
        <a href="produtos.php?prod=zarbtur">ZarbTur</a><br />
        <a href="produtos.php?prod=zarbponto">ZarbPonto</a><br />
      </div>
      <div class="limpa"></div>
    </div>
  </div>
  </body>
</html>
