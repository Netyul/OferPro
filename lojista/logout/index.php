<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo logout do sistema administrativo
* Versão: 1.0
*/
$logoutUrl = 'http://'.$_SERVER['HTTP_HOST'];
if (!isset($_SESSION)) {
  session_start();
}

if(isset($_SESSION['id_jojista'])){
	$_SESSION = array();
	
	session_destroy();
}
header('location: '. $logoutUrl);
?>