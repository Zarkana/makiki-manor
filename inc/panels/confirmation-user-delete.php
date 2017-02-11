
<div id="confirmation-user-delete" class="temp">
	<h3 class="confirmation-header">User Deleted</h3>

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
			if (isset($_SESSION['deleted_user'])){
	    		$email = $_SESSION['deleted_user']['email'];
				$first = ucfirst(strtolower($_SESSION['deleted_user']['first']));
				$last = ucfirst(strtolower($_SESSION['deleted_user']['last']));
				$unit =  $_SESSION['deleted_user']['unit'];
				$role = $_SESSION['deleted_user']['role'];
				unset($_SESSION['deleted_user']);
            }

            echo '<tr>';
            echo '<td>'. $email .'</td>';
            echo '<td>'. $first .'</td>';
            echo '<td>'. $last .'</td>';
            echo '<td>'. $unit .'</td>';
            echo '<td>'. $role .'</td>';
            echo '</tr>';

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>
    </table>
</div>
