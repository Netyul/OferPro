<?php

/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * classe do core para incluir arquivos.
 */
	 // por padrão essea classe inclui arquivos apartir do directorio RAIZDIR
namespace sistema\core{
    class incluir{
        public function incluir($nomearquivo){
            require_once(RAIZDIR . $nomearquivo. '.php');
        }
        //incluir arquivos da skin com aruivos phtml
        public function incluirSkin($parametro){
            require_once(RAIZDIR.'/skin/'.$parametro); 
        }
        public function  skinUrl($parametro){
                echo 'http://'.BASEURL . '/skin/' . $parametro;
        }
        public function SkinDir($parametro){
                echo 'skin/'. $parametro;
        }
    }
}