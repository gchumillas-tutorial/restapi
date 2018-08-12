<?php
require_once "../vendor/autoload.php";
require_once "../config.php";
use controllers\LoginController;

$c = new LoginController();
$c->processRequest();
echo $c->getDocument();
