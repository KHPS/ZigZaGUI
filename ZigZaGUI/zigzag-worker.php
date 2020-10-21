<?php
/**
 * ZigZag Worker
 * Check srv/config.php for configurations
 */
require '/var/www/ZigZaGUI/srv/config.php';

if($worker){

    $find_job_input = array_diff(scandir($temp_full), array('.', '..'));
    foreach($find_job_input as $input_job){

        /*Get available config file from $temp*/
        $job_array_file = explode('!CFG!', file_get_contents($temp_full . $input_job));

        if($job_array_file[1] === "1"){
            echo "File:" . $job_array_file[0] . "\n";
                                    
                    switch($job_array_file[2]){
                            /**
                             * This should also get contents of templates
                             * 
                             * Default threads for ffmpeg is set to 1 in config.php
                             * To use custom threads this should be in a template.
                             */
                        case "~":  
                            /*Execute*/
                            $check_file = explode('.', $job_array_file[0]);
                            echo "Filename: " . $check_file[0] . "\n"; /*not working */
                            echo "Output Format: " . $job_array_file[3] . "\r\n";
                            echo "Output File: " . $check_file[0] . $job_array_file[3] . "\n";

                            if(file_exists($output_dir_full . $check_file[0] . $job_array_file[3])){
                                /**
                                 * This should identicate failure of some sort.
                                 */
                            }else{
                                /*add file to queue*/
                                $add_queue = fopen($queue_full . $input_job, 'w');
                                fwrite($add_queue, $job_array_file[0] . " ==> " . $check_file[0] . $job_array_file[3]);
                                fclose($add_queue);
                                                
                                /*Execute ffmpeg*/
                                shell_exec("ffmpeg -i /var/www/ZigZaGUI/input/$job_array_file[0] $threads /var/www/ZigZaGUI/output/$check_file[0]$job_array_file[3]");

                                if(file_exists($output_dir_full . $check_file[0] . $job_array_file[3])){
                                    rename("/var/www/ZigZaGUI/input/$job_array_file[0]", "/var/www/ZigZaGUI/originals/$job_array_file[0]");
                                    unlink($queue_full . $input_job);
                                    unlink($temp_full . $input_job);
                                } 
                            }
                        break;
                        default:
                            $threads = file_get_contents($templates_full . $job_array_file[2]);

                            /*Execute*/
                            $check_file = explode('.', $job_array_file[0]);
                            echo "Filename: " . $check_file[0] . "\n"; /*not working */
                            echo "Output Format: " . $job_array_file[3] . "\r\n";
                            echo "Output File: " . $check_file[0] . $job_array_file[3] . "\n";

                            if(file_exists($output_dir . $check_file[0] . $job_array_file[3])){
                                /**
                                 * This should identicate failure of some sort.
                                 */
                            }else{
                                /*add file to queue*/
                                $add_queue = fopen($queue_full . $input_job, 'w');
                                fwrite($add_queue, $job_array_file[0] . " ==> " . $check_file[0] . $job_array_file[3]);
                                fclose($add_queue);
                                                
                                /*Execute ffmpeg*/
                                shell_exec("ffmpeg -i /var/www/ZigZaGUI/input/$job_array_file[0] $threads /var/www/ZigZaGUI/output/$check_file[0]$job_array_file[3]");

                                if(file_exists($output_dir_full . $check_file[0] . $job_array_file[3])){
                                    rename("/var/www/ZigZaGUI/input/$job_array_file[0]", "/var/www/ZigZaGUI/originals/$job_array_file[0]");
                                    unlink($queue_full . $input_job);
                                    unlink($temp_full . $input_job);
                                } 
                            }
                            

                    } /**End switch */
        }
    }

echo "Done\n";
/**
 * Start this as background process 
 * shell_exec("sudo php /var/www/ZigZaDev/zigzag-worker.php > /dev/null &");
 * */

sleep(10);
shell_exec("php /var/www/ZigZaGUI/zigzag-worker.php > /dev/null 2>&1 &");
}
?>