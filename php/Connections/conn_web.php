<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn_web = "127.0.0.1";
$database_conn_web = "ludb";
$username_conn_web = "root";
$password_conn_web = "";
$conn_web = mysql_pconnect($hostname_conn_web, $username_conn_web, $password_conn_web) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES UTF8");
?>