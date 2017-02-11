<?php

//if form has been submitted process it
if(isset($_POST['edit_section_documents_about_submit'])){

    $_POST = array_map( 'stripslashes', $_POST );

    //collect form data
    extract($_POST);

    //very basic validation
    if($section_ID ==''){
        $error[] = 'This section is missing a valid id!.';
    }

    if($section_header ==''){
        $error[] = 'Please enter the header.';
    }

    if($section_content ==''){
        $error[] = 'Please enter the content of the section.';
    }

    if(!isset($error)){

        try {

            //insert into database
            $stmt = $db->prepare('UPDATE sections SET sectionHeader = :section_header, sectionContent = :section_content WHERE sectionID = :section_ID');
            $stmt->execute(array(
                ':section_header' => $section_header,
                ':section_content' => $section_content,
                ':section_ID' => 7
            ));

            //redirect to index page
            header('Location: ' . $current_url);
            exit;

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
            echo '<p class="error">'. $error .'</p>';
        }
    }

    try {

        $stmt = $db->prepare('SELECT sectionID, sectionHeader, sectionContent FROM sections WHERE sectionID = :section_ID') ;
        $stmt->execute(array(':section_ID' => 7));
        $row = $stmt->fetch(); 

    } catch(PDOException $e) {
        echo $e->getMessage();
    }

?>

<form action='' method='post'>
    <input type='hidden' name='section_ID' value='<?php echo $row['sectionID'];?>'>

    <p>
    <label>Header</label><br />
    <input type='text' name='section_header' value='<?php echo $row['sectionHeader'];?>'>
    </p>

    <textarea class="mce" name='section_content' cols='60' rows='40'><?php echo $row['sectionContent'];?></textarea></p>

    <p><input class="submit-button" name='edit_section_documents_about_submit' type='submit' value='Submit'></p>

</form>
