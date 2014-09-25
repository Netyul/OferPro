<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dboferapp = "localhost";
$database_dboferapp = "jefte_oferapp";
$username_dboferapp = "jefte_jefte";
$password_dboferapp = "**987jft";
$dboferapp = mysql_pconnect($hostname_dboferapp, $username_dboferapp, $password_dboferapp) or trigger_error(mysql_error(),E_USER_ERROR); 
?>