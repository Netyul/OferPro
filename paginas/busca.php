<?php
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da pagina CONTATO do sistema Oferapp.
 * versão 1.0
 */		
 if(isset($_POST['submit']) && isset($_POST['buscar']) && $_POST['buscar'] !='' ){
	 $query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
		$buscaresult = mysqli_query($dboferapp, $query_busca);
		$totalBusca = mysqli_num_rows($buscaresult);
		$row_busca = mysqli_fetch_array($buscaresult);
			if($totalBusca>0){
				$vezes = $row_busca['veses'];
				$soma = $vezes +1;
				$up_busca = "UPDATE busca SET veses=".$soma." WHERE id = ".$row_busca['id'];
				$RSupBusca = mysqli_query($dboferapp, $up_busca);
			}else{
				$insert_busca = "INSERT INTO busca(busca, veses) VALUES ('".$_POST['buscar']."', 1)";
				$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
			}
	 require_once('skin/section.phtml');
 	if(isset($_POST['tipo']) && $_POST['tipo'] == "ofertas"){
		
 ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top">
            	<ul class="nav nav-tabs" role="tablist"  id="myTab">
            	<li class="active"><a ><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_01.png'); ?>" width="39"> Busca de Ofertas </a></li>
                </ul>
            </div>
            <ul class="row">
				<?php
				$home_query = "SELECT o.titulo, o.descricao, o.valor, o.img, l.nomeFantasia FROM ofertas AS o INNER JOIN lojista AS l ON l.id = o.id_lojista WHERE o.titulo LIKE '%".$_POST['buscar']."%'  ORDER BY o.id DESC";
				$resultHome = mysqli_query($dboferapp, $home_query);
				$totalRows = mysqli_num_rows($resultHome); 
                if($totalRows <=0){
                echo '<div class="alert alert-warning" role="alert">Nenhuma oferta encontrada!</div>';
				$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
				$buscaresult = mysqli_query($dboferapp, $query_busca);
				$totalBusca = mysqli_num_rows($buscaresult);
				$row_busca = mysqli_fetch_array($buscaresult);
				if($totalBusca>0){
								$vezes = $row_busca['vesenaoencontradas'];
								$soma = $vezes +1;
								$up_busca = "UPDATE busca SET vesenaoencontradas=".$soma." WHERE id = ".$row_busca['id'];
								$RSupBusca = mysqli_query($dboferapp, $up_busca);
							}else{
								$insert_busca = "INSERT INTO busca(busca, vesenaoencontradas) VALUES ('".$_POST['buscar']."', 1)";
								$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
							}	
                }else{
					$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
				$buscaresult = mysqli_query($dboferapp, $query_busca);
				$totalBusca = mysqli_num_rows($buscaresult);
				$row_busca = mysqli_fetch_array($buscaresult);
					if($totalBusca>0){
						$vezes = $row_busca['veseencontradas'];
						$soma = $vezes +1;
						$up_busca = "UPDATE busca SET veseencontradas=".$soma." WHERE id = ".$row_busca['id'];
						$RSupBusca = mysqli_query($dboferapp, $up_busca);
					}else{
						$insert_busca = "INSERT INTO busca(busca, veseencontradas) VALUES ('".$_POST['buscar']."', 1)";
						$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
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
                                <p><a href="<?php baseurl($linkOferta);  ?>" class="btn btn-Oferapp" data-toggle="modal"><span class="glyphicon glyphicon-eye-open"></span> Ver Mais...</a></p>
                            </div>
                            <h5><?php echo $homeRows['titulo'];?></h5>
                        </div>
                    </div>
                </li>
                <?php }}?>
            </ul>
        </div>
    </div>
</main>
<?php 
	}
	if(isset($_POST['tipo']) && $_POST['tipo'] == "tabloides"){
		
 ?>
 <main>
    <div class="container">
        <div class="area inicial">
            <div class="top">
            	<ul class="nav nav-tabs" role="tablist"  id="myTab">
            	<li class="active"><a ><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_04.png'); ?>" width="39"> Busca de Tablóides</a></li>
                </ul>
            </div>
            <ul class="row">
				<?php 
				$Tabloide_query = "SELECT t.id, t.titulo, t.descricao, t.img, l.nomeFantasia FROM tabloide AS t INNER JOIN lojista as l ON l.id = t.id_lojista WHERE t.titulo LIKE '%".$_POST['buscar']."%' ORDER BY t.id DESC";
				$resultTabloide = mysqli_query($dboferapp, $Tabloide_query);
				$totalRows = mysqli_num_rows($resultTabloide);
                if($totalRows <=0){
                	echo '<div class="alert alert-warning" role="alert">Nenhum tablóide encontrado!</div>';
					$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
				$buscaresult = mysqli_query($dboferapp, $query_busca);
				$totalBusca = mysqli_num_rows($buscaresult);
				$row_busca = mysqli_fetch_array($buscaresult);
					if($totalBusca>0){
								$vezes = $row_busca['vesenaoencontradas'];
								$soma = $vezes +1;
								$up_busca = "UPDATE busca SET vesenaoencontradas=".$soma." WHERE id = ".$row_busca['id'];
								$RSupBusca = mysqli_query($dboferapp, $up_busca);
							}else{
								$insert_busca = "INSERT INTO busca(busca, vesenaoencontradas) VALUES ('".$_POST['buscar']."', 1)";
								$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
							}	
                }else{
					$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
				$buscaresult = mysqli_query($dboferapp, $query_busca);
				$totalBusca = mysqli_num_rows($buscaresult);
				$row_busca = mysqli_fetch_array($buscaresult);
					if($totalBusca>0){
						$vezes = $row_busca['veseencontradas'];
						$soma = $vezes +1;
						$up_busca = "UPDATE busca SET veseencontradas=".$soma." WHERE id = ".$row_busca['id'];
						$RSupBusca = mysqli_query($dboferapp, $up_busca);
					}else{
						$insert_busca = "INSERT INTO busca(busca, veseencontradas) VALUES ('".$_POST['buscar']."', 1)";
						$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
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
                <?php }}?>
            </ul>
        </div>
    </div>
</main>
 <?php 
 }
 if(isset($_POST['tipo']) && $_POST['tipo'] == "presentes"){
	 
 ?>
 <main>
    <div class="container">
        <div class="area inicial">
            <div class="top">
            	<ul class="nav nav-tabs" role="tablist"  id="myTab">
            	<li class="active"><a ><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_03.png'); ?>" width="39"> Busca de Presentes</a></li>
                </ul>
            </div>
                <ul class="row">
					<?php 
					$presentes_query = "SELECT p.titulo, p.descricao, p.img, l.nomeFantasia FROM presentes AS p INNER JOIN lojista AS l ON l.id = p.id_lojista WHERE p.titulo LIKE '%".$_POST['buscar']."%' ORDER BY p.id DESC";
					$resultPresentes = mysqli_query($dboferapp, $presentes_query);
					$totalRows = mysqli_num_rows($resultPresentes);
                    if($totalRows <=0){
                            echo '<div class="alert alert-warning" role="alert">Nenhum presente encontrado!</div>';
								$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
								$buscaresult = mysqli_query($dboferapp, $query_busca);
								$totalBusca = mysqli_num_rows($buscaresult);
								$row_busca = mysqli_fetch_array($buscaresult);
							if($totalBusca>0){
								
								$vezes = $row_busca['vesenaoencontradas'];
								$soma = $vezes +1;
								$up_busca = "UPDATE busca SET vesenaoencontradas=".$soma." WHERE id = ".$row_busca['id'];
								$RSupBusca = mysqli_query($dboferapp, $up_busca);
							}else{
								$insert_busca = "INSERT INTO busca(busca, vesenaoencontradas) VALUES ('".$_POST['buscar']."', 1)";
								$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
							}	
                        }else{
							$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
								$buscaresult = mysqli_query($dboferapp, $query_busca);
								$totalBusca = mysqli_num_rows($buscaresult);
								$row_busca = mysqli_fetch_array($buscaresult);
							if($totalBusca>0){
						$vezes = $row_busca['veseencontradas'];
						$soma = $vezes +1;
						$up_busca = "UPDATE busca SET veseencontradas=".$soma." WHERE id = ".$row_busca['id'];
						$RSupBusca = mysqli_query($dboferapp, $up_busca);
					}else{
						$insert_busca = "INSERT INTO busca(busca, veseencontradas) VALUES ('".$_POST['buscar']."', 1)";
						$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
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
                    <?php }}?>
            
            </ul> 
        </div>
    </div>
</main>  
<?php }
 if(isset($_POST['tipo']) && $_POST['tipo'] == "lojas"){
?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top">
            	<ul class="nav nav-tabs" role="tablist"  id="myTab">
            	<li class="active"><a> <span class="glyphicon glyphicon-shopping-cart"></span> Busca por Lojas</a></li>
                </ul>
            </div>
            <ul class="row">
				<?php 
				$lojista_query = "SELECT * FROM lojista WHERE nomeFantasia LIKE '%".$_POST['buscar']."%' ORDER BY id DESC";
				$resultLojista = mysqli_query($dboferapp, $lojista_query);
				$totallojistaRows = mysqli_num_rows($resultLojista);
                if($totallojistaRows <=0){
                	echo '<div class="alert alert-warning" role="alert">Nenhuma loja encontrada!</div>';
					$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
				$buscaresult = mysqli_query($dboferapp, $query_busca);
				$totalBusca = mysqli_num_rows($buscaresult);
				$row_busca = mysqli_fetch_array($buscaresult);
					if($totalBusca>0){
								$vezes = $row_busca['vesenaoencontradas'];
								$soma = $vezes +1;
								$up_busca = "UPDATE busca SET vesenaoencontradas=".$soma." WHERE id = ".$row_busca['id'];
								$RSupBusca = mysqli_query($dboferapp, $up_busca);
							}else{
								$insert_busca = "INSERT INTO busca(busca, vesenaoencontradas) VALUES ('".$_POST['buscar']."', 1)";
								$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
							}	
                }else{
					$query_busca = "SELECT * FROM busca WHERE busca = '".$_POST['buscar']."'";
				$buscaresult = mysqli_query($dboferapp, $query_busca);
				$totalBusca = mysqli_num_rows($buscaresult);
				$row_busca = mysqli_fetch_array($buscaresult);
					if($totalBusca>0){
						$vezes = $row_busca['veseencontradas'];
						$soma = $vezes +1;
						$up_busca = "UPDATE busca SET veseencontradas=".$soma." WHERE id = ".$row_busca['id'];
						$RSupBusca = mysqli_query($dboferapp, $up_busca);
					}else{
						$insert_busca = "INSERT INTO busca(busca, veseencontradas) VALUES ('".$_POST['buscar']."', 1)";
						$Res_insert_busca = mysqli_query($dboferapp, $insert_busca);
					}	
                while($lojistaRows = mysqli_fetch_array($resultLojista)){
					$lojista = str_replace(" ","-", $lojistaRows['nomeFantasia']);
					$linkLojista = $lojista;
                ?>
                <li class="col-md-3 ">
                    <div class="thumbnail">
                      <a href="<?php baseurl($linkLojista); ?>" >
                          <img src="<?php baseurl(IMGPERFIL. $lojistaRows['img']);?>" alt="<?php echo $lojistaRows['nomeFantasia'];?>" style="width:100%; height:147px;">
                      </a>
                      <div class="caption">
                         <h5><?php echo $lojistaRows['nomeFantasia'];?></h5>
                      </div>
                   </div>
                </li>
                <?php }}?>
            </ul>
        </div>
    </div>
</main>
<?php	 
 }
}
else{
	require_once('skin/section.phtml');
	
?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            	<h2>  <span class="glyphicon glyphicon-search"></span> Busca </h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="alert alert-warning" role="alert">Nenhum busca foi feita!</div>
                </div>
            </div>
        </div>
    </div>
</main>  
<?php		
	}
?>            