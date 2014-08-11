<?php
/*
 * Tidies up the PocketMine directory:
 *  - Moves old .php plugins
 *  - Prompts deletion of unrelated folders and files
 *  - Moves misplaced servers to the server directory
 *  - Prompts moving plugins off main workspace in directory
 *
 * To work on:
 *  - Delete plugin copies
 */
$scan = scandir($argv[2]);
foreach($scan as $f){
    if($f{0} == ".") continue;
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
    else{
        if(is_file(FOLDER . $f . "/start.sh")){
            print "Moving $f to server directory...\n";
            rename(FOLDER . $f, FOLDER . "server/" . $f);
        }
        elseif(is_file(FOLDER . $f . "/plugin.yml")){
            print "Should we move $f off the work directory? (y/n)\n";
            if(isGood()){
                moveDir(FOLDER . $f, FOLDER . "plugin/" . $f);
                print "Moved.\n";
            }
        }
        else{
            if($f != "server" && $f != "oldplugin" && $f != "plugin"){
                print "Should we delete $f ? (y/n)\n";
                if(isGood()){
                    recursiveDelete(FOLDER . $f);
                    print "Deleted.\n";
                }
            }
        }
    }
}