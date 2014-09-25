<?php

/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções mais ultilizadas no sistema Oferapp.
 */

//namespace sistema\classes;

/**
 * classe para enviar email
 *
 * @author Jefte Amorim da Costa
 */
class Email {
    //put your code here
    public function email($para = "OferApp", $email='', $assunto='', $msg=''){
        $headers  = "From: $para\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"\n\n";
        
        $enviar = mail($email, $assunto, $msg, $headers);
        if($enviar){
            return true;
        }
        else {
            return false;
        }
    }
}
