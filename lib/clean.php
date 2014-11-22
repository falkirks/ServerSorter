<?php
/*
 * Tidies up the PocketMine directory:
 *  - Moves old .php plugins (Disabled)
 *  - Prompts deletion of unrelated folders and files
 *  - Moves misplaced servers to the server directory
 *  - Prompts moving plugins off main workspace in directory
 *
 * To work on:
 *  - Delete plugin copies
 */
class clean implements  CommandInterface{
    public function execute(array $args){
        Logger::info("Starting directory cleanup...");
        $scan = scandir(FOLDER);
        foreach($scan as $f){
            if($f{0} == ".") continue;
            /*
            if(!is_dir(FOLDER . $f)){
                if(substr($f, -3) == "php"){
                    print "Moving $f to archive...\n";
                    rename(FOLDER . $f, FOLDER . "oldplugin/" . $f);
                }
                else{
                    print "Should we delete $f ? (y/n)\n";
                    if(isGood()){
                        unlink(FOLDER . $f);
                        print "Deleted.\n";
                    }
                }
            }
            */
            else{
                if(is_file(FOLDER . $f . "/start.sh")){
                    Logger::info("Moving $f to server directory...");
                    rename(FOLDER . $f, FOLDER . "server/" . $f);
                }
                elseif(is_file(FOLDER . $f . "/plugin.yml")){
                    if(Logger::confirm("Should we move $f off the work directory")){
                        moveDir(FOLDER . $f, FOLDER . "plugin/" . $f);
                        print "Moved.\n";
                    }
                }
                else{
                    if($f != "server" && $f != "oldplugin" && $f != "plugin" && $f != "build"){
                        if(Logger::confirm("Should we delete $f")){
                            recursiveDelete(FOLDER . $f);
                            Logger::info("Deleted.");
                        }
                    }
                }
            }
        }
    }
}