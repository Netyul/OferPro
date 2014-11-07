<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da seção presentes da pagina home do sistema Oferapp.
 * versão 1.0
 */
			
$cidade = explode("-", $catCidade);

?>
<ul class="row">
	<?php 
	
		$frontCidade_query = "SELECT p.id, p.titulo, p.img, p.descricao, l.nomeFantasia, c.nome AS nomeCidade FROM cidade AS c INNER JOIN lojista AS l ON c.id = l.cidade INNER JOIN presentes AS p ON l.id = p.id_lojista WHERE c.nome = '".$cidade[0]."' ORDER BY id DESC";
		$frontCidade = mysqli_query($dboferapp, $frontCidade_query);
		$totalRows = mysqli_num_rows($frontCidade);
		if($totalRows <=0){
			echo '<div class="alert alert-warning" role="alert">Nenhum presente cadastrado para essa cidade!</div>';
		}
		while($frontCidadeRows = mysqli_fetch_array($frontCidade)){
			$Presentes = str_replace(" ","-", $frontCidadeRows['titulo']);
			$lojista = str_replace(" ","-", $frontCidadeRows['nomeFantasia']);
			$linkPresentes = $lojista.'/presentes/'.$Presentes;
    ?>
    <li class="col-md-3 ">
        <div class="well well-sm">
            <div class="thumbnail destaque-images">
            	<img src="<?php baseurl(IMGPRESENTES. $frontCidadeRows['img']);?>" alt="<?php echo $frontCidadeRows['titulo'];?>" style="width:218px; height:147px;">
                <div class="overlay">
                	<p><?php echo $frontCidadeRows['descricao'];?></p>
                     <p><a href="<?php baseurl($linkPresentes);?>" class="btn btn-Oferapp"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
                </div>
                <h5><?php echo $frontCidadeRows['titulo'];?></h5>
            </div>
        </div>
    </li>
    <?php }?>

</ul> 