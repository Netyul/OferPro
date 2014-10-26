<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo de cadastro do usuario do sistema oferapp
* Versão: 1.0
*/
if(isset($_POST['salvar'])){
	$termos = isset($_POST['termos']) ? $_POST['termos'] : false;
	$nome = mysqli_real_escape_string($dboferapp, trim($_POST['nome']));
	$email = $_POST['email'];
	$celular = $_POST['celular'];
	$data = $_POST['data'];
	$senhac = mysqli_real_escape_string($dboferapp,trim($_POST['senha']));
	$comSenha = $_POST['confirmar-senha'];
	$sexo = $_POST['sexo'];
	
	$email_query = "SELECT * FROM usuario";
	$emailResult = mysqli_query($dboferapp, $email_query);
	
	$dataNascimento = date('d/m/Y',strtotime($data));
	$dataAno = explode('/', $dataNascimento);
		while($emailRow = mysqli_fetch_array($emailResult)){
			if($email == $emailRow['email']){
				$comparaemail = $emailRow['email'];
			}
		}	
			
	if($termos){
		
		if(empty($nome)){
			$msgc ='<div class="alert alert-warning" role="alert">Por favor preencha seu Nome!</div>';
			
		}
		elseif(empty($email)){
			$msgc ='<div class="alert alert-warning" role="alert">Por favor informe um e-mail!</div>';
		}
		elseif(!preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/i", $email)){
			$msgc ='<div class="alert alert-warning" role="alert">Por favor informe um e-mail valido!</div>';
		}
		elseif($email == $comparaemail){
			$msgc ='<div class="alert alert-warning" role="alert">Este email já estar cadastrado!</div>';
		}
		elseif(empty($celular)){
			$msgc ='<div class="alert alert-warning" role="alert">Por favor informe um numero de celular!</div>';
		}
		elseif(empty($data)){
			$msgc ='<div class="alert alert-warning" role="alert">Por favor informe a data de nascimento!</div>';
		}
		elseif($dataAno[2] >= 2000){
			$msgc ='<div class="alert alert-warning" role="alert">A OferApp e um Sistema so para Maires de 15 anos!'.$dataNascimento.'</div>';
		}
		elseif(empty($senhac)){
			$msgc ='<div class="alert alert-warning" role="alert">Por favor informe sua senha!</div>';
		}
		elseif(empty($comSenha)){
			$msgc ='<div class="alert alert-warning" role="alert">Por favor confirme sua senha!</div>';
		}
		elseif($senhac != $comSenha){
			$msgc ='<div class="alert alert-warning" role="alert">Por favor a confirmação da sua senha e diferente!</div>';
		}
		else{
			$cadastro_query = "INSERT INTO usuario(nome, email, datanascimento, senha, celular, sexo, img) VALUES('".$nome."', '".$email."', '".$dataNascimento."', '".$senhac."', '".$celular."', '".$sexo."', '2e348c19733c81882d7da5527c0d.png')";
			$inserircadastro = mysqli_query($dboferapp, $cadastro_query);
			if($inserircadastro){
				$msgcsuccess ='<div class="alert alert-success" role="alert">cadastro efetuado com sucesso!</div>';
				$url->UrlJavaRedir(BASEURL.'/cadastro');
				$url->JavaRedir();
			}
			else{
				$msgc ='<div class="alert alert-warning" role="alert">Erro ao tentar cadastrar!</div>';
			}
		}
	}
	else{
		$msgc ='<div class="alert alert-warning" role="alert">Por favor aceite os termos da OferApp!</div>';
	}
	
	
}
if(isset($msgc)){ 
 	
 	echo '<script type="text/javascript">$(window).load(function() {
        $(".cadastrarUser").click();
    });</script>';

 }
 if(isset($msgcsuccess)){ 
 	
 	echo '<script type="text/javascript">$(window).load(function() {
        $("#modalUser").click();
    });</script>';

 }

?>
<!-- Modal -->
<div id="popup-cadastrar-usuario">
    <div class="modal fade" id="cadastrarUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cadastrar Novo Usuario</h4>
                </div>
                <div class="modal-body">
                <?php 
					
					if(!isset($msgcsuccess)){
						if(isset($msgc)){ echo $msgc;} 
						
					
					
					?>
                <form class="form-horizontal" role="form" method="post" action="">
                    	<div class="form-group">
                            <label for="nome" class="col-sm-4 control-label">Nome:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php if(isset($msgc)){ echo $nome;}?>" placeholder="">
                        	</div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email:</label>
                            <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="" value="<?php if(isset($msgc)){ echo $email;}?>">
                         	</div>
                         </div>
                         <div class="form-group">
                            <label for="celular" class="col-sm-4 control-label"> Celular:</label>
                            <div class="col-sm-4">
                            <input type="tel" size="13" class="form-control" id="celular" name="celular" placeholder="" value="<?php if(isset($msgc)){ echo $celular;}?>">
                            </div>
         				</div>
                         <div class="form-group">
                            <label for="nescimento" class="col-sm-4 control-label"> Data de Nascimento:</label>
                            <div class="col-sm-4">
                            <input type="date" class="form-control" id="data" name="data"  maxlength="10" min="1950-01-01" max="2000-01-01" placeholder="" value="<?php if(isset($msgc)){ echo $_POST['data'];}?>" v>
                            </div>
         				</div>
                        <div class="form-group">
                            <label for="senha" class="col-sm-4 control-label">Senha:</label>
                            <div class="col-sm-4">
                            <input type="password" class="form-control" id="senha" name="senha"  placeholder="" value="<?php if(isset($msgc)){ echo $senha;}?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cofirmar-senha" class="col-sm-4 control-label">comfirmar Senha:</label>
                            <div class="col-sm-4">
                            <input type="password" class="form-control" id="confirmar-senha" name="confirmar-senha"  placeholder="" value="<?php if(isset($msgc)){ echo $senha;}?>">
                            </div>       
                        </div>
                        <div class="form-group">
                            <label for="cofirmar-senha" class="col-sm-4 control-label">Sexo:</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="sexo" id="sexo">
                                <?php if(isset($msgc)){ echo'<option value="'.$sexo.'">'. $sexo.'</option>';}?>
                                  <option value="masculino">Masculino</option>
                                  <option value="feminino">Fenimino</option>
                                </select>
                            </div>       
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                <label>
                                	<input type="checkbox" name="termos" id="termos">Eu concordo com os termos
                                </label>
                                </div>
                            </div>
                    	</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary" name="salvar" id="salvar">Salvar</button>
                
                </div>
                </form>
                <?php
					}
					else{
						echo $msgcsuccess;
					}
					?>
            </div>
        </div>
    </div>
</div>
