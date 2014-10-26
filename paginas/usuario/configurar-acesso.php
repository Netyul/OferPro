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
				if($action == 'configurar-acesso'){
					$perfil = 'Defina uma nova senha';
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> <?php echo $perfil; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class="col-md-9" style="text-align: center; border-right:1px #CCC solid;">
                	<div class="col-md-2">
                    </div>
                    <div class="col-md-8">
					<?php
                    $query_UserEdite = "SELECT * FROM usuario WHERE id = ".$_SESSION['user_id'];
					$UserEdite = mysqli_query($dboferapp,$query_UserEdite);
					$rows_UserEdite = mysqli_fetch_array($UserEdite);
					if(isset($_POST['editarUser']) && $_POST['editarUser'] =='editarUser'){
						$novaSenha    = mysqli_real_escape_string($dboferapp, $_POS['novaSenha']);
						$comfirmar    = mysqli_real_escape_string($dboferapp, $_POS['comfirmar']);
						if($novaSenha == $comfirmar ){
						$updadeSQL = "UPDATE lojista SET senha='".$novaSenha."'";
						$Result1 = mysqli_query($dboferapp, $updadeSQL);
							if($Result1){
								echo'<div class="alert alert-success" role="alert">Usuario editado com sucesso!</div>';
							}
							else{
								echo '<div class="alert alert-warning" role="alert">Não foi possivel finalizar edição!</div>';
							}
						}
						else{
						echo'<div class="alert alert-warning" role="alert">A senha Não Confere!</div>';
						}
						
					}
					?>
                   		<form method="post" action="<?php baseurl('usuario/configurar-acesso');?>" enctype="multipart/form-data" class="form-horizontal" style="margin-top:10%;">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nova Senha:</label>
                                <div class="col-sm-5">
                                 <input type="password" title="Digite a nova senha" class="form-control" name="novaSenha" required>
                                </div>
                              </div>
                               <div class="form-group">
                                <label class="col-sm-4 control-label">Confirmar Senha:</label>
                                <div class="col-sm-5">
                                 <input type="password" title="Digite a senha novamente" class="form-control" name="comfirmar" required>
                                </div>
                              </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                             </div>
                            <input type="hidden" name="editarUser" value="editarUser">
                            <input type="hidden" name="id" value="<?php echo $rows_UserEdite['id']; ?>">
                        </form>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
                <div class="col-md-3">
                	<ul class="nav nav-pills nav-stacked">
                    	<li class="active"><a href="<?php baseurl('usuario/perfil');?>">Editar perfil</a></li>
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