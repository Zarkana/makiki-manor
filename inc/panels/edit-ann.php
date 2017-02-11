
<p><a href="<?php echo $page ?>?cms=view&ann=view">&larr; Announcement Index</a></p>

<?php

//if form has been submitted process it
if(isset($_POST['edit_ann_submit'])){

    $_POST = array_map( 'stripslashes', $_POST );

    //collect form data
    extract($_POST);

    //very basic validation
    if($post_ID ==''){
        $error[] = 'This post is missing a valid id!.';
    }

    if($post_title ==''){
        $error[] = 'Please enter the title.';
    }

    if($post_published ==''){
        $error[] = 'Please decide if the post should be published.';
    }

    if($post_cont ==''){
        $error[] = 'Please enter the content of the announcement.';
    }

    if(!isset($error)){

        try {

            //insert into database
            $stmt = $db->prepare('UPDATE announcements SET postTitle = :post_title, postPublished = :post_published, postCont = :post_cont WHERE postID = :post_ID') ;
            $stmt->execute(array(
                ':post_title' => $post_title,
                ':post_published' => $post_published,
                ':post_cont' => $post_cont,
                ':post_ID' => $post_ID
            ));

            //redirect to index page
            header('Location: index.php?cms=view');
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

    $stmt = $db->prepare('SELECT postID, postTitle, postPublished, postCont FROM announcements WHERE postID = :post_ID') ;
    $stmt->execute(array(':post_ID' => $_GET['edit_ann']));
    $row = $stmt->fetch(); 

} catch(PDOException $e) {
    echo $e->getMessage();
}

?>

<form action='' method='post'>
    <input name='post_ID' type='hidden' value='<?php echo $row['postID'];?>'>

    <p style="display:inline-block">
        <label title="The header of the announcement and the subject of the email.">Title</label><br />
        <input type='text' name='post_title' value='<?php echo $row['postTitle'];?>'>
        </p>
        &nbsp;
        <p style="display:inline-block">
        <label title="Determines whether viewers can view this post.">Published</label><br>
        <?php
        if($row['postPublished'] == "true"){
            $yes_selection = 'selected="selected"';
            $no_selection = '';            
        }else if($row['postPublished'] == "false"){            
            $yes_selection = '';
            $no_selection = 'selected="selected"';
        }
        ?>
        <select name='post_published'>
            <option value="true" <?php echo($yes_selection); ?> >Yes</option>
            <option value="false" <?php echo($no_selection); ?> >No</option>
        </select>
    </p>

    <textarea class="mce" name='post_cont' cols='60' rows='40'><?php echo $row['postCont'];?></textarea></p>

    <p><input class="submit-button" name='edit_ann_submit' type='submit' value='Submit'></p>

</form>

