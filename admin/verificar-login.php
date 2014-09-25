<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo verifica se tem admin logado
* Versão: 1.0
*/
session_start();
$urlloginadm = 'http://'.$_SERVER['HTTP_HOST'].'/admin/login';
if(isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])){
define("IDADMIN", $_SESSION['admin_id']);
define("ADMNOME", $_SESSION['Admin']);
define("LEVEL", $_SESSION['level']);
}else{
	header('location: '.$urlloginadm);
	exit;
}