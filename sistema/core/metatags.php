<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Arquivo de metategs do sistema oferapp
* Versão: 1.0
*/
$pagina = isset( $urlAmigavel[0]) ? $urlAmigavel[0] : '';
$action = isset($urlAmigavel[1]) ? $urlAmigavel[1] : '';
$subaction =isset($urlAmigavel[2]) ? $urlAmigavel[2] : '';

$tituloQuery = "SELECT * FROM oferapp";
$ResultTags = mysqli_query($dboferapp, $tituloQuery);
$tagsOferapp = mysqli_fetch_array($ResultTags);

$query_cidadetag = "SELECT c.id, c.nome, e.sigla FROM cidade AS c INNER JOIN estado AS e ON c.id_uf = e.id ORDER BY c.id DESC";
$Result_cidadetag = mysqli_query($dboferapp, $query_cidadetag);
$row_total_row = mysqli_num_rows($Result_cidadetag);
while($row_cidadetag = mysqli_fetch_array($Result_cidadetag)){
						$cat_cidadetag = $row_cidadetag['nome'].'-'.$row_cidadetag['sigla'];
						if($pagina == $cat_cidadetag){
						$catCidadetag = $cat_cidadetag;
				
					}
				} 

$query_lojista = "SELECT * FROM lojista  ORDER BY id DESC";
		$Result_lojista = mysqli_query($dboferapp, $query_lojista);
		while($rows_lojista = mysqli_fetch_array($Result_lojista)){
			$lojista = str_replace(" ","-", $rows_lojista['nomeFantasia']);
			if($pagina == $lojista){
				$perfilLojista = $lojista;
			}
		}
		
if(!isset($pagina) || $pagina ==''){
	$tituloTag = $tagsOferapp['titulo']." - ".$tagsOferapp['slogan'];
	$TagsKeywords = $tagsOferapp['keywords'];
	$TagsDescription = $tagsOferapp['description'];
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];
}
elseif(isset($pagina) &&isset($catCidadetag) && $pagina == $catCidadetag){
	$tituloTag = $catCidadetag." - ".$tagsOferapp['titulo'];
	$TagsKeywords = 'ofertas da cidade '.$catCidadetag.', promoções da cidade '.$catCidadetag.', presentes da cidade '.$catCidadetag.', tabloides da cidade '.$catCidadetag;
	$TagsDescription = 'Ofertas, pomoções e presentes da cidade '.$catCidadetag.' aproveite e solicite já! e não deiche passar essa oportunidade';
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];
}
elseif(isset($pagina) && isset($perfilLojista) && $pagina == $perfilLojista){
	$tituloLojista = str_replace("-"," ", $perfilLojista);
	$tituloTag = $tituloLojista." - ".$tagsOferapp['titulo'];
	$TagsKeywords = 'ofertas '.$tituloLojista.', promoções '.$tituloLojista.', presentes '.$tituloLojista.', tabloides '.$tituloLojista;
	$TagsDescription = 'O Lojista '.$tituloLojista.' tem ofertas, promoções, presentes e tabloides incriveis para você conferir não perca!' ;
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];			
}
elseif(isset($pagina) && $pagina =='busca'){
	$tituloTag = "Busca - ".$tagsOferapp['titulo'];
	$TagsKeywords = '';
	$TagsDescription = 'pagina para encontrar os melhores serviços da oferapp, faça ja sua busca en nosso sistema' ;
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];		
}
elseif(isset($pagina) && $pagina =='politica-de-privacidade'){
	$tituloTag = "Politica de privacidade - ".$tagsOferapp['titulo'];
	$TagsKeywords = '';
	$TagsDescription = 'O trabalho OferApp de Nathan Selma Gomes e da Agencia Digital Netyul está licenciado com uma Licença Creative Commons - Atribuição-NãoComercial-SemDerivações 4.0 Internacional. Baseado no trabalho disponível em http://www.oferapp.com.br. Podem estar disponíveis autorizações adicionais às concedidas no âmbito desta licença' ;
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];		
}
elseif(isset($pagina) && $pagina =='quem-somos'){
	$tituloTag = "Quem somos - ".$tagsOferapp['titulo'];
	$TagsKeywords = '';
	$TagsDescription = 'A OferApp é uma plataforma que visa aproximar clientes e estabelecimentos por meio de ofertas, tabloides e presentes.' ;
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];		
}
elseif(isset($pagina) && $pagina =='contato'){
	$tituloTag = "Contato - ".$tagsOferapp['titulo'];
	$TagsKeywords = '';
	$TagsDescription = 'area resenrvada para contato de clientes e futuros anunciantes do sistema oferapp. caso tenha interece nesse quisito contate-nos.' ;
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];		
}else{
	$tituloTag = $tagsOferapp['titulo'];
	$TagsKeywords = '';
	$TagsDescription = '' ;
	$tagsGeneration = $tagsOferapp['generation'];
	$tagsAutor = $tagsOferapp['autor'];		
}