<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Arquivo de metategs do sistema oferapp
* Versão: 1.0
*/
$tituloQuery = "SELECT * FROM oferapp";
$ResultTags = mysqli_query($dboferapp, $tituloQuery);
$tagsOferapp = mysqli_fetch_array($ResultTags);
if(!isset($pagina) || $pagina ==''){
	$tituloTag = $tagsOferapp['titulo']." - ".$tagsOferapp['slogan'];
	$TagsKeywords = $tagsOferapp['keywords'];
	$TagsDescription = $tagsOferapp['description'];
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];
}