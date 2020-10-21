<?php
//###############################
//######### ZigZaGUI ############
//###############################
//###############################

/**
 * ziGUI web front input
 */
if(isset($_GET['continue'])){

    switch ($_GET['input-type']) {  
        case "upload":
            $file_input = '<form enctype="multipart/form-data" action="zigui.php" method="POST">
            <p>Upload your file</p>
            <input type="file" name="uploaded_file"></input><br />
            <input type="submit" value="Upload"></input>
            </form>';
        break;
    }
    
}else{
    $file_input_missing = '<form method="get" id="input-type">
    <select name="input-type" id="input-type"  style="padding:6px;">
    <option value="upload">Upload</option>
    </select> <button type="submit" name="continue" style="padding:5px;">Submit</button></form>';
}

if(!empty($_FILES['uploaded_file']))
  {
    $path = "./input/";
    $path = $path . basename($_FILES['uploaded_file']['name']);

    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
        header("location: /");
    } else{
        header("location: /");
    }
  }

if(isset($_POST['upload'])){
    
}

if(isset($_POST['write-template'])){
    $template_name = $_POST['template-name'];
    $templ_code = $_POST['template-source'];

    $w_template = fopen("./templates/$template_name.md", "w");
    fwrite($w_template, $templ_code);
    fclose($w_template);

    sleep(1);
    header("location: .");
}

/*this shit writes to temp*/
if(isset($_POST['queue'])){
    $queue_config = $_POST['input'];
    $priority = $_POST['priority'];
    $templ_sheet = $_POST['template'];
    $output_format = $_POST['output-format'];

    $add_queue = fopen("./temp/$queue_config.md", "w");
    fwrite($add_queue, "$queue_config!CFG!$priority!CFG!$templ_sheet!CFG!$output_format");
    fclose($add_queue);

    header("location: /");
}
?>