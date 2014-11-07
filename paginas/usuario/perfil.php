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
				if($action == 'perfil'){
					$perfil = 'Edite seu perfil';
			?>
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span><?php echo $perfil; ?></h2>
            <?php }?>
            </div>
            <div class="row">
                <div class="col-md-9" style="text-align: center; border-right:1px #CCC solid;">
                <?php 
				require_once('sistema/classes/W3_Image.class.php');

				
				$query_UserEdite = "SELECT * FROM usuario WHERE id = ".$_SESSION['user_id'];
				$UserEdite = mysqli_query($dboferapp,$query_UserEdite);
				$rows_UserEdite = mysqli_fetch_array($UserEdite);
				
				if(isset($_POST['editarUser']) && $_POST['editarUser'] =='editarUser'){
					$sqlquery = "SELECT * FROM usuario WHERE email = '".$_POST['emailUser']."'";
					$sqlResult = mysqli_query($dboferapp, $sqlquery);
					$sqlrows = mysqli_num_rows($sqlResult);
					
					if($sqlrows != 0){
						$nomeUser    = mysqli_real_escape_string($dboferapp, $_POS['nomeUser']);
						$emailUser   = mysqli_real_escape_string($dboferapp, $_POS['emailUser']);
						$celularUser = $_POST['celularUser'];
						$data        = $_POST['datanascimento'];
						$sexoUser    = $_POST['sexoUser'];
						$imagemTemp  = $_FILES['img']['tmp_name'];
						$imagetype   = explode('/', $_FILES['img']['type']);
						if($imagetype[1] =='jpeg'){
							$imagetype[1] = 'jpg';
						}
						if(!empty($imagemTemp)){
							$strKey    = substr(md5(uniqid(microtime())),0, 28);
							$imgperfil = IMGPERFIL;
							$editeImg = explode('.',$rows_UserEdite['img']);
							$img = new W3_Image();
							$img->create($imagemTemp, 570, 450,''.$imgperfil. $editeImg[0].$strKey.'.'. $imagetype[1]);
							
						}
						$imgUser = $editeImg[0].$strKey.'.'.$imagetype[1];
						
						$updadeSQL = "UPDATE lojista SET nome='".$nomeUser."', email='".$emailUser."', datanascimento='".$data."' , celular='".$celularUser."' , sexo='".$sexoUser."', img='".$imgUser."' WHERE id=".$_POST['id'];
						$Result1 = mysqli_query($dboferapp, $updadeSQL);
						if(isset($Result1)){
							$msgEditeUser ='<div class="alert alert-success" role="alert">Usuario editado com sucesso!</div>';
						}
						else{
							$msgEditeUser ='<div class="alert alert-warning" role="alert">Não foi possivel finalizar edição!</div>';
						}
					}
					else{
						$msgEditeUser ='<div class="alert alert-warning" role="alert">Este email já foi cadastrado!</div>';
					}
				}
				?>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                    <?php 
					if(isset($msgEditeUser)){
						echo $msgEditeUser;
					}
					
					 ?>
                    	<form method="post" action="<?php baseurl('usuario/perfil');?>" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nome:</label>
                            <div class="col-sm-8">
                             <input type="text" title="Digite o nome da empresa" class="form-control" name="nomeUser" value="<?php echo $rows_UserEdite['nome']; ?>" required>
                          	</div>
                          </div>
                           <div class="form-group">
                            <label class="col-sm-4 control-label">Email:</label>
                            <div class="col-sm-8">
                            	<input type="email" title="Digite um Email valido" class="form-control" name="emailUser" value="<?php echo $rows_UserEdite['email']; ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                          	</div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Celular:</label>
                            <div class="col-sm-4">
                            <input class="form-control" type="tel" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$" name="celularUser" value="<?php echo $rows_UserEdite['celular']; ?>" required>
                          </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Data de nescimento:</label>
                            <div class="col-sm-4">
                            <input class="form-control" type="date" required maxlength="10" name="datanascimento" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" max="2000-01-01"  value="<?php echo $rows_UserEdite['datanascimento']; ?>" />
                          </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">Sexo:</label>
                            <div class="col-sm-4">
                            	<select name="sexoUser" class="form-control" id="sexoUser">
                              		<option value="feminino" <?php if (!(strcmp("feminino", htmlentities($rows_UserEdite['sexo'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>feminino</option>
                              		<option value="masculino" <?php if (!(strcmp("masculino", htmlentities($rows_UserEdite['sexo'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Masculino</option>
                            	</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Imagem:</label>
                            <div class="col-sm-6" align="left">
                            	<input type="file" name="img" id="file-original" required>
                                <button  type="button" class="btn btn-Oferapp" onclick="this.form.img.click()"><span class="glyphicon glyphicon-picture"></span> Procurar...</button>
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