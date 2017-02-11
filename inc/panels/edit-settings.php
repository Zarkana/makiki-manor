<!-- <div id="edit-users-panel" class="panel page-panel">
	<div class="panel-bar page-panel-bar"></div>
</div> -->
<?php

//show message from add / edit page

?>
<div class="temp">

    <?php 
    //show message from add / edit page
    if(isset($_GET['action'])){ 
        echo '<h3>User '.$_GET['action'].'.</h3>'; 
    } 
    ?>

    <?php
        try {


        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    ?>

</div>
