
<?php
//if form has been submitted process it
if(isset($_POST['upload_photo_submit'])){

    //collect form data
    extract($_POST);

    //very basic validation
    if($photo_description ==''){
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
                    if (file_exists("images/gallery/" . $_FILES["file"]["name"])) {
                        $error[] = $_FILES["file"]["name"] . " <b>already exists.</b> ";
                    } else {
                        $filesize = $_FILES["file"]["size"] / 1024;
                        if($filesize < 1000){

                            $stmt = $db->prepare('INSERT INTO gallery (filename,description) VALUES (:photo_filename, :photo_description)');
                            $stmt->execute(array(
                                ':photo_filename' => $_FILES["file"]["name"],
                                ':photo_description' => $photo_description
                            ));
                            
                            move_uploaded_file($_FILES["file"]["tmp_name"],
                            "images/gallery/" . $_FILES["file"]["name"]);

                            $last_insert_id = $db->lastInsertId();
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
    <input name='photo_description' type='text' value='<?php if(isset($error)){ echo $_POST['photo_description'];}?>'>
    </p>

    <p><input class="Upload submit-button" name='upload_photo_submit' type='submit' value='Submit'></p>

</form>
