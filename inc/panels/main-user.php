<?php

//show message from add / edit page
if(isset($_GET['deluser'])){ 

    $stmt = $db->query('SELECT memberID, first, last, email, unit, password, role FROM users WHERE memberID =' . $_GET['deluser']);

    $row = $stmt->fetch();
    
    $_SESSION['deleted_user']['email'] = $row['email'];
    $_SESSION['deleted_user']['first'] = $row['first'];
    $_SESSION['deleted_user']['last'] = $row['last'];
    $_SESSION['deleted_user']['unit'] = $row['unit'];
    $_SESSION['deleted_user']['role'] = $row['role'];
    
    //if user id is 1 ignore
    if($_GET['deluser'] !='1'){

        $stmt = $db->prepare('DELETE FROM users WHERE memberID = :memberID') ;
        $stmt->execute(array(':memberID' => $_GET['deluser']));

        header('Location: ' . $page . '?cms=view&action=deleted');
        exit;

    }
} 

?>
<div class="temp">

    <p><a href="<?php echo $page ?>?cms=view&add_user=view">Add User</a></p>
    <table class="sortable">
    <tr>
        <th class="sort-button hide-column">Email</th>
        <th class="sort-button">First</th>
        <th class="sort-button">Last</th>
        <th class="sort-button">Unit #</th>        
        <th class="sort-button hide-column">Role</th>
        <th class="active sort-button">Active</th>
        <th>Action</th>
    </tr>
    <?php
        try {

            $stmt = $db->query('SELECT memberID, first, last, email, unit, role, active FROM users ORDER BY email');
            while($row = $stmt->fetch()){
                
                echo '<tr>';
                echo '<td class="hide-column">'.strtolower($row['email']).'</td>';
                echo '<td>'. ucfirst(strtolower($row['first'])).'</td>';
                echo '<td>'. ucfirst(strtolower($row['last'])).'</td>';                
                echo '<td>'. $row['unit'].'</td>';                
                echo '<td class="hide-column">'.$row['role'].'</td>';
                echo '<td class="active">'. $row['active'].'</td>';
                ?>

                <td>
                <!-- TODO: take to same page -->
                    <a href="<?php echo $page ?>?cms=view&edit_user=<?php echo $row['memberID'];?>">Edit</a> 
                    <?php if($row['memberID'] != 1){?>
                        | <a class="ignore-target" href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo($row['first'] . ' '. $row['last']);?>')">Delete</a>
                    <?php } ?>
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
