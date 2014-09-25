<?php

/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções mais ultilizadas no sistema Oferapp.
 */

namespace sistema\classes;

/**
 * Classe para tratamento de texto
 *
 * @author Jefte Amorim da Costa
 */
class texto {
    private $texto;
    private $maximo = '200';
    //put your code here
   

    public function ContaTexto($texto, $maximo){
	//retirar as tegs html do texto
	$texto = strip_tags($texto);
	//conta a quantidade de caracteres
	$conta = strlen($texto);
			 
	if($conta <= $maximo){
            $this->texto = $texto;
	}
	else{
            $limita = substr($texto, 0, $maximo);
            $espaco = strpos($texto, " ");
            $limita = substr($texto, 0, $espaco);
            $this->texto = $limita . "...";
				 
	}
    }
    public function Texto(){
        return $this->texto;
    }
    public function LimpaTexto($texto){
        $this->texto = mysqli_real_escape_string(strip_tags(trim(stripcslashes($texto))));
    }
}
