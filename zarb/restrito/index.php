<?
session_start();

if($_SESSION[cod_admin])
  echo "<script>document.location='principal.php'</script>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Zarb Solution - administração</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="javascript" type="text/javascript">
	function setFocus() {
		document.loginForm.usuario.select();
		document.loginForm.usuario.focus();
	}

	function focusInput(element,blur) {
if (blur) {
element.style.backgroundColor='white';
} else {
element.style.backgroundColor='#e8e8e8';
}
}
</script>
</head>
<style>
body {
	margin: 0px;
	padding: 0px;
	color : #333;
	background-color : #FFF;
	font-size : 11px;
	font-family : Arial, Helvetica, sans-serif;
}

#wrapper {
        border: 0px;
        margin: 0px;
        margin-left: auto;
        margin-right: auto;
        padding: 0px;
}

#break {
	height: 50px;
}

form {
    margin: 0px;
}



.button {
	border : solid 1px #cccccc;
	background: #E9ECEF;
	color : #666666;
	font-weight : bold;
	font-size : 11px;
	padding: 4px;
}

.login {
	margin-left: auto;
	margin-right: auto;
	margin-top: 6em;
	padding: 15px;
	border: 1px solid #cccccc;
	width: 429px;
	background: #F1F3F5;
}
	
.login h1 {
	background-position: left top;
	color: #333;
	margin: 0px;
	height: 50px;
	padding: 15px 4px 0 50px;
 	text-align: left;
	font-size: 1.5em;
}

.login p {
	padding: 0 1em 0 1em;
	}
	
.form-block {
	border: 1px solid #cccccc;
	background: #E9ECEF;
	padding-top: 15px;
	padding-left: 10px;
	padding-bottom: 10px;
	padding-right: 10px;
}

.login-form {
	text-align: left;
	float: right;
	width: 60%;
}

.login-text {
	text-align: left;
	width: 40%;
	float: left;
}

.inputlabel {
	font-weight: bold;
	text-align: left;
	}

.inputbox {
	width: 150px;
	margin: 0 0 1em 0;
	border: 1px solid #cccccc;
	}

.clr {
    clear:both;
    }

.ctr {
	text-align: center;
}

.version {
	font-size: 0.8em;
}

.footer {

}

.message {
	margin-top: 10px; 
	padding: 7px; 
	width: 400px;
	border: 1px solid #B22222;
	background: #F1F3F5;
	color: #B22222;	
	font-weight: bold;
	font-size: 13px;
}


</style>
<?php

if($_GET[log]=="erro")
  $mensagem = "Dados inv&aacute;lidos.";

?>

<body onload="setFocus();">
<div id="ctr" align="center">
		<div class="login">
		<div class="login-form">
			<img src="login.gif" alt="Autenticação para Área de Administração" />
			<form action="principal.php" method="post" name="loginForm" id="loginForm">
			<div class="form-block">
				<div class="inputlabel">Nome do Usuário</div>
				<div><input  name="login" type="text" class="inputbox" size="15" onFocus="focusInput(this);" onBlur="focusInput(this,true);"/></div>
				<div class="inputlabel">Senha</div>
				<div><input name="senha" type="password" class="inputbox" size="15" onFocus="focusInput(this);" onBlur="focusInput(this,true);" /></div>
				<div align="center"><input type="submit" name="submit_login" class="button" value="Autenticar" /></div>
			</div>
			<input type="hidden" name="enviar" value="enviar" />
			</form>
		</div>
		<div class="login-text">
			<div class="ctr"><img src="security.png" width="64" height="64" alt="security" /></div>
			<p>Utilize um nome de usuário e senha válidos para ter acesso.</p>
			<br /><? print $mensagem; ?>
		</div>
		<div class="clr"></div>
	</div>
</div>
<div id="break"></div>
<noscript>
!Aviso! O Javascript deve estar ativado para uma correta opera&ccedil;&atilde;o da administra&ccedil;&atilde;o.
</noscript>
<div class="footer" align="center">
	
</div>
</body>
</html>
