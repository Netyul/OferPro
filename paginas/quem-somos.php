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
            <div class="row ">
                <div class="col-md-8 quem-somos" style="text-align: justify; border-right:1px #CCC solid;">
                <p style="padding-top:60px;"><strong>A OferApp é uma plataforma que visa aproximar clientes e estabelecimentos por meio de ofertas, tablóides, presentes e uma variedade de recursos.</strong></p>
                <p><strong>Aqui você encontra as melhores ofertas e promoções que estão mais perto de você, além dos melhores estabelecimentos, você consegue solicitar e adquirir "em um mesmo lugar" produtos e serviços no atacado e varejo. Fácil, rápido e divertido, com apenas alguns cliques você tem a opção de obter tudo com um preço diferenciado. Concorre a presentes dos logistas e tem vantagens exclusivas! Antes de comprar, economize tempo e dinheiro, acessando a OferApp e suas ofertas irresistíveis.</strong></p>
                <p><strong>Para os nossos Clientes (lojistas), a OferApp proporciona uma maior visibilidade na internet, fideliza os clientes existentes, deixando todos conectados em busca de novas ofertas e presentes, em uma única plataforma, além de ajudar na prospecção de novos clientes, fornecer suporte completo é a nossa missão, deixando o seu comércio aquecido o ano inteiro.</strong></p>
                </div>
                <div class="col-md-4">
                	<ul class="nav nav-pills nav-stacked">
                    	<li><a href="contato">Contate-nos</a></li>
                    	<li class="active"><a href="quem-somos">Quem Somos</a></li>
                    	<li><a href="termos-de-uso">Termos de uso</a></li>
                        <li><a href="politica-de-privacidade">Política de privacidade</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>