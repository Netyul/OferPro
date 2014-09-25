<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo verifica se tem admin logado
* Versão: 1.0
*/
session_start();
$urlloginadm = 'http://'.$_SERVER['HTTP_HOST'].'/lojista/login';
if(isset($_SESSION['id_lojista']) && !empty($_SESSION['id_lojista'])){
define("IDLOJISTA", $_SESSION['id_lojista']);
define("LNOME", $_SESSION['lojista']);

}else{
	header('location: '.$urlloginadm);
	exit;
}
?>