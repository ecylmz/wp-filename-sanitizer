<?php

/**
 * Plugin Name: Upload Filename Sanitizer
 * Plugin URI: https://github.com/ecylmz/upload-filename-sanitizer
 * Description: Sanity in file names while uploading.
 * Version: 0.1
 */

/**
 * Filter {@see sanitize_file_name()}
 */

require_once 'utf8_to_ascii/utf8_to_ascii.php';

function upload_filename_sanitizer($filename) {
    $info = pathinfo($filename);
    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($filename, $ext);

    // remove internal dots
    $name = str_replace(".".$ext,"",$name);
    $name = str_replace(".","",$name);

    // initial cleaning
    $name = str_replace("(","",$name);
    $name = str_replace(")","",$name);
    $name = str_replace("'","",$name);
    $name = str_replace('"',"",$name);
    $name = str_replace(",","",$name);
    $name = str_replace(" ","_",$name);

    // utf8 to ascii
    $name = utf8_to_ascii($name);

    return $name . $ext;
}

add_filter('sanitize_file_name', 'upload_filename_sanitizer', 10);
?>
