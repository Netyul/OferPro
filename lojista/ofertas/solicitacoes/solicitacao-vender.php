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

$colname_socilitacoesVender = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_socilitacoesVender = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_socilitacoesVender = sprintf("SELECT * FROM solicitacoes WHERE id = %s", GetSQLValueString($colname_socilitacoesVender, "int"));
$socilitacoesVender = mysql_query($query_socilitacoesVender, $dboferapp) or die(mysql_error());
$row_socilitacoesVender = mysql_fetch_assoc($socilitacoesVender);
$totalRows_socilitacoesVender = mysql_num_rows($socilitacoesVender);
if(isset($colname_socilitacoesVender)){
$updateSQL = sprintf("UPDATE solicitacoes SET vendido=%s WHERE id_lojista=%s",
                       GetSQLValueString('yes', "text"),
                       GetSQLValueString($colname_socilitacoesVender, "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($updateSQL, $dboferapp) or die(mysql_error());

  $updateGoTo = "index.php?&action=vendido";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>

<?php
mysql_free_result($socilitacoesVender);
?>
