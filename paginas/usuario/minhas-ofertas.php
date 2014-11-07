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
				if($action == 'minhas-ofertas'){
					$perfilUser = 'Minhas ofertas';
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> <?php echo $perfilUser; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class=" col-md-9" style="text-align: center; border-right:1px #CCC solid;">
                <?php
					$minhasOfertas = "SELECT s.id, s.vendido, o.titulo, o.descricao, o.valor, o.img, u.img as imguser,u.nome,u.celular,u.email, l.id AS id_lojista, l.nomeFantasia FROM solicitacoes AS s INNER JOIN ofertas AS o ON o.id = s.id_oferta INNER JOIN lojista AS l ON l.id = s.id_lojista INNER JOIN usuario AS u ON u.id = s.id_cliente WHERE s.id_cliente =".$_SESSION['user_id'];
					$result_minhasOfertas = mysqli_query($dboferapp, $minhasOfertas);

				?>
                <div class="tab-content">
                    	<div class="tab-pane fade in active">
                            <div class="row">
                            <?php
							$totalrows_minhasOfertas = mysqli_num_rows($result_minhasOfertas);
							if($totalrows_minhasOfertas == 0){
								echo '<div class="alert alert-warning" role="alert">Não há solicitações de ofertas!</div>';
							}
							while($row_minhasOferta = mysqli_fetch_array($result_minhasOfertas)){
							?>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <img src="<?php baseurl( IMGOFERTAS . $row_minhasOferta['img']); ?>" alt="<?php echo $row_minhasOferta['titulo']; ?>" style="width:217px; height:147px">
                                        <div class="caption">
                                        	<h3><?php echo $row_minhasOferta['titulo']; ?></h3>
                                        	<p><?php if($row_minhasOferta['vendido'] == 'not'){echo '<span class="label label-success">Aguarde contato da Loja</span>';}else{ echo '<span class="label label-default">Comprado</span>';} ?></p>
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
                        <li><a href="<?php baseurl('usuario/notificar');?>">Notificações</a></li>
                    	<li class="active"><a href="<?php baseurl('usuario/minhas-ofertas');?>">Minhas Ofertas</a></li>
                        <li><a href="<?php baseurl('usuario/meus-presentes');?>">Meus Presentes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>