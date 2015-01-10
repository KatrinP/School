<?php

/**
 * Assignment 9 - MyCourse
 * 
 * This file is the main entry point to the website.
 */
require("inc/config.inc.php");

// init Smarty
require(SMARTY_PATH . "/Smarty.class.php");
$smarty = new Smarty();

$smarty->setTemplateDir(PROJECT_DIR . "/smarty/templates");
$smarty->setCompileDir(PROJECT_DIR . "/smarty/templates_c");
$smarty->setCacheDir(PROJECT_DIR . "/smarty/cache");
$smarty->setConfigDir(PROJECT_DIR . "/smarty/configs");

// page to be served (main by default)
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "main";

$smarty->assign("page", $page);
$smarty->display("index.tpl");

?>
