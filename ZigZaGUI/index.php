<?php
require './srv/config.php';
require 'zigui.php';
require './srv/filesize.php';

/*HTML HEAD*/
require './srv/html/head.html';
?>

<body>
    <header>
        <h1 id="title">ZigZaGUI</h1>
    </header>

    <section>
        <div id="input-liner">
            <?php 
                echo $file_input_missing;
                echo $file_input;
                require_once './srv/html/input-liner-overlay.html';
            ?>
        </div>

        <div class="two-col-wrap">
            <div class="collum">
                <h3 style="padding:0.4%;color:#F2F2F2;">INPUT <span style="float:right;color:#00b140;"><?php echo "Files:\n" . $input_dir_count;?></span></h3>

                <div id="input-dir">
                    <table width="100%" id="input-table">
                    <tr>
                        <td>Filename</td> <td>Filesize</td> <td>Template</td> <td>Priority</td> <td>Output</td>
                    </tr>
                    <?php
                    foreach($check_input_dir as $input){
                        $bytes = filesize($input_dir . $input);
                        echo "<tr> <td>$input</td> <td>" . FileSizeConvert($bytes) . "</td>";
                        if(file_exists("./temp/$input.md")){
                            $file_cfg = explode('!CFG!', file_get_contents("./temp/$input.md"));
                            echo "<td>$file_cfg[2]</td> <td>$file_cfg[1]</td> <td>$file_cfg[3]</td> </tr>";
                        }else{
                            echo "<td>null</td> <td>null</td> <td>null</td> </tr>";
                        }
                    }
                    ?>
                    </table>
                </div>
            </div>

            <div class="collum">
                <h3 style="padding:0.4%;color:#F2F2F2;">OUTPUT <span style="float:right;color:#00b140;"><?php echo "Files:\n" . $output_dir_count;?></span></h3>

                <div id="input-dir">
                    <table width="100%" id="input-table">
                    <tr>
                        <td>Filename</td><td>Filesize</td><td>Download</td>
                    </tr>
                    <?php
                    foreach($check_output_dir as $output){
                        $bytes = filesize($output_dir . $output);
                        echo "<tr> <td>$output</td> <td>" . FileSizeConvert($bytes) . "</td>" . "<td><a href='./output/$output'>$output</a>" . "</tr>";
                    }
                    ?>
                    </table>
                </div>
            </div>
        </div>

        <div id="prog" style="padding:0.5%;background-color:#2e2e2e;color:#00b140;">
        <h3>Processing:
                <?php
                /*Fix this bullshit */
                    $list_queue = array_diff(scandir('./queue/'), array('.', '..'));
                    foreach($list_queue as $queue){
                        echo file_get_contents('./queue/' . $queue);
                    }
                ?></h3>
        </div>

        <div id="ziGUI-mod">
            <h2 style="padding:6px;">ADMINISTRATION</h2>

            <table width="50%" style="float:left;">
                <tr>
                    <td colspan="2">
                        <form method="post" id="config">
                        <select name="input" style="padding:6px;" id="config">
                        <?php
                            $comp_input_a_temp = array_diff($check_input_dir, array_diff(scandir('./temp/'), array('.', '..')), $check_output_dir);
                            foreach($comp_input_a_temp as $input){
                                echo "<option value='$input'>$input</option>";
                            }
                        ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Priority:</label></td>
                    <td>
                        <select name="priority" style="padding:6px;" id="config">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td><label>Template:</label></td>
                    <td>
                        <select name="template" style="padding:6px;" id="config">
                            <option value="~">~</option>
                            <?php
                                $template_dir = array_diff(scandir('./templates/'), array('.', '..'));
                                foreach($template_dir as $templates){
                                    echo "<option>$templates</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Output Format:</label></td>
                    <td>
                        <select name="output-format" style="padding:6px;" id="config">
                            <option value=".mp4">mp4</option>
                            <option value=".mkv">mkv</option>
                            <option value=".ogg">ogg</option>
                            <option value=".flv">flv</option> 
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2"><button type="submit" name="queue" style="padding:5px;">Queue</button></form></td>
                </tr>
            </table>
            
            <table width="25%" style="float:right;">
                <tr>
                    <td colspan="2"><h2><img src="srv/styles/settings-10-48.png" height="18"> CONFIGURATION</h2></td>
                </tr>

                <tr>
                    <td>Input</td>
                    <td><?php echo $input_dir;?></td>
                </tr>

                <tr>
                    <td>Original Files</td>
                    <td><?php echo $original_files;?></td>
                </tr>

                <tr>
                    <td>Output</td>
                    <td><?php echo $output_dir;?></td>
                </tr>

                <tr>
                    <td>Queue</td>
                    <td><?php echo $queue;?></td>
                </tr>

                <tr>
                    <td>Temp</td>
                    <td><?php echo $temp;?></td>
                </tr>
                

                <tr>
                    <td>-threads</td>
                    <td><?php echo $threads;?></td>
                </tr>

                <tr>
                    <td colspan="2"><b>SERVER</b></td>
                </tr>

                <tr>
                    <td>Apache2 Version</td>
                    <td>
                        <?php 
                        $apacheV = explode(':', shell_exec("apache2 -v"));
                        echo $apacheV[1];
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>PHP Version</td>
                    <td>
                        <?php 
                        $phpV = explode('(cli)', shell_exec("php -v"));
                        echo $phpV[0];
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>ffmpeg Version</td>
                    <td>
                        <?php 
                        $ffmpegV = explode('Copyright', shell_exec("ffmpeg -version"));
                        echo $ffmpegV[0];
                        ?>
                    </td>
                </tr>
                
            </table>
        </div>
    </section>
</body>