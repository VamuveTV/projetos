
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>SYSTOQUE DO BRAZ</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">SYSTOQUE DO BRAZ</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cadastros <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="index.php?r=vendedor/create">Vendedor</a></li>
                  <li><a href="#">Produto</a></li>                  
                </ul>
              </li>	
              <li><a href="?r=venda/create">Lançamentos</a></li>              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Relatórios <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Extrato de Comissão</a></li>
                  <li><a href="#">Produtos em falta</a></li>
                  <li><a href="#">Estoque Atual</a></li>
                  <li><a href="#">Faturamento</a></li>                  
                </ul>
              </li>
              <li><a href="#">Sobre</a></li> 
            </ul>            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
      
      	<?php echo $content; ?>        

      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>  
    <script type="text/javascript">
    function buscaValor(cb){

		var caminho = '?r=venda/valorproduto&cb='+cb;
		$('#cod_prod').val(cb);
		
		$.post(caminho,{},
				function(dados){
					$('#valor').val(dados);
				}
		);
    }

    function addProd(){
		var nome = $('#nome_prod option:selected').text();
		var cb = $('#cod_prod').val();
		var valor = $('#valor').val();
		var qtd = $('#qtd_prod').val();

		$.post('?r=venda/addproduto',{nome:nome, cb:cb, valor: valor, qtd: qtd},
				function(dados){
					$('#itens').html(dados);
				}
		)
    }

    function finaliza(){
        var data_venda = $('#data_venda').val();
        var previsao_venda = $('#previsao_venda').val();
        var vendedor_venda = $('#vendedor_venda').val();
        var status_venda = $('#status_venda').val();

        $.post('?r=venda/finaliza',{data: data_venda, datapreventrega: previsao_venda, matricula: vendedor_venda, status: status_venda, totalvenda: 0},
                function(dados){
					alert(dados);
        		}
		)
    }
    </script>  
  </body>
</html>
