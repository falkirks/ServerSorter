<?php

class Logger{
    public static function info($msg){
        print "[INFO] $msg\n";
    }
    public static function warning($msg){
        print "[WARN] $msg\n";
    }
    public static function error($msg){
        print "[ERR] $msg\n";
    }
    public static function confirm($msg){
        print "[?] $msg? (y/n)";
        return (trim(fgets(STDIN)) == "y");
    }
}