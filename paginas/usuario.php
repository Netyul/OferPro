<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/
 require_once('sistema/core/verificar-login.php');
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
	if(isset($pagina) && isset($action) && $action =='configurar-acesso'){
		require_once('paginas/usuario/configurar-acesso.php');
	}
	elseif(isset($pagina) && isset($action) && $action =='notificar'){
		require_once('paginas/usuario/notificar.php');
	}
	elseif(isset($pagina) && isset($action) && $action =='minhas-ofertas'){
		require_once('paginas/usuario/minhas-ofertas.php');
	}
	elseif(isset($pagina) && isset($action) && $action =='meus-presentes'){
		require_once('paginas/usuario/meus-presentes.php');
	}
	elseif(isset($pagina) && isset($action) && $action =='perfil'){
		require_once('paginas/usuario/perfil.php');
	}
	elseif(isset($pagina) && empty($action) && $pagina == 'usuario'){
?>
<?php require_once('skin/section.phtml'); ?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            <?php 
				if($pagina == 'usuario'){
					$perfilUser = 'Perfil - '. $_SESSION['usuario'];
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> <?php echo $perfilUser; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class=" col-md-9" style="text-align: center; border-right:1px #CCC solid;">
                <?php 
					$query_perfil = "SELECT * FROM usuario WHERE id =". $_SESSION['user_id'];
					$userPerfil = mysqli_query($dboferapp, $query_perfil);
					$userPerfil_row = mysqli_fetch_array($userPerfil);
				?>
                	<div class="tab-content">
                    	<div class="tab-pane fade in active">
                			<div class="row">
                    			<div class="col-xs-4">
                                	<img src="<?php if($userPerfil_row['img'] != ''){ echo IMGPERFIL .$userPerfil_row['img'];}else{echo IMGPERFIL.'tabloide.jpg';} ?>">
                        		</div>
                        		<div class="col-xs-8">
                                	<form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Nome:</label>
                                            <div class="col-sm-5" align="left">
                                            	<label class="control-label"><?php echo $userPerfil_row['nome']; ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Email:</label>
                                            <div class="col-sm-5" align="left">
                                            	<label class="control-label"><?php echo $userPerfil_row['email']; ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Data de Nascimento:</label>
                                            <div class="col-sm-5" align="left">
                                            	<label class="control-label"><?php echo $userPerfil_row['datanascimento']; ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Celular:</label>
                                            <div class="col-sm-5" align="left">
                                            	<label class="control-label"><?php echo $userPerfil_row['celular']; ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">Sexo:</label>
                                            <div class="col-sm-5" align="left">
                                            	<label class="control-label"><?php echo $userPerfil_row['sexo']; ?></label>
                                            </div>
                                        </div>
                                    </form>
                        		</div>
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
                        <li><a href="<?php baseurl('usuario/meus-presentes');?>">Meus Presentes</a></li>
                    </ul>
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
}			

?>