<?php
/*
 * Copied a plugin from your main directory
 * to the server specified. Plugin must be in the
 * root directory.
 */
if(isset($argv[3])){
    if(!is_dir(FOLDER . $argv[2])){
        die("Plugin not found in main directory\n");
    }
    if(!is_dir(FOLDER . "server/" . $argv[3] . "/plugins")){
       die("Server not found.\n");
    }
    if(is_dir(FOLDER . "server/" . $argv[3] . "/plugins/" . $argv[2])){
        print "Cleaning up...\n";
        recursiveDelete(FOLDER . "server/" . $argv[3] . "/plugins/" . $argv[2]);
    }
    print "Installing...\n";
    copyDir(FOLDER . $argv[2], FOLDER . "server/" . $argv[3] . "/plugins/" . $argv[2]);
}
else{
    die("You need to specify a plugin and server.");
}