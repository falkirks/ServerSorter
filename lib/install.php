<?php
/*
 * Pulls a fresh PocketMine version and installs it.
 * Modes:
 *  - dev (Pulls latest development build .phar; skip compile)
 *  - beta (Pulls latest beta build .phar; skip compile)
 *  - git (Performs a git clone on the PocketMine-MP, non packaged)
 */
class install implements CommandInterface{
    public function execute(array $args){
        if(isset($args[0])){
            if(!isset($args[1])){
                Logger::warning("No build channel set, defaulting to 'dev'.");
                $args[1] = "dev";
            }
            switch($args[1]){
                case "dev":
                    Logger::info("Starting download and compile...");
                    mkdir(FOLDER . "server/" . $args[0]);
                    exec("curl -sL http://get.pocketmine.net/ | bash -s - -v development -u -d " . FOLDER . "server/" . $args[0]);
                    Logger::info("Copying binaries...");
                    copyDir(FOLDER . "server/bin", FOLDER . "server/" . $args[0] . "/bin");
                    break;
                case "beta":
                    Logger::info("Starting download and compile...");
                    mkdir(FOLDER . "server/" . $args[0]);
                    exec("curl -sL http://get.pocketmine.net/ | bash -s - -v beta -u -d" . FOLDER . "server/" . $args[0]);
                    Logger::info("Copying binaries...");
                    copyDir(FOLDER . "server/bin", FOLDER . "server/" . $args[0] . "/bin");
                    break;
                case "git":
                    Logger::info("Starting download and compile...");
                    exec("git clone --recursive https://github.com/PocketMine/PocketMine-MP.git " . FOLDER . "server/" . $args[0]);
                    Logger::info("Copying binaries...");
                    copyDir(FOLDER . "server/bin", FOLDER . "server/" . $args[0] . "/bin");
                    break;
                default:
                    Logger::error("That build channel isn't available.");
                    break;
            }

        }
        else{
            Logger::error("You must specify a name.");
        }
    }

}