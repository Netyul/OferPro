<?php

/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções mais ultilizadas no sistema Oferapp.
 */

/*-- função autoload para classes --*//*
function __autoload( $class ){
 $class = RAIZDIR . '/' . str_replace('\\', '/' , $class ) . '.php';
    
    if( ! file_exists($class)){
        throw new Exception("A Classe: '{$class}' que estar tentando usar não existe");
   }
    require_once ($class);
   
}
*/
/*-- Funções para incluir ou requerir arquivos no sistema --*/

//incluir arquivos php so pelo nome
function incluir($nomearquivo){
    require_once($nomearquivo. '.php');
}
function incluirSkin($parametro){
    require_once('skin/'.$parametro); 
    
}
//inclir arquivos pela url como imagens javascript, e css
function SkinUrl($parametro){
    echo BASEURL . '/skin/' . $parametro;
}
//incluir arquivos por directorio aquivos como .js, .css e imagens
function SkinArq($parametro){
     echo 'skin/'. $parametro;
}
function incluirSistema($arquivo){
    require ('sistema/'.$arquivo.'.php');
}
function core($arquivo){
	require_once('sistema/core/'.$arquivo);
}
function baseurl($caminho){
	 echo BASEURL .'/'.$caminho;
}
function pagination($sql, $maxPost, $paginaAtual, $atributoLink = ''){
	
	$ResultAll = mysqli_query($sql);
	$totalPost = mysqli_num_rows($ResultAll);
	$paginas   = ceil($totalPost / $maxPost);
	
	//pagination
	echo'<ul  class="pagination">';
	//pagina inicial
	echo'<li><a  href= "'.BASEURL.'/'.$_GET['url'].'" ><span class="glyphicon glyphicon-backward"></span></a></li>';
}