<?php
function __autoload($name){
    if(is_file(__DIR__ . "/lib/" . $name . ".php")) require_once(__DIR__ . "/lib/" . $name . ".php");
    return false;
}