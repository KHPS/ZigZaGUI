<?php
/*1. Path Configuration*/
$input_dir = "./input/";
$original_files = "./originals/";
$output_dir = "./output/";
$temp = "./temp/";
$queue = "./queue/";
$templates = "./templates";

/*2. Web Dashboard Configuration*/
$default_path = "/var/www/ZigZaGUI/";

/*Full paths*/
$input_dir_full = $default_path . "input/";
$original_files_full = $default_path . "originals/";
$output_dir_full = $default_path . "output/";
$temp_full = $default_path . "temp/";
$queue_full = $default_path . "queue/";
$templates_full = $default_path . "templates";

/*3. CPU Configuration*/
/**
 * CPU CONFIGURATION FOR FFMPEG
 * DEFAULT -THREADS <1>
 */
$threads = "-threads 1";

/**Worker*/
$worker = 1;
/**
 * ########################################################################
 * ########################################################################
 * ################## DO NOT EDIT BELOW THIS POINT ########################
 * ########################################################################
 * ########################################################################
 */

/*Paths*/
if(file_exists($input_dir)){
    $check_input_dir = array_diff(scandir($input_dir), array('.', '..'));
    $input_dir_count = count($check_input_dir);
}else{
    mkdir($input_dir, 0777);
}
if(file_exists($original_files)){}else{mkdir($original_files, 0777);}

if(file_exists($output_dir)){
    $check_output_dir = array_diff(scandir($output_dir), array('.', '..'));
    $output_dir_count = count($check_output_dir);
}else{
    mkdir($output_dir, 0777);
}
if(file_exists($temp)){}else{mkdir($temp, 0777);}
if(file_exists($queue)){}else{mkdir($queue, 0777);}
if(file_exists($templates)){}else{mkdir($templates, 0777);}
?>