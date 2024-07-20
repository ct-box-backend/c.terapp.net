<?php

$host_name = "localhost";
$db_user = "net.ter.app";
$db_pass = "";

$db_name = "c.terapp.net";

$db = new PDO("mysql:host=$host_name;dbname=$db_name", $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
