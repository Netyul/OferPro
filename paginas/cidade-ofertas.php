<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da seçõa da pagina home do sistema Oferapp.
 * versão 1.0
 */
//capturar cidade no banco de dados.
$cidade = explode("-", $catCidade);
$selectCidede = "SELECT * FROM cidade WHERE nome = '".$cidade[0]."'";
$resultCidade = mysqli_query($dboferapp, $selectCidede);
$cidadeRow = mysqli_fetch_array($resultCidade);
//caputurar lojista por cidade no banco de dados
$lojistaCidade = "SELECT * FROM lojista WHERE cidade = ".$cidadeRow['id'];
$resultLojistaCidade = mysqli_query($dboferapp, $lojistaCidade);
 ?>
<ul class="row">
	<?php
    while($lojistaCidadeRows = mysqli_fetch_array($resultLojistaCidade)){
		
		$frontCidade_query = "SELECT * FROM ofertas WHERE id_lojista = ".$lojistaCidadeRows['id']." ORDER BY id DESC";
		$frontCidade = mysqli_query($dboferapp, $frontCidade_query);
		$totalRows = mysqli_num_rows($frontCidade);
		if($totalRows <=0){
			echo '<div class="alert alert-warning" role="alert">Nenhum oferta cadastrado para essa cidade!</div>';
		}
		while($frontCidadeRows = mysqli_fetch_array($frontCidade)){
			$Oferta = str_replace(" ","-", $frontCidadeRows['titulo']);
			$lojista = str_replace(" ","-", $lojistaCidadeRows['nomeFantasia']);
			$linkOferta = $lojista.'/ofertas/'.$Oferta;
    ?>
    <li class="col-md-3 ">
        <div class="well well-sm">
            <div class="thumbnail destaque-images">
                <img src="<?php baseurl(IMGOFERTAS. $frontCidadeRows['img']);?>" alt="<?php echo $frontCidadeRows['titulo']; ?>" style="width:218px; height:147px;">
            <div class="overlay">
                <p><?php echo $frontCidadeRows['descricao'];?></p>
                <p><a href="<?php baseurl($linkOferta);?>" class="btn btn-Oferapp"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
            </div>
            <h5><?php echo $frontCidadeRows['titulo'];?></h5>
            </div>
        </div>
    </li>
    <?php }}?>
</ul>
