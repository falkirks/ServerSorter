<?php
/*
 * Runs PocketMine-MP inside a process wrapper.
 * This will NOT work on most systems.
 */
define("CONFIG", "en\ny\nn\nServer: %9\n19132\n128\n0\n20\nn\nFalk\nn\nn\nn\ny\n\n");
if(isset($argv[2])){
    print "\033[37;40m[WRAPPER] Starting server process...\033[0m\n";
    print "\033[36;40m[INFO] Process can be terminated with 'stop' or restarted with 'restart'\n[INFO] Only stop commands orginating at the console will be accepted.\033[0m\n";
    $descriptorspec = array(
        0 => array("pipe", "r"),
        1 => array("pipe", "w"),
        2 => array("pipe", "a")
    );
    $handle = proc_open(FOLDER . "server/" . $argv[2] . "/start.sh", $descriptorspec,$pipes);
    $stdin = fopen('php://stdin', 'r');
    stream_set_blocking($stdin,0);
    stream_set_blocking($pipes[1],0);
    if (ob_get_level() == 0) ob_start();
    while(true) {
        $buffer = fgets($pipes[1]);
        if($buffer !== false){
            $buffer = trim(htmlspecialchars($buffer));
            $buffer = str_replace("&quot;", '"', $buffer);
            $buffer = str_replace("&lt;", '<', $buffer);
            $buffer = str_replace("&gt;", '>', $buffer);
            if(strpos($buffer, "PocketMine-MP set-up wizard") != false){
                print("\033[37;40m[INFO] Starting auto configuration.!\033[0m\n");
                fwrite($pipes[0],str_replace("%9", $argv[1], CONFIG));
                print("\033[32;40m[INFO] Config data sent to process!\033[0m\n");
            }
            elseif (strpos($buffer, "PocketMine-MP will now start.")) {
                print("\033[32;40m[INFO] PocketMine sucessfully configured!\033[0m\n");
            }
            echo $buffer;
            if(strtolower($buffer[20]) != "p" && strlen($buffer) != 4){
                echo "\n";
            }
        }
        else{
            $data = proc_get_status($handle);
            if(!$data["running"]){
                print("\033[36;40m[INFO] Server has crashed, restarting server...\033[0m\n");
                $handle = proc_open($dir . $argv[1] . "/start.sh", $descriptorspec,$pipes);
                stream_set_blocking($pipes[1],0);
            }
        }
        if(($input = trim(fgets($stdin))) != false){
            if($input == "restart"){
                $restart = true;
                $input = "stop";
            }
            else $restart = false;
            if(!fwrite($pipes[0],$input . "\n")){
                print("\033[31;40m[WRAPPER] Failed to send command\033[0m\n");
            }
            if($input == "stop" && !$restart){
                print("\033[37;40m[WRAPPER] Starting PocketMine-MP shutdown...\033[0m\n");
                break;

            }
        }
        ob_flush();
        flush();
    }
    while(proc_get_status($handle)["running"]) continue;
    print("\033[32;40m PocketMine-MP exited! \n\033[0m\n");
    proc_close($handle);
    fclose($stdin);
    ob_end_flush();
    exit();
}