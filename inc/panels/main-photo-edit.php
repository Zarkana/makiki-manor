
<?php
//if form has been submitted process it
if(isset($_POST['upload_main_photo_submit'])){

    //collect form data
    extract($_POST);

    //very basic validation
    if($description ==''){
        $error[] = 'Please enter the file description.';
    }

    if(!isset($error)){

        try {
            
            if (($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png")) {
                if ($_FILES["file"]["error"] > 0) {
                    $error[] = "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    if (file_exists("images/home/" . $_FILES["file"]["name"])) {
                        $error[] = $_FILES["file"]["name"] . " <b>already exists.</b> ";
                    } else {
                        $filesize = $_FILES["file"]["size"] / 1024;
                        if($filesize < 1000){
                            //update database
                            $stmt = $db->prepare('UPDATE banner SET filename = :filename, description = :description WHERE imageID = :imageID');
                            $stmt->execute(array(
                                ':filename' => $_FILES["file"]["name"],
                                ':description' => $description,
                                ':imageID' => 1
                            ));
                            
                            move_uploaded_file($_FILES["file"]["tmp_name"], "images/home/" . $_FILES["file"]["name"]);

                            header('Location: ' . $current_url);
                            exit;
                        }
                        else{
                            $error[] = "File is larger than " . $filesize . "kb";
                        }                        
                    }
                }

            } else {
                $error[] = "Wrong file type";
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<?php
//check for any errors
if(isset($error)){
    foreach($error as $error){
        echo '<p class="error">'.$error.'</p>';
    }
}
?>

<form action='' method='post' enctype="multipart/form-data">

    <p>
    <label>File</label><input id="file" name="file" type="file"><br>
    </p>
    <p>        
    <label>Description</label><br />
    <input name='description' type='text' value='<?php if(isset($error)){ echo $_POST['photoDescription'];}?>'>
    </p>

    <p><input class="upload submit-button" name='upload_main_photo_submit' type='submit' value='Submit'></p>

</form>
