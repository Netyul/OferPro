<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da pagina home do sistema Oferapp.
 * versão 1.0
 */
			

require_once('skin/section.phtml');

$home_query = "SELECT * FROM ofertas";
$resultHome = mysqli_query($dboferapp, $home_query);

?>
<main>
<div class="container">
    <div class="area inicial">
        <div class="top page-header">
            <h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Destaques</h2>
            
        </div>
        <ul class="row">
        <?php 
			while($homeRows = mysqli_fetch_array($resultHome)){
		?>
            <li class="col-md-3 ">
                <div class="well well-sm">
                    <div class="thumbnail destaque-images">
                        <img src="<?php baseurl(IMGOFERTAS. $homeRows['img']);?>" alt="<?php echo $homeRows['titulo'];?>"class="img-responsive">
                        <div class="overlay">
                            <p><?php echo $homeRows['descricao'];?></p>
                        </div>
                        <h5><?php echo $homeRows['titulo'];?></h5>
                    </div>
                 </div>
            </li>
            <?php }?>
            
        </ul>  
    </div>
</div> 
</main>
<?php

?>