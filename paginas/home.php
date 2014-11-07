<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da pagina home do sistema Oferapp.
 * versão 1.0
 */
			

require_once('skin/section.phtml');



?>
<main>
<div class="container">
    <div class="area inicial">
        <div class="top">
            <ul class="nav nav-tabs nav-justified" role="tablist"  id="myTab">
            	<li class="active"><a href="#ofertas" role="tab" data-toggle="tab"><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_01.png'); ?>" width="39">Ofertas em Destaques </a></li>
                <li><a href="#tabloides" role="tab" data-toggle="tab"><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_04.png'); ?>" width="39"> Tablóides em Destaques </a></li>
                <li><a href="#presentes" role="tab" data-toggle="tab"><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_03.png'); ?>" width="39"> Ganhar Presentes</a></li>
            </ul>            
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="ofertas">
            	<?php require_once('paginas/home-ofertas.php'); ?>
            </div>
            <div class="tab-pane fade" id="tabloides">
            	<?php require_once('paginas/home-tabloides.php'); ?> 
            </div>
            <div class="tab-pane fade" id="presentes">
            	<?php require_once('paginas/home-presentes.php'); ?> 
            </div>
        </div> 
    </div>
</div> 
</main>
<?php

?>