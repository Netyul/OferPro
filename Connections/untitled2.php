<?php
// *** Logout the current user.
$logoutGoTo = BASEURL;
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['Usuario'] = NULL;
$_SESSION['Usuario_id'] = NULL;
unset($_SESSION['Usuario']);
unset($_SESSION['Usuario_id']);
if ($logoutGoTo != "") {
	header("Location: $logoutGoTo");
	exit;
}
?>
