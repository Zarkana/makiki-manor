<?php
function fileUpload($path){
	move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
}
?>