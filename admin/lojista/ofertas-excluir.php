<?php require_once('../verificar-login.php');?>
<?php require_once('../../Connections/dboferapp.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
require_once('../../sistema/classes/W3_Image.class.php');
require_once('../../sistema/constantes.php');

$colname_excluirOferta = "-1";
if (isset($_GET['oferta'])) {
  $colname_excluirOferta = $_GET['oferta'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_excluirOferta = sprintf("SELECT * FROM ofertas WHERE id = %s", GetSQLValueString($colname_excluirOferta, "int"));
$excluirOferta = mysql_query($query_excluirOferta, $dboferapp) or die(mysql_error());
$row_excluirOferta = mysql_fetch_assoc($excluirOferta);
$totalRows_excluirOferta = mysql_num_rows($excluirOferta);

if ((isset($_GET['oferta'])) && ($_GET['oferta'] != "")) {
	
	$imagetype = explode('.', $row_excluirOferta['img']);
	$thumbImg  = $imagetype[0]. '.thumb.' . $imagetype[1];
	$imgperfil = IMGOFERTAS;
	$deleteImg = new W3_Image;
	$deleteImg->delete('../../'.$imgperfil.$row_excluirOferta['img']);
	$deleteImg->delete('../../'.$imgperfil.$thumbImg);
	
  $deleteSQL = sprintf("DELETE FROM ofertas WHERE id=%s",
                       GetSQLValueString($_GET['oferta'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($deleteSQL, $dboferapp) or die(mysql_error());

  $deleteGoTo = "ofertas.php?id=" . $row_excluirOferta['id_lojista'] . "&action=excluido";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

?>
<?php
mysql_free_result($excluirOferta);
?>
