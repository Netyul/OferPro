<?php require_once('../verificar-login.php');?>
<?php
$maxRows_RsLojistas = 15;
$pageNum_RsLojistas = 0;
if (isset($_GET['pageNum_RsLojistas'])) {
  $pageNum_RsLojistas = $_GET['pageNum_RsLojistas'];
}
$startRow_RsLojistas = $pageNum_RsLojistas * $maxRows_RsLojistas;

mysql_select_db($database_dboferapp, $dboferapp);
$query_RsLojistas = "SELECT * FROM lojista ORDER BY id ASC";
$query_limit_RsLojistas = sprintf("%s LIMIT %d, %d", $query_RsLojistas, $startRow_RsLojistas, $maxRows_RsLojistas);
$RsLojistas = mysql_query($query_limit_RsLojistas, $dboferapp) or die(mysql_error());
$row_RsLojistas = mysql_fetch_assoc($RsLojistas);


if (isset($_GET['totalRows_RsLojistas'])) {
  $totalRows_RsLojistas = $_GET['totalRows_RsLojistas'];
} else {
  $all_RsLojistas = mysql_query($query_RsLojistas);
  $totalRows_RsLojistas = mysql_num_rows($all_RsLojistas);
}
$totalPages_RsLojistas = ceil($totalRows_RsLojistas/$maxRows_RsLojistas)-1;


$queryString_RsLojistas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RsLojistas") == false && 
        stristr($param, "totalRows_RsLojistas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RsLojistas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RsLojistas = sprintf("&totalRows_RsLojistas=%d%s", $totalRows_RsLojistas, $queryString_RsLojistas);