<?php
define("FOLDER", "/Users/noahheyl/PocketMine/");
require_once "functions.php";
require_once "autoload.php";
array_shift($argv);
if(isset($argv[0])){
    $class = strtolower($argv[0]);
    if(class_exists($class)) {
        $command = new $class();
        if ($command instanceof CommandInterface) {
            array_shift($argv);
            $command->execute($argv);
        } else {
            Logger::error("That is not a command.");
        }
    }
    else{
        Logger::error("Command not found.");
    }
}
else{
    Logger::error("You must specify an action.");
}