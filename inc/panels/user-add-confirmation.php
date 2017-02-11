
<div id="user-add-confirmation" class="temp">	
	<h3 class="confirmation-header">User Added</h3>
    <table>
    <tr>
        <th>Email</th>
        <th>First</th>
        <th>Last</th>
        <th>Unit #</th>
        <th>Role</th>
    </tr>
    <?php
        try {

            $stmt = $db->query('SELECT memberID, first, last, email, unit, role FROM users WHERE memberID =' . $_GET['last_insert_id']);

            $row = $stmt->fetch();
            
            echo '<tr>';
            echo '<td>'.$row['email'].'</td>';
            echo '<td>'.$row['first'].'</td>';
            echo '<td>'.$row['last'].'</td>';
            echo '<td>'.$row['unit'].'</td>';
            echo '<td>'.$row['role'].'</td>';
            echo '</tr>';
        

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>
    </table>
    <div class="confirmation-menu">
        <a href="<?php echo $page ?>?cms=view&edit_user=<?php echo $memberID;?>">Update</a>        
        <a class="ignore-target" href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo($row['first'] . ' '. $row['last']);?>')">Delete</a>        
    </div>    
</div>
