<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo verifica se tem admin logado
* Versão: 1.0
*/
if (!isset($_SESSION)) {
  session_start();
}
$urlloginadm = 'http://'.$_SERVER['HTTP_HOST'];
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
define("IDUSER", $_SESSION['user_id']);
define("NOME", $_SESSION['usuario']);

}else{
	$url->UrlJavaRedir($urlloginadm);
	$url->JavaRedir();
}
?>