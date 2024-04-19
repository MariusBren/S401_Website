<?php
include_once("controller/Controller.class.php");
$controller = new Controller($_GET);
$controller->changePage();
?>
