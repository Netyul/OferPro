<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da seção presentes da pagina home do sistema Oferapp.
 * versão 1.0
 */


$presentes_query = "SELECT p.titulo, p.descricao, p.img, l.nomeFantasia FROM presentes AS p INNER JOIN lojista AS l ON l.id = p.id_lojista ORDER BY p.id DESC";
$resultPresentes = mysqli_query($dboferapp, $presentes_query);
$totalRows = mysqli_num_rows($resultPresentes);
?>
<ul class="row">
	<?php 
	if($totalRows <=0){
			echo '<div class="alert alert-warning" role="alert">Nenhum presente cadastrado!</div>';
		}
    while($presentesRows = mysqli_fetch_array($resultPresentes)){
		$Presentes = str_replace(" ","-", $presentesRows['titulo']);
		$lojista = str_replace(" ","-", $presentesRows['nomeFantasia']);
		$linkPresentes = $lojista.'/presentes/'.$Presentes;
    ?>
    <li class="col-md-3 ">
        <div class="well well-sm">
            <div class="thumbnail destaque-images">
            	<img src="<?php baseurl(IMGPRESENTES. $presentesRows['img']);?>" alt="<?php echo $presentesRows['titulo'];?>" style="width:218px; height:147px;">
                <div class="overlay">
                	<p><?php echo $presentesRows['descricao'];?></p>
                    <p><a href="<?php baseurl($linkPresentes);?>" class="btn btn-Oferapp" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
                </div>
                <h5><?php echo $presentesRows['titulo'];?></h5>
            </div>
        </div>
    </li>
    <?php }?>

</ul> 