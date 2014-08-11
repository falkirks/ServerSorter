<?php
/*
 * Pushes DevTools unto all servers.
 */
$scan = scandir(FOLDER . "server");
if(!in_array("DevTools.phar", $scan)){
    die("You don't appear to have a DevTools phar.\n");
}
foreach($scan as $f){
    if($f{0} == "." || $f == "bin") continue;
    if(is_dir(FOLDER . "server/$f")){
        print("Pushing DevTools.phar to $f...\n");
        if(file_exists(FOLDER . "server/$f/plugins/DevTools.phar")) unlink(FOLDER . "server/$f/plugins/DevTools.phar");
        link(FOLDER . "server/DevTools.phar", FOLDER . "server/$f/plugins/DevTools.phar");
    }
    else{
        if($f == "DevTools.phar") continue;
        print "$f shouldn't be here, should we delete it? (y/n)\n";
        if(isGood()){
            unlink($argv[0] . $f);
            print "Deleted.\n";
        }
    }
}