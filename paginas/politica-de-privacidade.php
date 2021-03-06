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
            	<h2>  <span class="glyphicon glyphicon-bookmark icon-destaque"></span> Políticas de Privacidade</h2>
            
            </div>
            <div class="row">
                <div class="col-md-8" style="text-align: justify; border-right:1px #CCC solid; background-color: rgba(186, 216, 184, 0.25)">
                <p style="padding-top:0px;"><p><br />
                  <a style="padding:0px;" class="btn btn-link" rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licença Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a><br /><br />
                  O trabalho <span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/InteractiveResource" property="dct:title" rel="dct:type">OferApp</span> 
                  de <a  xmlns:cc="http://creativecommons.org/ns#" href="http://www.oferapp.com.br" property="cc:attributionName" rel="cc:attributionURL">Nathan 
                  Selma Gomes</a> e da <a  href="http://www.netyul.com.br/">Agência Digital Netyul</a> está licenciado com uma Licença: <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
                  Creative Commons - Atribuição-NãoComercial-SemDerivações 4.0 Internacional</a>. Baseado no trabalho disponível em <a xmlns:dct="http://purl.org/dc/terms/" href="http://www.oferapp.com.br" rel="dct:source">http://www.oferapp.com.br</a>.<br /><br />
                  Podem estar disponíveis autorizações adicionais às concedidas no âmbito desta licença com <a xmlns:cc="http://creativecommons.org/ns#" href="https://www.facebook.com/nathanselmagomes" rel="cc:morePermissions">Nathan Selma Gomes</a>. 
                  </p>
                  </p>
                  </div>
                <div class="col-md-4">
                	<ul class="nav nav-pills nav-stacked">
                    	<li><a href="contato">Contate-nos</a></li>
                    	<li ><a href="quem-somos">Quem Somos</a></li>
                    	<li><a href="termos-de-uso">Termos de uso</a></li>
                        <li class="active"><a href="politica-de-privacidade">Política de privacidade</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>