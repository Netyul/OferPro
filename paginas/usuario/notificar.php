<?php
?>
<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/
 require_once('sistema/core/verificar-login.php');
 ?>
<?php require_once('skin/section.phtml'); ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            <?php 
				if($action == 'notificar'){
					$perfilUser = 'Minhas notificações';
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> <?php echo $perfilUser; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class=" col-md-9" style="text-align: center; border-right:1px #CCC solid;">
                <?php
					$minhasOfertas = "SELECT n.id, n.visualizado, l.nomeFantasia, o.titulo, o.descricao, o.img, u.nome FROM notificacao AS n INNER JOIN ofertas AS o ON o.id = n.id_oferta INNER JOIN lojista AS l ON l.id = n.id_lojista INNER JOIN usuario AS u ON u.id = n.id_user WHERE n.id_user =".$_SESSION['user_id'];
					$result_minhasOfertas = mysqli_query($dboferapp, $minhasOfertas);

				?>
                <div class="tab-content">
                    	<div class="tab-pane fade in active">
                            <div class="row">
                            <?php
							$totalrows_minhasOfertas = mysqli_num_rows($result_minhasOfertas);
							if($totalrows_minhasOfertas == 0){
								echo '<div class="alert alert-warning" role="alert">Não a Notificações!</div>';
							}
							while($row_minhasOferta = mysqli_fetch_array($result_minhasOfertas)){
							?>
                                <div class="col-sm-6 col-md-4">
                                	
                                    <div class="thumbnail">
                                   		<div class="caption">
                                        	<h3>Nova Oferta</h3>
                                        </div>
                                        <img src="<?php baseurl( IMGOFERTAS . $row_minhasOferta['img']); ?>" alt="<?php echo $row_minhasOferta['titulo']; ?>" style="width:217px; height:147px">
                                        <div class="caption">
                                        	<h3><?php echo $row_minhasOferta['titulo']; ?></h3>
                                        	<p><span class="label label-success"><?php echo $row_minhasOferta['nomeFantasia']; ?></span></p>
                                            <?php 
											$Oferta = str_replace(" ","-", $row_minhasOferta['titulo']);
											$lojista = str_replace(" ","-", $row_minhasOferta['nomeFantasia']);
											$linkOferta = $lojista.'/ofertas/'.$Oferta;
											?>
                                        	<p><a href="<?php baseurl($linkOferta); ?>" class="btn btn-Oferapp" role="button"><span class="glyphicon glyphicon-eye-open"></span> ver mais...</a></p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                    	</div>
                    </div>
                </div>
                <div class=" col-md-3">
                	<ul class="nav nav-pills nav-stacked">
                    	<li><a href="<?php baseurl('usuario/perfil');?>">Editar perfil</a></li>
                    	<li><a href="<?php baseurl('usuario/configurar-acesso');?>">Configurações de acesso</a></li>
                        <li class="active"><a href="<?php baseurl('usuario/notificar');?>">Notificações</a></li>
                    	<li ><a href="<?php baseurl('usuario/minhas-ofertas');?>">Minhas Ofertas</a></li>
                        <li><a href="<?php baseurl('usuario/meus-presentes');?>">Meus Presentes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>