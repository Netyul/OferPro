<?php require_once('../verificar-login.php');?>
<?php require_once('../../Connections/dboferapp.php'); ?>
<?php
require_once('../../sistema/classes/W3_Image.class.php');
require_once('../../sistema/constantes.php');

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

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
	
	mysql_select_db($database_dboferapp, $dboferapp);
	$query_delete = printf("SELECT * FROM lojista WHERE id = %s", GetSQLValueString($_GET['id'], 'int'));
	$deleteLojista = mysql_query($query_delete, $dboferapp);
	$row_deleteLogista = mysql_fetch_assoc($deleteLojista);
	
	$imagetype = explode('.', $row_deleteLogista['img']);
	$thumbImg  = $imagetype[0]. '.thumb.' . $imagetype[1];
	$imgperfil = IMGPERFIL;
	$deleteImg = new W3_Image;
	$deleteImg->delete('../../'.$imgperfil.$row_deleteLogista['img']);
	$deleteImg->delete('../../'.$imgperfil.$thumbImg);
	
  $deleteSQL = sprintf("DELETE FROM lojista WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));
	
  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($deleteSQL, $dboferapp) or die(mysql_error());

  $deleteGoTo = "index.php?action=excluido";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>

