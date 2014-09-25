<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo confirmação de cadastro
* Versão: 1.0
*/
if(isset($msgc)){ 
 	
 	echo '<script type="text/javascript">$(window).load(function() {
        $(".cadastrarUser").click();
    });</script>';

 }
 if(isset($msgcsuccess)){ 
 	
 	echo '<script type="text/javascript">$(window).load(function() {
        $(".cadastrarUser").click();
    });</script>';

 }

?>
<?php require_once('skin/section.phtml'); ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            <?php 
				if($pagina == 'cadastro'){
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo 'Confirmação de Cadastro'; ?></h2>
            <?php }?>
            </div>
            <div class="row">
            	<div class="alert alert-success" role="alert">
                    <p align="center"><strong>cadastro efetuado com sucesso!</strong></p>
                    <p align="center">Faça login para ultilizar o sistema da OferApp!</p> 
                </div>
          </div>
        </div>
    </div>
</main>