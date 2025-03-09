<?php 


// configuration.php

define('host', getenv('DB_HOST') ?: 'mariadb'); 
define('port', getenv('DB_PORT') ?: '3306');    
define('dbname', getenv('MYSQL_DATABASE'));
define('username', getenv('MYSQL_USER'));
define('password', getenv('MYSQL_PASSWORD'));



?>