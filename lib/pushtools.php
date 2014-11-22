<?php
/*
 * Pushes DevTools to all servers.
 */
class pushtools implements CommandInterface{
    public function execute(array $args){
        $scan = scandir(FOLDER . "server");
        if(!in_array("DevTools.phar", $scan)){
            Logger::error("You don't appear to have a DevTools phar.");
        }
        else {
            foreach ($scan as $f) {
                if ($f{0} == "." || $f == "bin") continue;
                if (is_dir(FOLDER . "server/$f")) {
                    Logger::info("Pushing DevTools.phar to $f...");
                    if (file_exists(FOLDER . "server/$f/plugins/DevTools.phar")) unlink(FOLDER . "server/$f/plugins/DevTools.phar");
                    link(FOLDER . "server/DevTools.phar", FOLDER . "server/$f/plugins/DevTools.phar");
                }
            }
        }
    }
}