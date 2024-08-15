<?php
/* Database module */
define("DB_HOST", "localhost");
define("DB_USER", "epu123");
define("DB_PASSWORD", "eastarjet123");
define("DB_NAME", "epu123");
define("DB_DNS", "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME);

/* Constant of Exception */
define("RPC_SUCCESS", 1);
define("RPC_NOT_FOUND_API", -1);
define("RPC_QUERY_ERROR", -2);
define("RPC_PARAM_ERROR", -3);
?>