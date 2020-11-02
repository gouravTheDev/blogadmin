<?php
function D_image_upload1($filename, $path="tmp",$target_file ,$maxsize=300000) {
$uploadOk = 0;
  if(isset($_FILES[$filename]["name"]) && !empty($_FILES[$filename]["name"])) {
  $target_dir = "upload/Admin_Upload/".$path."/";
  if($target_file == "")$target_file = $target_dir.basename($_FILES[$filename]["name"]);
  else $target_file = $target_dir.time().$target_file;
  
    if($_FILES[$filename]["size"]==0){ $check = false; $uploadOk = "Check Max upload limit.apache";}
      else $check = getimagesize($_FILES[$filename]["tmp_name"]);
    if($check == false) { $uploadOk .= "Image mime not defined!File type - " . $check["mime"] . ".";  }
    if ($_FILES[$filename]["size"] > $maxsize) { $uploadOk .= "Sorry, your file is too large.";}
    if ($uploadOk !== 0) { $uploadOk .= "Sorry, your file was not uploaded.";}
    if (file_exists($target_file))  $uploadOk .= "Sorry, file name already exists.";
    else {
        if (move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file)) {
            $uploadOk = "The file ". basename( $_FILES[$filename]["name"]). " has been uploaded.";
        } else {
            $uploadOk .= "Sorry, there was an error Moving the uploaded file.";print_r($_FILES);
        }
    }
  }
  return $uploadOk;
}
?>
