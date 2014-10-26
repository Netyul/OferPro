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
				if($action == 'meus-presentes'){
					$perfilUser = 'Presentes que estou concorrendo';
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> <?php echo $perfilUser; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class=" col-md-9" style="text-align: center; border-right:1px #CCC solid;">
                <?php
					$meusPresentes = "SELECT  g.cliks, g.datacadidatura, u.nome, u.email, u.sexo, u.celular, u.datanascimento, p.id AS idpre, p.titulo, p.descricao, p.img, p.id_lojista, l.nomeFantasia FROM ganharpresente AS g INNER JOIN usuario AS u ON u.id = g.id_usuario INNER JOIN presentes AS p ON p.id = g.id_presente INNER JOIN lojista AS l ON l.id = p.id_lojista WHERE g.id_usuario=".$_SESSION['user_id'];
					$result_meusPresentes = mysqli_query($dboferapp, $meusPresentes);

				?>
                <div class="tab-content">
                    	<div class="tab-pane fade in active">
                            <div class="row">
                            <?php
							$totalrows_meusPresentes = mysqli_num_rows($result_meusPresentes);
							if($totalrows_meusPresentes == 0){
								echo '<div class="alert alert-warning" role="alert">Você não se candidatou em nenhum presente!</div>';
							}
							while($row_meusPresentes = mysqli_fetch_array($result_meusPresentes)){
							?>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <img src="<?php baseurl( IMGPRESENTES . $row_meusPresentes['img']); ?>" alt="<?php echo $row_meusPresentes['titulo']; ?>" style="width:217px; height:147px">
                                        <div class="caption">
                                        	<h3><?php echo $row_meusPresentes['titulo']; ?></h3>
                                        	<p><span class="label label-default"><?php  echo $row_meusPresentes['cliks']; ?> <span class="glyphicon glyphicon-thumbs-up"></span></span></p>
                                            <?php 
											$Presentes = str_replace(" ","-", $row_meusPresentes['titulo']);
											$lojista = str_replace(" ","-", $row_meusPresentes['nomeFantasia']);
											$linkPresentes = $lojista.'/presentes/'.$Presentes;
											?>
                                        	<p><a href="<?php baseurl($linkPresentes); ?>" class="btn btn-Oferapp" role="button"><span class="glyphicon glyphicon-eye-open"></span> ver mais...</a></p>
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
                    	<li><a href="<?php baseurl('usuario/minhas-ofertas');?>">Minhas Ofertas</a></li>
                        <li class="active"><a href="<?php baseurl('usuario/meus-presentes');?>">Meus Presentes</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>