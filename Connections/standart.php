<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_standart = "mysql4.aci-plan.de";
$database_standart = "db233815";
$username_standart = "db233815";
$password_standart = "xdt8n3bo";
$standart = mysql_pconnect($hostname_standart, $username_standart, $password_standart) or trigger_error(mysql_error(),E_USER_ERROR); 
?>