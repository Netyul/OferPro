<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/

$lojista = str_replace("-"," ", $perfilLojista);
$query_lojista = "SELECT * FROM lojista WHERE nomeFantasia ='".$lojista."' ORDER BY id DESC";
$Result_lojista = mysqli_query($dboferapp, $query_lojista);
$rows_lojista = mysqli_fetch_array($Result_lojista);

$query_lojistaOfertas = "SELECT * FROM ofertas  WHERE id_lojista =".$rows_lojista['id']." ORDER BY id DESC";
$Result_lojistaOfertas = mysqli_query($dboferapp, $query_lojistaOfertas);
while($rows_lojistaOfertas = mysqli_fetch_array($Result_lojistaOfertas)){
	$lojistaOfertas = str_replace(" ","-", $rows_lojistaOfertas['titulo']);
	if($subaction == $lojistaOfertas){
				$perfilLojistaOfertas = $lojistaOfertas;
	}
}

if(isset($pagina) && isset($action) && isset($perfilLojistaOfertas) && $subaction == $perfilLojistaOfertas){
	require_once('paginas/lojistaOfertasVisual.php');
}
elseif(isset($pagina) && isset($action) && $action == 'ofertas' && empty($subaction)){
		
		$home_query = "SELECT  o.titulo, o.descricao, o.valor, o.img, l.nomeFantasia FROM ofertas AS o INNER JOIN lojista AS l ON l.id = o.id_lojista WHERE o.id_lojista =".$rows_lojista['id']." ORDER BY o.id DESC";
		$resultHome = mysqli_query($dboferapp, $home_query);
		$totalRows = mysqli_num_rows($resultHome);
?>
<?php require_once('skin/section.phtml'); ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Ofertas da loja <?php echo $rows_lojista['nomeFantasia']; ?></h2>
            
            </div>
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
		</div>
	</div>
</main>
<?php } ?>