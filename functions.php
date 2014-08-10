<?php
/**
 * @return bool
 */
function isGood(){
    return (trim(fgets(STDIN)) == "y");
}

/**
 * @param $src
 */
function recursiveDelete($src){
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recursiveDelete($src . '/' . $file);
            }
            else {
                unlink($src . '/' . $file);
            }
        }
    }
    rmdir($src);
    closedir($dir);
}

/**
 * @param $src
 * @param $dst
 */
function moveDir($src,$dst){
    $dir = opendir($src);
    @mkdir($dst,0755,true);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                moveDir($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                rename($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    rmdir($src);
    closedir($dir);
}

/**
 * @param $src
 * @param $dst
 */
function copyDir($src,$dst){
    $dir = opendir($src);
    @mkdir($dst,0755,true);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                copyDir($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                link($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}