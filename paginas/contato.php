<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da pagina CONTATO do sistema Oferapp.
 * versão 1.0
 */



require_once('skin/section.phtml');


/*-- record set --*/

$query_contato = "SELECT * FROM admin WHERE nome = 'Root'";
$resultado_contato = mysqli_query($dboferapp, $query_contato);
$row_emaildb = mysqli_fetch_array($resultado_contato);
$row_totalRows = mysqli_num_rows($resultado_contato);
?>

<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Contate-nos</h2>
            
            </div>
            <div class="row">
                <div class="col-md-8" style="border-right: 1px #CCC solid;">
                   
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading" itemprop="nome">Contate-nos</div>
                            <div class="panel-body">
                            <?php
							if(isset($_POST['enviarcontato']) && $_POST['enviarcontato'] == 'enviarcontato'){
										//recuperando formulario
										$nome       = $_POST['contato-nome'];
										$para       = $_POST['contato-email'];
										$tel        = $_POST['contato-tel'];
										$cel        = $_POST['contato-cel'];
										$assunto    = $_POST['contato-assunto'];
										$descricao  = $_POST['contato-descri'];
										$msgcontato = '<h3>Pedido de contato</h3>'.
												'<p>'.$nome.'</p>'.
												'<p>'.$email.'</p>'.
												'<p>'.$tel.'</p>'.
												'<p>'.$cel.'</p>'.
												'<p>'.$assunto.'</p>'.
												'<p>'.$descriacao.'</p>';
										
										
										
										$email = $row_emaildb['email'].', jefteamorim@gmail.com';
										$headers  = "From:". $para."\r\n";
       									$headers .= "Content-Type: text/html; charset=\"utf-8\"\n\n";
        
        								 mail($email, $assunto, $msgcontato, $headers );
										 if(mail){
											 echo'<ul class="list-group"><li class="list-group-item"><div class="alert alert-success" role="alert">Contato Enviado com sucesso!</div></li></ul></div>';
										 }
										 else{
										 	 echo'<ul class="list-group"><li class="list-group-item"><div class="alert alert-success" role="alert">Erro ao tentar enviar o Contato!</div></li></ul></div>'; 
										 }
										
										
									}else{
								?>
                            	 <form method="post" action="<?php baseurl('contato'); ?>" class="form-horizontal" role="form">
                                 	<div class="form-group">
                                        <label class="col-sm-2 control-label">Nome:</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="contato-nome" name="contato-nome" placeholder="Digite seu nome">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email:</label>
                                        <div class="col-sm-9">
                                        <input type="email" class="form-control"  id="contato-email" name="contato-email" placeholder="Digite seu email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Telefone:</label>
                                        <div class="col-sm-5">
                                        <input type="tel" size="10" class="form-control"  id="contato-tel" name="contato-tel" placeholder="Digite seu telefone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-sm-2 control-label">Celular:</label>
                                        <div class="col-sm-5">
                                        <input type="tel" size="11" class="form-control"  id="contato-cel" name="contato-cel" placeholder="Digite seu celular">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    	<label class="col-sm-2 control-label">Assunto:</label>
                                        <div class="col-sm-9">
                                        <input type="text" size="100" class="form-control"  id="contato-assunto" name="contato-assunto" placeholder="Digite o assunto">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                	Descrição
                                	</div>
                                    <div class="form-group">
                                    <div class="col-sm-12">
                                	<textarea class="form-control" id="contato-descri" name="contato-descri" placeholder="Digite sua mensagem"></textarea>
                                    <input type="hidden" name="enviarcontato" value="enviarcontato">
                                    </div>
                                	</div>
                               </div>
                            <div class="panel-footer"><button type="submit" class="btn btn-Oferapp" id="enviar" name="enviar">Enviar</button></div>
                        </div>
                        <?php
									}
						?>
                	</form>
                </div>
                <div class="col-md-4">
                	<ul class="nav nav-pills nav-stacked" role= "tablist">
                    	<li class="active"><a href="contato">Contate-nos</a></li>
                        <li><a href="quem-somos">Quem Somos</a></li>
                    	<li><a href="termos-de-uso">Termos de uso</a></li>
                        <li><a href="politica-de-privacidade">Política de privacidade</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>