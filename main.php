<?php
define("FOLDER", "./Desktop/PocketMine/");
require_once "functions.php";
if(isset($argv[1])){
    if(is_file(__DIR__ . "/scripts/" . $argv[1] . ".php")) require_once("scripts/" . $argv[1] . ".php");
    else die("Command not found.\n");
}
else die("You must specify an action.\n");