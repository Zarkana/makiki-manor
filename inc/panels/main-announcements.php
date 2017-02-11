<?php

//show message from add / edit page
if(isset($_GET['delpost'])){ 

    $stmt = $db->prepare('DELETE FROM announcements WHERE postID = :postID') ;
    $stmt->execute(array(':postID' => $_GET['delpost']));

    header('Location: ' . $page . '?cms=view');
    exit;
} 

?>
<div class="temp">

    <p><a href="<?php echo $page ?>?cms=view&add_ann=view">New Announcement</a></p>
    <table>
    <tr>
        <th class="sort-button">Title</th>
        <th class="sort-button">Date</th>
        <th class="hide-column sort-button">Published</th>
        <th>Action</th>
    </tr>
    <?php
        try {

            $stmt = $db->query('SELECT postID, postTitle, postPublished, postDate FROM announcements ORDER BY postID DESC');
            while($row = $stmt->fetch()){

                echo '<tr>';
                echo '<td>'.$row['postTitle'].'</td>';
                echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
                echo '<td class="hide-column">'.$row['postPublished'].'</td>';
                ?>

                <td>
                    <a href="<?php echo $page ?>?cms=view&edit_ann=<?php echo $row['postID'];?>">Edit</a> |
                    <a class="ignore-target" href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
                </td>

                <?php 
                echo '</tr>';

            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>
    
    

</div>
