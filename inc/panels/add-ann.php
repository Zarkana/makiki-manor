
<p><a href="<?php echo $page ?>?cms=view&ann=view">&larr; Announcement Index</a></p>

<?php
//if form has been submitted process it
if(isset($_POST['add_ann_submit'])){

    //collect form data
    extract($_POST);

    //very basic validation
    if($post_title ==''){
        $error[] = 'Please enter the title.';
    }

    if($post_published ==''){
        $error[] = 'Please decide if the post should be published.';
    }

    if($post_cont ==''){
        $error[] = 'Please enter the content.';
    }

    if(!isset($error)){

        try {                

            //insert into database
            $stmt = $db->prepare('INSERT INTO announcements (postTitle,postPublished,postCont,postDate) VALUES (:post_title, :post_published, :post_cont, :post_date)') ;
            $stmt->execute(array(
                ':post_title' => $post_title,
                ':post_published' => $post_published,
                ':post_cont' => $post_cont,
                ':post_date' => date('Y-m-d H:i:s')
            ));       

            if(isset($post_published) && $post_published == "true"){
                if(isset($send_email) && $send_email == "true"){
                    emailAnnouncements($post_title, $post_cont);
                }
            }

            //redirect to index page
            header('Location: index.php?cms=view');
            exit;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        header('Location: index.php?cms=view&resubmit=no');
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

?>

<form action='' method='post'>

    <p style="display:inline-block">
    <label title="The header of announcement and subject of email.">Title</label><br />
    <input type='text' name='post_title' value='<?php if(isset($error)){ echo $_POST['post_title'];}?>'>
    </p>
    &nbsp;
    <p id="published-select" style="display:inline-block">
    <label title="Determines whether viewers can view this post.">Publish</label><br>
    <select name='post_published'>
        <option value="true" selected="selected">Yes</option>
        <option value="false" >No</option>
    </select>
    </p>
    &nbsp;
    <p id="email-select" style="display:inline-block">
    <label title="Will send this announcement as an email to all subscribed users.">Email</label><br>
    <select name='send_email'>
        <option value="true" >Yes</option>
        <option value="false" selected="selected">No</option>
    </select>
    </p>

    <textarea class="mce" name='post_cont' cols='60' rows='30'><?php if(isset($error)){ echo $_POST['post_cont'];}?></textarea></p>

    <p><input class="submit-button" name='add_ann_submit' type='submit' value='Submit'></p>

</form>
