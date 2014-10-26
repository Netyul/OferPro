<?php

/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções mais ultilizadas no sistema Oferapp.
 */


/**
 * Classe para tratamento de texto
 *
 * @author Jefte Amorim da Costa
 */
class texto {
    private $texto;
    private $maximo = '100';
    //put your code here
   public function __construct($texto){
	   $this->ContaTexto($texto, $this->maximo);
	   echo $this->Texto();
   }

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
            $espaco = strrpos($limita, " ");
            $limita = substr($texto, 0, $espaco);
            $this->texto = $limita . " ...";
				 
	}
    }
    public function Texto(){
        echo $this->texto;
    }
    public function LimpaTexto($texto){
        $this->texto = mysqli_real_escape_string(strip_tags(trim(stripcslashes($texto))));
    }
}
