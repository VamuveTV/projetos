<?php
session_start();
if((!$_SESSION['login_usu']) or ($_SESSION['perfil'] != 1))
    header("location: ../index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>	<meta charset="utf-8">
	<title>ERP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
	<meta name="author" content="Muhammad Usman">

	<!-- The styles -->
	<link id="bs-css" href="../css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	  .loader{
		display: none;
		background: #000;
		position:fixed;
		left:0px; 
		top:0px; 
		width:100%; 
		height:100%; 
		text-align:center;
		color:#fff;
		border: 0;
		opacity:0.65;
		-moz-opacity: 0.65;
		filter: alpha(opacity=65);
		}
		.loader div{
			width:400px;
			margin: 250px auto;
			height: 40px;
			text-align:center;
			
			overflow:hidden;
		}
	</style>
	<link href="fileupload.css" rel="stylesheet">
	<link href="../css/bootstrap-responsive.css" rel="stylesheet">
	<link href="../css/charisma-app.css" rel="stylesheet">
	<link href="../css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='../css/fullcalendar.css' rel='stylesheet'>
	<link href='../css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='../css/chosen.css' rel='stylesheet'>
	<link href='../css/uniform.default.css' rel='stylesheet'>
	<link href='../css/colorbox.css' rel='stylesheet'>
	<link href='../css/jquery.cleditor.css' rel='stylesheet'>
	<link href='../css/jquery.noty.css' rel='stylesheet'>
	<link href='../css/noty_theme_default.css' rel='stylesheet'>
	<link href='../css/elfinder.min.css' rel='stylesheet'>
	<link href='../css/elfinder.theme.css' rel='stylesheet'>
	<link href='../css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='../css/opa-icons.css' rel='stylesheet'>
	<link href='../css/uploadify.css' rel='stylesheet'>
	<link href='../css/screen.css' rel='stylesheet'>
	<link href='../css/jquery.treeview.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
		
</head>

<body>
		<!-- topbar starts -->
	
		<div style="background: #154194;">
			<img src="../image/logo_b.png" alt="" style="margin: 5px 40px; float: left">
			<div class="container-fluid">
			<div style="float: left">
			<?php
				include("../menu.php");
			    ?>
			</div>

			<div style="margin: 20px 30px 0 0">
			<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="../#">
						<i class="icon-user"></i><span class="hidden-phone"> <?php echo $_SESSION['nome_usu'];?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
                        <li><a href="../troca_senha">Dados</a></li>
						<li class="divider"></li>
						<li><a href="../sair.php">Sair</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->

			</div>
			</div>
		</div>
		
	
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
							
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="../http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10">
			<!-- content starts -->
			<div class="row-fluid sortable">
						
							<div class="box span12">
								<div class="box-header well" data-original-title>
									<h2><i class="icon-plus"></i> Produtos Configuráveis</h2>
									
								</div>

								<!-- log -->
								<div class="log"></div>
		
								<div class="box-content" id="entry">									
								              
								</div>								
							</div><!--/span-->
			</div>
			<!-- fim da tabela -->

		<footer>
			<p class="pull-left">&copy; <a href="../" target="_blank" style="color: #000066">ERP</a> 2012</p>
			<p class="pull-right">Powered by: <a href="../" style="color: #000066">Kirzner do Brasil</a></p>
		</footer>
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	<script src="../js/jquery-1.7.2.min.js"></script>
	<!-- TreeView -->
	<script src="../js/jquery.treeview.js"></script>
	<!-- upload -->
	<script src="jquery.uploadify.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="uploadify.css">
	
	<!-- crud -->
	<script type="text/javascript" src="crud.js"></script>
	<!-- jQuery UI -->
	<script src="../js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="../js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="../js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="../js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="../js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="../js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="../js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="../js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="../js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="../js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="../js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="../js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="../js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="../js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="../js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='../js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='../js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="../js/excanvas.js"></script>
	<script src="../js/jquery.flot.min.js"></script>
	<script src="../js/jquery.flot.pie.min.js"></script>
	<script src="../js/jquery.flot.stack.js"></script>
	<script src="../js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="../js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="../js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="../js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="../js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="../js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="../js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="../js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="../js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="../js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="../js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="../js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="../js/charisma.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
<div class="loader">
	<div>
		<img src="../img/ajax-loaders/ajax-loader-7.gif" title="img/ajax-loaders/ajax-loader-7.gif">
		<h4>Carregando</h4>
	</div>
</div>		

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">

        <h3 id="myModalLabel">Tem certeza que deseja excluir esse item <font color='red'>(ele também será removido do Magento)</font>?</h3>
    </div>
    <div class="modal-body">
        <p>Tem certeza que deseja excluir esse item?</p>
    </div>
    <div class="modal-footer">
        <input type="hidden" id="valor" value="" />
        <button onclick="confirma($(this).val());" id="teste" class="btn btn-danger" >Sim</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Não</button>

    </div>
</div>
</body>
</html>
