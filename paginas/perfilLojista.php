<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/
if(isset($_POST['receberNotificacao']) && $_POST['receberNotificacao'] == 'receberNotificacao'){
	$idLojista = $_POST['id_lojista'];
	$idUser    = $_POST['id_user'];
	$insert = "INSERT INTO rec_notificacao(id_user, id_lojista) VALUES(".$idUser.", ".$idLojista.")";
	$resultRecNot = mysqli_query($dboferapp, $insert);
}
if(isset($_POST['cancelarNotificacao']) && $_POST['cancelarNotificacao'] == 'cancelarNotificacao'){
	$idLojista = $_POST['id_lojista'];
	$idUser    = $_POST['id_user'];
	$delecte = "DELETE FROM rec_notificacao WHERE id_user=".$idUser." AND id_lojista=".$idLojista;
	$resultRecNot = mysqli_query($dboferapp, $delecte);
}
	if(isset($pagina) && isset($action) && $action == 'ofertas'){
		require_once('paginas/lojistaOfertas.php');
	}
	elseif(isset($pagina) && isset($action) && $action == 'presentes'){
		require_once('paginas/lojistaPresentes.php');
	}
	elseif(isset($pagina) && empty($action) && $pagina == $perfilLojista){
		$lojista = str_replace("-"," ", $perfilLojista);
		$query_lojista = "SELECT * FROM lojista WHERE nomeFantasia ='".$lojista."'   ORDER BY id DESC";
		$Result_lojista = mysqli_query($dboferapp, $query_lojista);
		$rows_lojista = mysqli_fetch_array($Result_lojista);
		
?>
<?php require_once('skin/section.phtml'); ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> <?php echo $lojista; ?></h2>
            </div>
            <div class="row">
             	<?php 
				if($rows_lojista['statos'] == 'off'){
					echo '<div class="col-md-12"><div class="alert alert-warning" role="alert">Esta loja esta temporariamente indisponivel!</div></div>';
				}
				?>
                <div class=" col-md-9" style="text-align: center; border-right:1px #CCC solid;">
                	<ul class="nav nav-tabs nav-justified" role="tablist"  id="myTab">
                    	<li class="active"><a href="#tabloides" role="tab" data-toggle="tab"><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_01.png'); ?>" width="39"> Tabloides</a></li>
                    	<li><a href="#ofertas" role="tab" data-toggle="tab"><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_04.png'); ?>" width="39"> Ofertas</a></li>
                        <li><a href="#presentes" role="tab" data-toggle="tab"><img src="<?php baseurl('skin/images/icon_menu_navegacao_usuario_03.png'); ?>" width="39"> Presentes</a></li>
                    </ul>
                     <div class="tab-content">
                     	<div class="tab-pane fade active in" id="tabloides">
                        <?php
                         	$Tabloide_query = "SELECT * FROM tabloide WHERE id_lojista =".$rows_lojista['id']." ORDER BY id DESC";
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
                                <li class="col-sm-6 col-md-4 ">
                                    <div class="thumbnail">
                                    	<a href="#<?php echo $tabloideRows['id']; ?>" data-toggle="modal">
                                            <img src="<?php baseurl(IMGTABLOIDE. $tabloideRows['img']);?>" alt="<?php echo $tabloideRows['titulo'];?>" style="width:100%; height:147px;">
                                        </a>
                                        <div class="caption">
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
                                                    <p><img src="<?php baseurl(IMGTABLOIDE. $tabloideRows['img']);?>" alt="<?php echo $tabloideRows['titulo'];?>" class="img-thumbnail" width="100%"></p>
                                                    <p><?php echo $tabloideRows['descricao'];?></p>
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
                        </div>
                        <div class="tab-pane fade in" id="ofertas">
                        	<?php
                           	$home_query = "SELECT  o.titulo, o.descricao, o.valor, o.img, l.nomeFantasia FROM ofertas AS o INNER JOIN lojista AS l ON l.id = o.id_lojista WHERE o.id_lojista =".$rows_lojista['id']." ORDER BY o.id DESC";
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
                                <li class="col-sm-6 col-md-4 ">
                                    <div class="thumbnail">
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
                        <div class="tab-pane fade" id="presentes">
                        	<?php
                           	$presentes_query = "SELECT p.titulo, p.descricao, p.img, l.nomeFantasia FROM presentes AS p INNER JOIN lojista AS l ON l.id = p.id_lojista WHERE p.id_lojista = ".$rows_lojista['id']." ORDER BY p.id DESC";
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
                                <li class="col-sm-6 col-md-4 ">
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
                        </div>
                        <div class="col-md-12" style="padding:0; margin:0;">
                    	<h4 class="page-header"> Encontre-nos</h4>
                         <div id="mapa" style="height: 400px; width: 100%" class="img-thumbnail">
                         </div>
                           <script type="text/javascript">
						   $(document).ready(function () {
							   var totalendereco = $("#endereco").text()+', '+$("#cidade").text()+', '+$("#estado").text();
							   carregarNoMapa(totalendereco);
							   function carregarNoMapa(endereco) {
									geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
										if (status == google.maps.GeocoderStatus.OK) {
											if (results[0]) {
												var latitude = results[0].geometry.location.lat();
												var longitude = results[0].geometry.location.lng();
												var location = new google.maps.LatLng(latitude, longitude);
												marker.setPosition(location);
												map.setCenter(location);
												map.setZoom(17);
											}
										}
									});
								}
						   });
                           </script>      
                        
                    </div>
                    </div>
                     
                </div>
                <div class="col-md-3" align="left">
                	<div class="form-horizontal">
                    <div class="form-group">
                    	<div class="col-md-12">
                        <a class="thumbnail"><img src="<?php baseurl('media/perfil/'.$rows_lojista['img']); ?>"> </a>
                        <h4><?php echo $rows_lojista['nomeFantasia']; ?></h4>
                        <p><span class="glyphicon glyphicon-earphone"></span> <?php echo $rows_lojista['telefone']; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="col-md-12" align="center">
                    <?php 
					if(isset($_SESSION['user_id'])){
						$notificarUser = "SELECT * FROM rec_notificacao WHERE id_user = ". $_SESSION['user_id'];
						$resultUserNot = mysqli_query($dboferapp, $notificarUser);
						$totalRowsUserNot = mysqli_num_rows($resultUserNot);
						if($totalRowsUserNot >= 1){
					?>
                    <form action="<?php baseurl($perfilLojista); ?>" method="post" name="formCancela">
                    	<input type="hidden" name="cancelarNotificacao" value="cancelarNotificacao" />
                        <input type="hidden" name="id_lojista" value="<?php echo $rows_lojista['id']; ?>" />
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id']; ?>" />
                    	<button type="submit" class="btn btn-danger" title="Cancelar notificação"><span class="glyphicon glyphicon-tags"></span>  Cancelar Notificações</button>
                    </form>
                    <?php } else{?>
                    <form action="<?php baseurl($perfilLojista); ?>" method="post" name="formReceber">
                    	<input type="hidden" name="receberNotificacao" value="receberNotificacao" />
                        <input type="hidden" name="id_lojista" value="<?php echo $rows_lojista['id']; ?>" />
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user_id']; ?>" />
                    	<button type="submit" class="btn btn-Oferapp" title="Receber notificação"><span class="glyphicon glyphicon-tags"></span>  Receber Notificações</button>
					</form>
					<?php
					}
					}
					?>
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <p id="endereco"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $rows_lojista['endereco']; ?></p>
                            <p>Bairro: <?php echo $rows_lojista['bairro'];?></p>
                            <?php
                                $cidadeQuery  = "SELECT * FROM cidade WHERE id =".$rows_lojista['cidade'];
                                $cidadeResult = mysqli_query($dboferapp, $cidadeQuery);
                                $RowCidade    = mysqli_fetch_array($cidadeResult);
                                
                                $estadoQuery  = "SELECT * FROM estado WHERE id =".$RowCidade['id_uf'];
                                $estadoResult = mysqli_query($dboferapp, $estadoQuery);
                                $RowEstado    = mysqli_fetch_array($estadoResult);
                            ?>
                            <p>Cidade:<span id="cidade"> <?php echo $RowCidade['nome']; ?></span></p>
                            <p id="estado">Estado:<span id="estado"> <?php echo $RowEstado['sigla']; ?></span></p>
                            <p>CEP: <?php echo $rows_lojista['cep']; ?></p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
	}
	else{
		require_once('paginas/erro-404.php');
	}
			

?>