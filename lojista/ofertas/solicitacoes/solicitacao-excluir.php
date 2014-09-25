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

$colname_Recordset1 = "-1";
if (isset($_GET['solicitacao'])) {
  $colname_Recordset1 = $_GET['solicitacao'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_Recordset1 = sprintf("SELECT * FROM solicitacoes WHERE id = %s AND id_lojista=%s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $dboferapp) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ((isset($_GET['solicitacao'])) && ($_GET['solicitacao'] != "")) {
  $deleteSQL = sprintf("DELETE FROM solicitacoes WHERE id=%s",
                       GetSQLValueString($_GET['solicitacao'], "int"),
					   GetSQLValueString($_SESSION['id_lojista'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($deleteSQL, $dboferapp) or die(mysql_error());

  $deleteGoTo = "index.php?action=excluido";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
$colname_solicitacao = "-1";
if (isset($_GET['solicitacao2'])) {
  $colname_solicitacao = $_GET['solicitacao2'];
}
mysql_select_db($database_dboferapp, $dboferapp);
$query_solicitacao  = sprintf("SELECT * FROM solicitacoes WHERE id = %s AND id_lojista=%s", GetSQLValueString($colname_solicitacao, "int"));
$solicitacao = mysql_query($query_solicitacao, $dboferapp) or die(mysql_error());
$row_solicitacao = mysql_fetch_assoc($solicitacao);
$totalRows_solicitacao = mysql_num_rows($solicitacao);

if ((isset($_GET['solicitacao2'])) && ($_GET['solicitacao2'] != "")) {
  $deleteSQL = sprintf("DELETE FROM solicitacoes WHERE id=%s",
                       GetSQLValueString($_GET['solicitacao2'], "int"),
					    GetSQLValueString($_SESSION['id_lojista'], "int"));

  mysql_select_db($database_dboferapp, $dboferapp);
  $Result1 = mysql_query($deleteSQL, $dboferapp) or die(mysql_error());

  $deleteGoTo = "solicitacoes-vendidas.php?action=excluido";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

?>
<?php
mysql_free_result($Recordset1);
?>
