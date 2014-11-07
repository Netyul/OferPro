<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da seçõa da pagina home do sistema Oferapp.
 * versão 1.0
 */
 
$cidade = explode("-", $catCidade);

?>
<ul class="row">
	<?php 
		
		$frontCidade_query = "SELECT t.id, t.titulo, t.img, t.descricao, l.nomeFantasia, c.nome AS nomeCidade FROM cidade AS c INNER JOIN lojista AS l ON c.id = l.cidade INNER JOIN tabloide AS t ON l.id = t.id_lojista WHERE c.nome = '".$cidade[0]."' ORDER BY id DESC";
		$frontCidade = mysqli_query($dboferapp, $frontCidade_query);
		$totalRows = mysqli_num_rows($frontCidade);
		if($totalRows <=0){
			echo '<div class="alert alert-warning" role="alert">Nenhum tablóide cadastrado para essa cidade!</div>';
		}
		while($frontCidadeRows = mysqli_fetch_array($frontCidade)){
			$lojista = str_replace(" ","-", $frontCidadeRows['nomeFantasia']);
			$linkOferta = $lojista;
    ?>
    <li class="col-md-3 ">
        <div class="well well-sm">
            <div class="thumbnail destaque-images">
                <img src="<?php baseurl(IMGTABLOIDE. $frontCidadeRows['img']);?>" alt="<?php echo $frontCidadeRows['titulo'];?>" style="width:218px; height:147px;">
            <div class="overlay">
                <p><?php echo $frontCidadeRows['descricao'];?></p>
                <p><a href="#<?php echo $frontCidadeRows['id']; ?>" class="btn btn-Oferapp" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
            </div>
            <h5><?php echo $frontCidadeRows['titulo'];?></h5>
            </div>
        </div>
        <div class="modal fade" id="<?php echo $frontCidadeRows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ModalOfertas" aria-hidden="true">
  			<div class="modal-dialog modal-lg">
    			<div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $frontCidadeRows['titulo'];?> </h4>
                    </div>
                    <div class="modal-body">
                        <a href="<?php echo $lojista;?>" class="thumbnail">
                        <img src="<?php baseurl(IMGTABLOIDE. $frontCidadeRows['img']);?>" alt="<?php echo $tabloideRows['titulo'];?>" style="width:100%;">
                        </a>
                        <p align="left"><?php echo $frontCidadeRows['descricao'];?></p>
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