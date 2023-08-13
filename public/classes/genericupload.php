<?php

include "img_uploader.php";

$error = "";
$msg = "";

$fileElementName = "foto";

if (empty($_FILES[$fileElementName]["tmp_name"]) || $_FILES[$fileElementName]["tmp_name"] == "none") {
    $error = "file size Limit to " . ini_get("post_max_size") . ". Cannot process your request";
} else {

    $fileUpload = new ImgUploader();

    $error = $fileUpload->img_uploader($_FILES[$fileElementName]);
    $dir = get_object_vars($fileUpload);

    $msg .= " File Name: " . $dir["filename"][0] . ", ";
    $msg .= " File Size: " . @filesize($_FILES[$fileElementName]["tmp_name"]);
    
    //$target_path = "uploads/" . basename($_FILES[$fileElementName]["name"]);
    //move_uploaded_file($_FILES[$fileElementName]["tmp_name"], $target_path);
}

if ($error){
	$action= $error;
}else{
	$action= $dir["filename"];
}

echo $action;

$goTo = "http://ciucuracao.info/panilla7.html?action=". $action;

header(sprintf("Location: %s", $goTo));
?>