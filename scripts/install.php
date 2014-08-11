<?php
/*
 * Pulls a fresh PocketMine version and installs it.
 */
if(isset($argv[2])){
    if(!isset($argv[3])){
      $argv[3] = "dev";
    }
    switch($argv[3]){
        case "dev":
            print "Starting download and compile...\n";
            mkdir(FOLDER . "server/" . $argv[2]);
            exec("curl -sL http://get.pocketmine.net/ | bash -s - -v development -u -d " . FOLDER . "server/" . $argv[2]);
            print "Copying binaries...\n";
            copyDir(FOLDER . "server/bin", FOLDER . "server/" . $argv[2] . "/bin");
            break;
        case "beta":
            print "Starting download and compile...\n";
            mkdir(FOLDER . "server/" . $argv[2]);
            exec("curl -sL http://get.pocketmine.net/ | bash -s - -v beta -u -d" . FOLDER . "server/" . $argv[2]);
            print "Copying binaries...\n";
            copyDir(FOLDER . "server/bin", FOLDER . "server/" . $argv[2] . "/bin");
            break;
        case "git":
            print "Starting git clone...\n";
            exec("git clone --recursive https://github.com/PocketMine/PocketMine-MP.git " . FOLDER . "server/" . $argv[2]);
            print "Copying binaries...\n";
            copyDir(FOLDER . "server/bin", FOLDER . "server/" . $argv[2] . "/bin");
            break;
        default:
            die("Invalid install type.\n");
            break;
    }

}
else{
    die("You must specify a name.\n");
}