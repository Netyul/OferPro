<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo de cadastro do usuario do sistema oferapp
* Versão: 1.0
*/
if(isset($_POST['submit']) && isset($_POST['termos']) && $_POST['submit'] == 'cadastrarParceiro' && $_POST['termos'] == true){
$query_contato = "SELECT * FROM admin WHERE nome = 'Root'";
$resultado_contato = mysqli_query($dboferapp, $query_contato);
$email_row = mysqli_fetch_assoc($resultado_contato);
$row_emaildb = mysqli_fetch_array($resultado_contato);
$row_totalRows = mysqli_num_rows($resultado_contato);

$nomeEmpresa       = $_POST['nomeParceiro'];
$cidadePerceiro    = $_POST['cidadePerceiro'];
$emailremetente    = trim($_POST['emailParceiro']);
$emaildestinatario = 'jefteamorim@gmail.com, '.$row_emaildb['email']; // Digite seu e-mail aqui, lembrando que o e-mail deve estar em seu servidor web
$celular     	   = $_POST['celularParceiro'];
$telefone      	   = $_POST['telefoneParceiro'];
$assunto           = "Pedido de cadastro de Parceiro";

 
 
/* Montando a mensagem a ser enviada no corpo do e-mail. */
$mensagemHTML = '<P>Pedido de cadastro de novos oarceiros revendedores</P>
<p><b>Nome:</b> '.$nomeParceiro.'
<p><b>E-Mail:</b> '.$emailremetente.'
<p><b>Cidade:</b> '.$cidadePerceiro.'
<p><b>Celular:</b> '.$celular.'
<p><b>Telefone:</b> '.$telefone.'
<hr>';
// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
// O return-path deve ser ser o mesmo e-mail do remetente.
$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: $emailremetente\r\n"; // remetente
$headers .= "Return-Path: $emaildestinatario \r\n"; // return-path
$envio = mail($emaildestinatario, $assunto, $mensagemHTML, $headers); 
 
 if($envio){
	$msgpsuccess ='<div class="alert alert-success" role="alert">cadastro efetuado com sucesso! Um dos nosso opradores entrara em contato com você.</div>'; // Página que será redirecionada
 }
}
if(isset($msgpsuccess)){ 
 	
 	echo '<script type="text/javascript">$(window).load(function() {
        $("#modalParceiro").click();
    });</script>';

 }
?>
<!-- Modal -->
<div id="popup-cadastrar-usuario">
    <div class="modal fade" id="cadastrarParceiro" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cadastro de Parceiro Revendedor</h4>
                </div>
                <div class="modal-body">
                <?php 
					
					if(isset($msgpsuccess)){
						echo $msgpsuccess;
						
					}
					else{
					
					?>
                <form class="form-horizontal" role="form" method="post" action="">
                    	<div class="form-group">
                            <label for="nome" class="col-sm-4 control-label">Nome:</label>
                            <div class="col-sm-6">
                            <input type="text" class="form-control" id="nome" name="nomeParceiro"  placeholder="" required />
                        	</div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email:</label>
                            <div class="col-sm-6">
                            <input type="email" class="form-control" id="email" name="emailParceiro" placeholder="Digite seu Email!" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
                         	</div>
                         </div>
                         <div class="form-group">
                            <label for="celular" class="col-sm-4 control-label"> Celular:</label>
                            <div class="col-sm-4">
                            <input type="tel" class="form-control" id="celularParceiro" name="celularParceiro" placeholder="Digite o numero do seu celular!" required pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$"/>
                            </div>
         				</div>
                         <div class="form-group">
                            <label for="nescimento" class="col-sm-4 control-label"> Telefone:</label>
                            <div class="col-sm-4">
                            <input type="tel" class="form-control" id="telefoneParceiro" name="telefoneParceiro" placeholder="Digite o numero de Telefone!" required pattern="\([0-9]{2}\)[0-9]{4}-[0-9]{4}$"/>
                            </div>
         				</div>
                        <div class="form-group">
                            <label for="senha" class="col-sm-4 control-label">Cidade:</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="cidadeParceiro" name="cidadeParceiro"  placeholder="Digite o nome de sua cidade com estado!" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                <label>Leia os termos clicando no link abaixo.<br />
                                	<input type="checkbox" name="termos" id="termos" required/><a href="#termos-de-uso" data-toggle="modal">Eu concordo com os termos</a> 
                                </label>
                                </div>
                            </div>
                    	</div>
                </div>
                <div class="modal-footer">
                	<input type="hidden" name="submit" value="cadastrarParceiro">
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
