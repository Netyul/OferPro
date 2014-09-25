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

$colname_ganharpresentes = "-1";
if (isset($_SESSION['id_lojista'])) {
  $colname_ganharpresentes = $_SESSION['id_lojista'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_ganharpresentes = sprintf("SELECT * FROM presentes WHERE id_lojista = %s", GetSQLValueString($colname_ganharpresentes, "int"));
$ganharpresentes = mysql_query($query_ganharpresentes, $dboferapp) or die(mysql_error());
$row_ganharpresentes = mysql_fetch_assoc($ganharpresentes);
$totalRows_ganharpresentes = mysql_num_rows($ganharpresentes);

if ((isset($_GET['ganharpresente'])) && ($_GET['ganharpresente'] != "")) {
  $deleteSQL = sprintf("DELETE FROM ganharpresente WHERE id=%s",
                       GetSQLValueString($_GET['ganharpresente'], "int"));

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

<?php
mysql_free_result($ganharpresentes);
?>
