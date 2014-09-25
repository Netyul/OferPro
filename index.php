<?php
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo Principal do Oferapp.
 */
 session_start();
 //FUNÇÕES BASE DO SITEMA OFERAPP
require_once('functions.php');


// ARQUIVOS DO SISTEMA OFERAPP
define("SISTEMA", "sistema/");
require_once('sistema/constantes.php');
//require_once('sistema/core/autoload.php');
require_once('sistema/core/connectdb.php');
require_once('sistema/core/login.php');
/*-- conexão com banco de dados --*/
mysqli_query($dboferapp, "SET NAMES 'utf8'");
mysqli_query($dboferapp, 'SET character_set_connection=utf8');
mysqli_query($dboferapp, 'SET charecter_set_client=utf8');
mysqli_query($dboferapp, 'SET charecter_set_results=utf8');

/*-- conteudo do Site --*/
require_once('sistema/classes/url.php');
$url = new url();
$urlAmigavel = $url->urlAmigavel;

require_once('sistema/core/metatags.php');
require_once('skin/head.phtml');
require_once('skin/header.phtml');

require_once('skin/main.phtml');
require_once('skin/footer.phtml');
mysqli_close($dboferapp);