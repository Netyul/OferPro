<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dboferapp = "localhost";
$database_dboferapp = "oferapp_oferapp";
$username_dboferapp = "oferapp_jefte";
$password_dboferapp = "**987jft";
$dboferapp = mysql_pconnect($hostname_dboferapp, $username_dboferapp, $password_dboferapp) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
<?php  
mysql_select_db($database_dboferapp, $dboferapp);
mysql_query("SET NAMES 'utf8'", $dboferapp);
mysql_query('SET character_set_connection=utf8', $dboferapp);
mysql_query('SET charecter_set_client=utf8', $dboferapp );
mysql_query('SET charecter_set_results=utf8', $dboferapp );
?>