
<?php
//if form has been submitted process it
if(isset($_POST['upload_owner_rule_submit'])){

    //collect form data
    extract($_POST);

    //very basic validation
    if($title ==''){
        $error[] = 'Please enter the title to be displayed.';
    }

    if(!isset($error)){

        try {
            
            if (($_FILES["file"]["type"] == "application/pdf")) {
                if ($_FILES["file"]["error"] > 0) {
                    $error[] = "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    if (file_exists("files/documents/" . $_FILES["file"]["name"])) {
                        $error[] = $_FILES["file"]["name"] . " <b>already exists.</b> ";
                    } else {
                        $filesize = $_FILES["file"]["size"] / 1024;
                        if($filesize < 1000){                        
                            $stmt = $db->prepare('INSERT INTO files (filename, title, type) VALUES (:filename, :title, :type)');
                            $stmt->execute(array(
                                ':filename' => $_FILES["file"]["name"],
                                ':title' => $title,
                                ':type' => $type
                            ));
                            
                            move_uploaded_file($_FILES["file"]["tmp_name"],
                            "files/documents/" . $_FILES["file"]["name"]);

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
    <input type='hidden' name='type' value='owner-rule'>
    <p>        
    <label>Title</label><br />
    <input name='title' type='text' value='<?php if(isset($error)){ echo $_POST['title'];}?>'>
    </p>    
    <p>
    <label>File</label><input id="file" name="file" type="file"><br>
    </p>
    <p><input class="upload" name='upload_owner_rule_submit' type='submit' value='Submit'></p>

</form>
