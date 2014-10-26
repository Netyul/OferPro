<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da seçõa da pagina home do sistema Oferapp.
 * versão 1.0
 */
 
$Tabloide_query = "SELECT t.id, t.titulo, t.descricao, t.img, l.nomeFantasia FROM tabloide AS t INNER JOIN lojista as l ON l.id = t.id_lojista ORDER BY id DESC";
$resultTabloide = mysqli_query($dboferapp, $Tabloide_query);
$totalRows = mysqli_num_rows($resultTabloide);
 ?>
<ul class="row">
	<?php 
	if($totalRows <=0){
			echo '<div class="alert alert-warning" role="alert">Nenhum tabloide cadastrado!</div>';
		}
    while($tabloideRows = mysqli_fetch_array($resultTabloide)){
    ?>
    <li class="col-md-3 ">
        <div class="well well-sm">
            <div class="thumbnail destaque-images">
                <img src="<?php baseurl(IMGTABLOIDE. $tabloideRows['img']);?>" alt="<?php echo $tabloideRows['titulo'];?>" style="width:218px; height:147px;">
            <div class="overlay">
                <p><?php echo $tabloideRows['descricao'];?></p>
                <p><a href="#<?php echo $tabloideRows['id']; ?>" class="btn btn-Oferapp" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
            </div>
            <h5><?php echo $tabloideRows['titulo'];?></h5>
            </div>
        </div>
        <div class="modal fade" id="<?php echo $tabloideRows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalOfertas" aria-hidden="true">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $tabloideRows['titulo'];?> </h4>
                    </div>
                    <div class="modal-body">
                     <a href="<?php echo $tabloideRows['nomeFantasia'];?>" class="thumbnail">
                     	<img src="<?php baseurl(IMGTABLOIDE. $tabloideRows['img']);?>" alt="<?php echo $tabloideRows['titulo'];?>" style="width:100%;">
                     </a>
                     <p align="left"><?php echo $tabloideRows['descricao'];?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
    			</div>
  			</div>
		</div>
    </li>
    <?php }?>
</ul>