<?php require_once('../verificar-login.php');?>
<?php require_once('../../Connections/dboferapp.php'); ?>
<?php
require_once('../../sistema/classes/W3_Image.class.php');
require_once('../../sistema/constantes.php');
?>
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


$colname_excluirTabloide = "-1";
if (isset($_GET['tabloide'])) {
  $colname_excluirTabloide = $_GET['tabloide'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_excluirTabloide = sprintf("SELECT * FROM tabloide WHERE id = %s", GetSQLValueString($colname_excluirTabloide, "int"));
$excluirTabloide = mysql_query($query_excluirTabloide, $dboferapp) or die(mysql_error());
$row_excluirTabloide = mysql_fetch_assoc($excluirTabloide);
$totalRows_excluirTabloide = mysql_num_rows($excluirTabloide);

if ((isset($_GET['tabloide'])) && ($_GET['tabloide'] != "")) {
	
	$imagetype = explode('.', $row_excluirTabloide['img']);
	$thumbImg  = $imagetype[0]. '.thumb.' . $imagetype[1];
	$imgperfil = IMGTABLOIDE;
	$deleteImg = new W3_Image;
	$deleteImg->delete('../../'.$imgperfil.$row_excluirTabloide['img']);
	$deleteImg->delete('../../'.$imgperfil.$thumbImg);
	
  $deleteSQL = sprintf("DELETE FROM tabloide WHERE id=%s",
                       GetSQLValueString($_GET['tabloide'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($deleteSQL, $dboferapp) or die(mysql_error());

  $deleteGoTo = "tabloides.php?id=" . $row_excluirTabloide['id_lojista'] . "&action=excluido";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

?>
<?php
mysql_free_result($excluirTabloide);
?>
