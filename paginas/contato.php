<?php 
/* 
 * Oferapp < http://www.netyul.com.br/ >.
 * Autor: Jefte Amorim da Costa
 * aquivo que contem o Conteudo da pagina CONTATO do sistema Oferapp.
 * versão 1.0
 */



require_once('skin/section.phtml');


/*-- record set --*/

$query_contato = "SELECT email FROM oferapp";
$resultado_contato = mysqli_query($dboferapp, $query_contato);
$email_row = mysqli_fetch_assoc($resultado_contato);
$row_emaildb = mysqli_fetch_array($resultado_contato);
$row_totalRows = mysqli_num_rows($resultado_contato);
?>
<main>
    <div class="container">
        <div class="area inicial">
            <div class="top page-header">
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span>Contato </h2>
            
            </div>
            <div class="row">
                <div class="col-md-8">
                    <form method="post" action="<?php baseurl('contato-oferapp'); ?>">
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading" itemprop="nome">Contate-nos</div>
                            <div class="panel-body">
                            	<p itemprop="description">Essa Formulario e destinado para os Clientes que queiram tirar Duvidas sobr o sistema, e pedir suporte para Cadastros de novas ofertas, sorteios, e tabloides! </p>
                            </div>
                            <!-- List group -->
                            <?php
									if(isset($_POST['enviar'])){
										//recuperando formulario
										$nome      = $_POST['contato-nome'];
										$para     = $_POST['contato-email'];
										$tel       = $_POST['contato-tel'];
										$cel       = $_POST['contato-cel'];
										$assunto   = $_POST['contato-assunto'];
										$descricao = $_POST['contato-descri'];
										$msg = '<p>'.$nome.'</p>'.
												'<p>'.$email.'</p>'.
												'<p>'.$tel.'</p>'.
												'<p>'.$cel.'</p>'.
												'<p>'.$assunto.'</p>'.
												'<p>'.$descriacao.'</p>';
										
										
										while($row_emaildb = mysqli_fetch_array($resultado_contato)){
											$email = $row_emaildb['email'];
										}
										$headers  = "From:". $para."\r\n";
       									$headers .= "Content-Type: text/html; charset=\"utf-8\"\n\n";
        
        								 mail($email, $assunto, $msg, $headers );
										 if(mail){
											 echo'<ul class="list-group"><li class="list-group-item"><div class="alert alert-success" role="alert">Contato Enviado com sucesso!</div></li></ul><div class="panel-footer"></div></div>';
										 }
										 else{
										 	 echo'<ul class="list-group"><li class="list-group-item"><div class="alert alert-success" role="alert">Erro ao tentar enviar o Contato!</div></li></ul><div class="panel-footer"></div></div>'; 
										 }
										
										
									}else{
								?>
                            <ul class="list-group">
                                <li class="list-group-item">
                                	<div class="input-group">
                                        <span class="input-group-addon">Nome:</span>
                                        <input type="text" class="form-control"  id="contato-nome" name="contato-nome" placeholder="Digite seu nome">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                	<div class="input-group">
                                        <span class="input-group-addon">Email:</span>
                                        <input type="email" class="form-control"  id="contato-email" name="contato-email" placeholder="Digite seu email">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                <div class="input-group">
                                        <span class="input-group-addon">Telefone:</span>
                                        <input type="tel" size="10" class="form-control"  id="contato-tel" name="contato-tel" placeholder="Digite seu telefone">
                                        
                                    </div>
                                </li>
                                <li class="list-group-item">
                                	<div class="input-group">
                                    	<span class="input-group-addon">Celular:</span>
                                        <input type="tel" size="11" class="form-control"  id="contato-cel" name="contato-cel" placeholder="Digite seu Celular">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                	<div class="input-group">
                                    	<span class="input-group-addon">Celular:</span>
                                        <input type="text" size="100" class="form-control"  id="contato-assunto" name="contato-assunto" placeholder="Digite o Assunto">
                                    </div>
                                </li>
                                <li class="list-group-item">
                                	Descrição
                                </li>
                                <li class="list-group-item">
                                	<textarea class="form-control" id="contato-descri" name="contato-descri" placeholder="Digite sua mensagem"></textarea>
                                </li>
                            </ul>
                            <div class="panel-footer"><input type="submit" class="btn btn-Oferapp" value="Enviar" id="enviar" name="enviar"></div>
                        </div>
                        <?php
									}
						?>
                	</form>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
</main>