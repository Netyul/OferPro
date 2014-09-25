<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/

?>
<?php require_once('skin/section.phtml'); ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            <?php 
				if($action == 'perfil'){
					$perfil = 'Edite seu perfil';
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo $perfil; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
</main>