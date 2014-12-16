<?php
session_start();

unset($_SESSION[cod_admin]);
unset($_SESSION[nome_admin]);

echo "<script>document.location='index.php'</script>";
?>
