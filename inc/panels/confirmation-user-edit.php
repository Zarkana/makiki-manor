<!-- TODO remove temps -->
<div class="temp">
    
    <h3 id="confirmation-user-edit" class="confirmation-header">User Updated</h3>
    <table>
    <tr>        
        <th>Email</th>
        <th>First</th>
        <th>Last</th>
        <th>Unit #</th>
        <th>Role</th>
        <th>Active</th>   
    </tr>
    <?php
        try {            

            if (isset($_SESSION['updated_user'])){
                $memberID = $_SESSION['updated_user']['id'];
                $email = trim(strtolower($_SESSION['updated_user']['email']));
                $first = trim(strtolower(ucfirst($_SESSION['updated_user']['first'])));
                $last = trim(strtolower(ucfirst($_SESSION['updated_user']['last'])));
                $unit =  $_SESSION['updated_user']['unit'];
                $role = $_SESSION['updated_user']['role'];
                $active = $_SESSION['updated_user']['active'];
                unset($_SESSION['updated_user']);
            }

            echo '<tr>';                
            echo '<td>'. $email .'</td>';
            echo '<td>'. $first .'</td>';
            echo '<td>'. $last .'</td>';
            echo '<td>'. $unit .'</td>';
            echo '<td>'. $role .'</td>';
            echo '<td>'. $active .'</td>';
            echo '</tr>';
        

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>
    <div class="confirmation-menu">
        <a href="<?php echo $page ?>?cms=view&edit_user=<?php echo $memberID;?>">Update Again</a>        
    </div>
</div>
