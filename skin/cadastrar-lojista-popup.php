<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo de cadastro do usuario do sistema oferapp
* Versão: 1.0
*/
if(isset($_POST['submit']) && isset($_POST['termos']) && $_POST['submit'] == 'cadastrarLojista' && $_POST['termos'] == true){
$nomeEmpresa       = $_POST['nomeEmpresa'];
$cpf               = $_POST['cpf'];
$cnpj               = $_POST['cnpj'];
$nomeResponsavel   = $_POST['nomeResponsavel'];
$emailremetente    = trim($_POST['emailLojista']);
$emaildestinatario = 'jefteamorim@gmail.com'; // Digite seu e-mail aqui, lembrando que o e-mail deve estar em seu servidor web
$celular     	   = $_POST['celularLojista'];
$telefone      	   = $_POST['telefoneLojista'];
$cidadeLojista     = $_POST['cidadeLojista'];
$assunto           = "Pedido de cadastro de Lojista";

 
 
/* Montando a mensagem a ser enviada no corpo do e-mail. */
$mensagemHTML = '<P>Pedido de cadastro de novos estabelecimentos comerciais</P>
<p><b>Nome:</b> '.$nomeEmpresa.'
<p><b>CPF:</b> '.$cpf.'
<p><b>CNPJ:</b> '.$cnpj.'
<p><b>Nome:</b> '.$nomeResponsavel.'
<p><b>E-Mail:</b> '.$emailremetente.'
<p><b>Celular:</b> '.$celular.'
<p><b>Telefone:</b> '.$telefone.'
<p><b>Cidade:</b> '.$cidadeLojista.'
<hr>';
// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
// O return-path deve ser ser o mesmo e-mail do remetente.
$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: $emailremetente\r\n"; // remetente
$headers .= "Return-Path: $emaildestinatario \r\n"; // return-path
$envio = mail($emaildestinatario, $assunto, $mensagemHTML, $headers); 
 
 if($envio){
	$msglsuccess ='<div class="alert alert-success" role="alert">cadastro efetuado com sucesso! Um dos nosso opradores entrara em contato com você.</div>'; // Página que será redirecionada
 }
}
if(isset($msglsuccess)){ 
 	
 	echo '<script type="text/javascript">$(window).load(function() {
        $("#modalLojista").click();
    });</script>';

 }
?>
<!-- Modal -->
<div id="popup-cadastrar-usuario">
    <div class="modal fade" id="cadastrarLojista" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cadastro de Novos Estabelecimentos Comerciais</h4>
                </div>
                <div class="modal-body">
                <?php 
                if(isset($msglsuccess)){
						echo $msglsuccess;
						
				}
					else{	
					
				?>
                <form class="form-horizontal" role="form" method="post" action="">
                		 <div class="form-group">
                            <label class="col-sm-4 control-label">Tipo do Lojista:</label>
                            <div class="col-sm-4">
                            	<select name="tipoLojista" class="form-control" id="tipoLojista">
                              		<option value="Fisica">Fisica</option>
                              		<option value="Juridica">Juridica</option>
                            	</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label">CPF:</label>
                            <div class="col-sm-5">
                            <input class="form-control" title="Digite um CPF valido exemplo 111.111.111-11" placeholder="Digite seu CPF!" type="text" name="cpf" pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{3}-[0-9]{2}$" required />
                          </div>
                          </div>
                          <div class="form-group" id="cnpj" style="display:none">
                            <label class="col-sm-4 control-label">CNPJ:</label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="cnpj" placeholder="Digite o CNPJ!" title="Digite um CNPJ valido exemplo 11.111.111/0001-01" >
                          </div>
                          </div>
                          
                           <script type="text/javascript">
								
                             
							$(document).ready(function(){
								var valor = $("#tipoLojista").val();
                                 if(valor == "Juridica"){
										$("div#cnpj").show();
										
                                          	$("div#cnpj input").attr({"required" : "required"});
											$("div#cnpj input").attr({
											"pattern":"\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$",
											});  
                                        
									}else{
										$("div#cnpj").hide();
										$("div#cnpj input").attr({"value":"nenhum CNPJ!"});
										$("div#cnpj input").removeAttr("pattern");
										$("div#cnpj input").removeAttr("required");
									}   
								
								$("#tipoLojista").blur(function(){
									var valor = $(this).val();
									if(valor == "Juridica"){
										$("div#cnpj").show();
										$("div#cnpj input").attr("required");
										$("div#cnpj input").attr({
											"pattern":"\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$",
											});
									}else{
										$("div#cnpj").hide();
										$("div#cnpj input").attr({"value":"nenhum CNPJ!"});
										$("div#cnpj input").removeAttr("pattern");
										$("div#cnpj input").removeAttr("required");
									}
									});
                                    
                            });
						  </script>
                    	<div class="form-group">
                            <label for="nome" class="col-sm-4 control-label">Nome empresa:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" id="nomeEmpresa" name="nomeEmpresa"  placeholder="Digite o nome da empresa!" required/>
                        	</div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email:</label>
                            <div class="col-sm-6">
                            <input type="email" class="form-control" id="emailLojista" name="emailLojista" placeholder="digite um Email!" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                         	</div>
                         </div>
                         <div class="form-group">
                            <label for="nome" class="col-sm-4 control-label">Nome responsavel:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" id="nomeResponsavel" name="nomeResponsavel"  placeholder="Digite o nome do responsavel!" required />
                        	</div>
                        </div>
                         <div class="form-group">
                            <label for="celular" class="col-sm-4 control-label"> Celular:</label>
                            <div class="col-sm-4">
                            <input type="tel" size="13" class="form-control" id="celularLojista" name="celular" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$" placeholder="Digite um numero de celular!" required />
                            </div>
         				</div>
                        <div class="form-group">
                            <label for="celular" class="col-sm-4 control-label"> Telefone:</label>
                            <div class="col-sm-4">
                            <input type="tel" size="13" class="form-control" id="telefonelojista" name="telefonelojista" pattern="\([0-9]{2}\)[0-9]{4}-[0-9]{4}$" placeholder="Digite um numero de telefone!" required />
                            </div>
         				</div>
                        <div class="form-group">
                            <label for="senha" class="col-sm-4 control-label">Cidade:</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="cidadeLojista" name="cidadeLojista"  placeholder="Digite o nome de sua cidade com estado!" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                <label>
                                	<input type="checkbox" name="termos" id="termos" required/> <a href="termos">Eu concordo com os termos</a>                                </label>
                                </div>
                            </div>
                    	</div>
                </div>
                <div class="modal-footer">
                	<input type="hidden" name="submit" value="cadastrarLojista">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary" name="salvar" id="salvar">Salvar</button>
                
                </div>
                </form>
                <?php
					
						
					}
					?>
            </div>
        </div>
    </div>
</div>
