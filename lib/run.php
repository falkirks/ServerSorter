<?php
/*
 * Runs PocketMine-MP inside a process wrapper.
 * This will NOT work on most systems.
 */
class run implements CommandInterface{
    const CONFIG = "en\ny\nn\nServer: %9\n19132\n512\n0\n20\nn\nFalk\nn\nn\nn\ny\n\n";
    public function execute(array $args){
        if(isset($args[0])){
            print "\033[37;40m[WRAPPER] Starting server process...\033[0m\n";
            $handle = proc_open(FOLDER . "server/" . $args[0] . "/start.sh", [
                0 => ["pipe", "r"],
                1 => ["pipe", "w"],
                2 => ["pipe", "a"]
            ],$pipes);
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
                        fwrite($pipes[0],str_replace("%9", $args[0], run::CONFIG));
                    }
                    elseif (strpos($buffer, "PocketMine-MP will now start.")) {
                        Logger::info("PocketMine configured.");
                    }
                    echo $buffer;
                    if(strlen($buffer) != 0 && $buffer{strlen($buffer)-1} === "m"){
                        echo "\r\n";
                    }
                }
                else{
                    $data = proc_get_status($handle);
                    if(!$data["running"]){
                        beep();
                        Logger::warning("Restarting...");
                        sleep(3);
                        $handle = proc_open(FOLDER . "server/" . $args[0] . "/start.sh", [
                            0 => ["pipe", "r"],
                            1 => ["pipe", "w"],
                            2 => ["pipe", "a"]
                        ],$pipes);
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
                        break;
                    }
                }
                ob_flush();
                flush();
            }
            while(proc_get_status($handle)["running"]) continue;
            Logger::info("Process ended.");
            proc_close($handle);
            fclose($stdin);
            ob_end_flush();
        }
    }
}