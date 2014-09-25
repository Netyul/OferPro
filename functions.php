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
function baseurl($caminho){
	 echo BASEURL .'/'.$caminho;
}