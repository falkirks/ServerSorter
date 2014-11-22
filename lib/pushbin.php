<?php
/*
 * Generates new hard-links back to the central
 * bin folder from all server directories. This
 * should be performed following a change to the
 * bin folder.
 */
class pushbin implements CommandInterface{
    public function execute(array $args){
        $scan = scandir(FOLDER . "server");
        if(!in_array("bin", $scan)){
            Logger::error("You don't appear to have a bin loaded.");
        }
        else {
            foreach ($scan as $f) {
                if ($f{0} == "." || $f == "bin") continue;
                if (is_dir(FOLDER . "server/$f")) {
                    Logger::info("Pushing bin to $f...");
                    recursiveDelete(FOLDER . "server/$f/bin");
                    copyDir(FOLDER . "server/bin", FOLDER . "server/$f/bin");
                }
            }
        }
    }
}