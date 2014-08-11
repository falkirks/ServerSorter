<?php
/*
 * Deletes all traces of a specified server.
 */
if(isset($argv[2])){
    if(is_dir(FOLDER . "server/" . $argv[2])){
        print "Are you sure you want to delete " . $argv[2] . "? (y/n)";
        if(isGood()){
            recursiveDelete(FOLDER . "server/" . $argv[2]);
            print "Deleted.\n";
        }
    }
    else{
        die("Server doesn't exist.\n");
    }
}
else{
    die("You need to specify a server.\n");
}