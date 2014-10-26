<?php
/*
* OferApp < http://www.netyul.com.br >
* Autor: Jefte Amorim da Costa
* Design:
* Arquivo
* Versão: 1.0
*/
$lojista = str_replace("-"," ", $perfilLojista);
$query_lojista = "SELECT * FROM lojista WHERE nomeFantasia ='".$lojista."' ORDER BY id DESC";
$Result_lojista = mysqli_query($dboferapp, $query_lojista);
$rows_lojista = mysqli_fetch_array($Result_lojista);

$query_lojistaOfertas = "SELECT * FROM presentes WHERE id_lojista =".$rows_lojista['id']." ORDER BY id DESC";
$Result_lojistaOfertas = mysqli_query($dboferapp, $query_lojistaOfertas);
while($rows_lojistaOfertas = mysqli_fetch_array($Result_lojistaOfertas)){
	$lojistaOfertas = str_replace(" ","-", $rows_lojistaOfertas['titulo']);
	if($subaction == $lojistaOfertas){
				$perfilLojistaOfertas = $lojistaOfertas;
	}
}

if(isset($pagina) && isset($action) && isset($perfilLojistaOfertas) && $subaction == $perfilLojistaOfertas){
	require_once('paginas/lojistaPresentesVisual.php');
}
elseif(isset($pagina) && isset($action) && $action == 'presentes' && empty($subaction)){
		
		$url->UrlJavaRedir(baseurl($pagina));
		$url->JavaRedir();
?>
<?php } ?>