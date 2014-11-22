<?php
/*
 * Deletes all traces of a specified server.
 */
class destroy implements  CommandInterface{
    public function execute(array $args){
        if(isset($args[0])){
            if(is_dir(FOLDER . "server/" . $args[0])){
                if(Logger::confirm("Are you sure you want to delete " . $args[0])){
                    recursiveDelete(FOLDER . "server/" . $args[0]);
                    Logger::info("Deleted.");
                }
            }
            else{
                Logger::error("Server doesn't exist.");
            }
        }
        else{
            Logger::error("You need to specify a server.");
        }
    }
}