<?php
/*
 * Generates new hard-links back to the central
 * bin folder from all server directories. This
 * should be performed following a change to the
 * bin folder.
 */
$scan = scandir(FOLDER . "server");
if(!in_array("bin", $scan)){
    die("You don't appear to have a bin loaded.\n");
}
foreach($scan as $f){
    if($f{0} == "." || $f == "bin") continue;
    if(is_dir(FOLDER . "server/$f")){
        print("Pushing bin to $f...\n");
        recursiveDelete(FOLDER . "server/$f/bin");
        copyDir(FOLDER . "server/bin", FOLDER . "server/$f/bin");
    }
    else{
        print "$f shouldn't be here, should we delete it? (y/n)\n";
        if(isGood()){
            unlink($argv[0] . $f);
            print "Deleted.\n";
        }
    }
}