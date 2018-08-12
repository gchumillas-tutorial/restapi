<?php
require_once "../vendor/autoload.php";
require_once "../config.php";
use controllers\ItemListController;

$c = new ItemListController();
$c->processRequest();
echo $c->getDocument();
