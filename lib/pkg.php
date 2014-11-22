<?php

class pkg implements CommandInterface{
    public function execute(array $args){
        if(isset($args[0])) {
            if(is_dir(FOLDER . $args[0]) && file_exists(FOLDER . $args[0] . "/plugin.yml")){
                Logger::info("Packaging plugin...");
                @mkdir(FOLDER . $args[0] . "/out");
                $description = new PluginDescription(file_get_contents(FOLDER . $args[0] . "/plugin.yml"));
                $pharPath = FOLDER . $args[0] . "/out/" . $description->getName() ."_" . $description->getVersion() . ".phar";
                $phar = new Phar($pharPath);
                $phar->setMetadata([
                    "name" => $description->getName(),
                    "version" => $description->getVersion(),
                    "main" => $description->getMain(),
                    "api" => $description->getCompatibleApis(),
                    "depend" => $description->getDepend(),
                    "description" => $description->getDescription(),
                    "authors" => $description->getAuthors(),
                    "website" => $description->getWebsite(),
                    "creationDate" => filemtime(FOLDER . $args[0] . "/plugin.yml")
                ]);
                $phar->setStub('<?php echo "PocketMine-MP plugin ' . $description->getName() . ' v' . $description->getVersion() . '\n----------------\n";if(extension_loaded("phar")){$phar = new \Phar(__FILE__);foreach($phar->getMetadata() as $key => $value){echo ucfirst($key).": ".(is_array($value) ? implode(", ", $value):$value)."\n";}} __HALT_COMPILER();');
                $phar->setSignatureAlgorithm(\Phar::SHA1);
                $phar->startBuffering();
                $filePath = FOLDER . $args[0];
                foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($filePath)) as $file) {
                    $path = ltrim(str_replace(array("\\", $filePath), array("/", ""), $file), "/");
                    if ($path{0} === "." || strpos($path, "/.") !== false) {
                        continue;
                    }
                    Logger::info("Adding $file");
                    $phar->addFile($file, $path);
                }
                $phar->compressFiles(\Phar::GZ);
                $phar->stopBuffering();
                Logger::info("Plugin packaged.");
                return $pharPath;
            }
            else{
                Logger::error("That plugin doesn't exist.");
            }
        }
        else{
            Logger::error("You must specify a plugin to package.");
        }
    }
}