<?php
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da pagina cidade do sistema Oferapp.
 * versão 1.0
 */

require_once('skin/section.phtml');



?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            <?php 
				if($pagina == $catCidade){
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo $catCidade; ?></h2>
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