<?php

/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem as funções mais ultilizadas no sistema Oferapp.
 */

//namespace sistema\classes;

/**
 * Esta classe contera funções para tratrar e redirecionar urls
 *
 * @author Jefte Amorim da Costa
 */
class url {
    //put your code here
    private $redirUrl;
    private $msg;
	public $urlAmigavel;
	
	public function __construct(){
		$this->urlAmigavel();
	}

    public function UrlJavaRedir($url){
        $this->redirUrl = '<script type="text/javascript">location.href=("'. $url. '");</script>';
    }
    public function JavaRedir(){
        echo $this->redirUrl;
    }
    public function JavaMsgAlert($msg){
        $this->msg = '<script type="text/javascript">$().alert("'.$msg.'");</script>';
    }
    public function JavaAlert(){
        echo $this->msg;
    }
    public function JavaAlertRedir($msg, $url){
        $this->JavaMsgAlert($msg);
        $this->UrlJavaRedir($url);
        echo $this->JavaAlert();
        echo $this->JavaRedir();
    }
	private function urlAmigavel(){
		$url = isset($_GET['url']) ? $_GET['url'] : '';
		$quebraUrl = explode('/', $url);
		$this->urlAmigavel = $quebraUrl;
		 
	}
}
