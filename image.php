<?php
//$_FILES["photo"]=$file
function upload($file){
$target_dir = "photos/";
$uploadOk = 1;
$extension = pathinfo($file["name"],PATHINFO_EXTENSION);

// Allow certain file formats
if($extension != "jpg" && $extension != "png" && $extension != "jpeg"
&& $extension != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	$nomImage = md5(uniqid()) .'.'. $extension;
    if (move_uploaded_file($file["tmp_name"], $target_dir.$nomImage)) {
        echo "";
    } else {
        echo "";
    }
}
return $target_dir.$nomImage;
	
}

?>