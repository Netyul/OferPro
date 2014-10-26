<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da seçõa da pagina home do sistema Oferapp.
 * versão 1.0
 */
 
$home_query = "SELECT  o.titulo, o.descricao, o.valor, o.img, l.nomeFantasia FROM ofertas AS o INNER JOIN lojista AS l ON l.id = o.id_lojista ORDER BY o.id DESC";
$resultHome = mysqli_query($dboferapp, $home_query);
$totalRows = mysqli_num_rows($resultHome);
		
 ?>
<ul class="row">
	<?php 
	if($totalRows <=0){
			echo '<div class="alert alert-warning" role="alert">Nenhum oferta cadastrado!</div>';
		}
    while($homeRows = mysqli_fetch_array($resultHome)){
		$Oferta = str_replace(" ","-", $homeRows['titulo']);
		$lojista = str_replace(" ","-", $homeRows['nomeFantasia']);
		$linkOferta = $lojista.'/ofertas/'.$Oferta;
    ?>
    <li class="col-md-3 ">
        <div class="well well-sm">
            <div class="thumbnail destaque-images">
                <img src="<?php baseurl(IMGOFERTAS. $homeRows['img']);?>" alt="<?php echo $homeRows['titulo']; ?>" style="width:218px; height:147px;">
            <div class="overlay">
                <p><?php echo $homeRows['descricao'];?></p>
                <p><a href="<?php baseurl($linkOferta);?>" class="btn btn-Oferapp" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
            </div>
            <h5><?php echo $homeRows['titulo'];?></h5>
            </div>
        </div>
    </li>
    <?php }?>
</ul>
<?php while($ModalOfertas = mysqli_fetch_array($resultHome)){  
?>

<?php } ?>