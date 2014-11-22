<?php
/*
 * Copied a plugin from your main directory
 * to the server specified. Plugin must be in the
 * root directory.
 */
class shift implements CommandInterface{
    public function execute(array $args){
        if(isset($args[1])){
            if(!is_dir(FOLDER . $args[0])){
                Logger::error("Plugin not found in main directory");
                return;
            }
            if(!is_dir(FOLDER . "server/" . $args[1] . "/plugins")){
                Logger::error("Server not found.");
                return;
            }
            if(is_dir(FOLDER . "server/" . $args[1] . "/plugins/" . $args[0])){
                recursiveDelete(FOLDER . "server/" . $args[1] . "/plugins/" . $args[0]);
            }
            copyDir(FOLDER . $args[0], FOLDER . "server/" . $args[1] . "/plugins/" . $args[0]);
        }
        else{
            Logger::error("You need to specify a plugin and server.");
        }
    }
}