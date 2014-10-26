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
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Quem Somos</h2>
            
            </div>
            <div class="row">
                <div class="col-md-8" style="text-align:left; border-right:1px #CCC solid;">
                <p style="padding-top:60px;">A OferApp é uma plataforma que visa aproximar clientes e estabelecimentos por meio de ofertas, tabloides e presentes. </p>
                <p>Aqui você encontra os melhores estabelecimentos e consegue solicitar com apenas alguns cliques. Fácil, rápido e divertido!</p>
                <p>Para os nossos Clientes, a OferApp proporciona uma maior visibilidade na internet, ajudando na prospecção de novos clientes, além de fornecer um Suporte completo.</p>
                </div>
                <div class="col-md-4">
                	<ul class="nav nav-pills nav-stacked">
                    	<li><a href="contato">contate-nos</a></li>
                    	<li class="active"><a href="quem-somos">Quem Somos</a></li>
                    	<li><a href="#">Termos de uso</a></li>
                        <li><a href="politica-de-privacidade">Política de privacidade</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>