<?php
include_once ("config.php");

$serverName = "$server";
$connectionInfo = array("Database" => "$base", "UID" => "$usuarioBanco", "PWD" => "$SenhaBanco", "CharacterSet" => "UTF-8");
$conn = sqlsrv_connect($serverName, $connectionInfo);
if ($conn) {
  echo "";
} else {
  echo "falha na conex�o";
  die(print_r(sqlsrv_errors(), true));
}
