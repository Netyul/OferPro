<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/
require_once('skin/section.phtml');



	


?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            <?php 
				if($pagina == 'logout'){
					$main = 'Deslogando'
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo $main; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class="alert alert-success" role="alert">Obrigado por ultilizar o sistema da OferApp!</div>
            </div>
        </div>
    </div>
</main>
<?php
$logoutUrl = 'http://'.$_SERVER['HTTP_HOST'];
if (!isset($_SESSION)) {
  session_start();
}

if(isset($_SESSION['user_id'])){
	$_SESSION = array();
	
	session_destroy();
}
$url->UrlJavaRedir(BASEURL);
$url->JavaRedir();
?>
