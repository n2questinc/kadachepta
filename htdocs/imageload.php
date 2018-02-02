<?php
$uploadDir = './radio/uploads/';      //Uploading to same directory as PHP file
$file = basename($_FILES['userfile']['name']);
$uploadFile = $file;
$randomNumber = rand(0, 999999999); 
$newName = $uploadDir . $randomNumber . $uploadFile;


if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	//echo "Temp file uploaded. \r\n";
} else {
	//echo "Temp file not uploaded. \r\n";
}

if ($_FILES['userfile']['size']> 30000000) {
	exit("Your file is too large."); 
}

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $newName)) {
    $postsize = ini_get('post_max_size');   //Not necessary, I was using these
    $canupload = ini_get('file_uploads');    //server variables to see what was 
    $tempdir = ini_get('upload_tmp_dir');   //going wrong.
    $maxsize = ini_get('upload_max_filesize');
    echo "http://appteve.com/radio/uploads/{$randomNumber}.jpg" ;
    
    echo json_encode([
     "Message" => "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.",
     "Status" => "OK"]);
}
?>