<?php
include('functions/requirements.php');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Makiki Manor | Gallery</title>
  <?php  
  include("inc/head.php");
  ?>
</head>
<body>

  <header>
    <?php 
    if($admin_query){
      if($admin_logged_in){
        include("inc/control-panel.php");
      }
    }
    include("inc/header.php");
    ?>
  </header>

  <div id="wrapper">
    <main id="content" class="wider">

      <div class="main-content">
  			<div id="gallery">
          <script>
            $.fn.viewer;
          </script>

          <?php        
          if(isset($_GET['delphoto'])){
            try{

              $stmt = $db->prepare('SELECT filename FROM gallery WHERE photoID = :photoID');
              $stmt->bindParam(':photoID', $_GET['delphoto']);
              $stmt->execute();
              $image = $stmt->fetch();

              if(file_exists("images/gallery/" . $image['filename'])){
                unlink("images/gallery/" . $image['filename']);
              }

              $stmt = $db->prepare('DELETE FROM gallery WHERE photoID = :photoID') ;
              $stmt->execute(array(':photoID' => $_GET['delphoto']));

              header('Location: ' . $page . '?cms=view');
              exit;
            } catch(PDOException $e) {
             echo $e->getMessage();
            }
          }

          try{
            $stmt = $db->query('SELECT photoID, filename, description FROM gallery ORDER BY photoID DESC');
            echo'<ul class="images">';
            while($image = $stmt->fetch()){
              echo '<li class="image">';
                echo '<img src="images/gallery/'.$image['filename'].'" alt="'.$image['description'].'" title="'.$image['description'].'">';
                if($admin_query){
                  if($admin_logged_in){
                    echo ('<a class="ignore-target" href="javascript:delphoto('. "'" . $image['photoID'] . "'" . ',' . "'" . $image['filename'] . "'" .')")">');
                      echo('<div id="' . $image["photoID"] . '" class="image-delete"></div>');
                    echo('</a>');
                  }
                }
              echo '</li>';
            }
            echo('</ul>');              
          } catch(PDOException $e) {
            echo $e->getMessage();
          }
          ?>
  			</div>
      </div>
    </main>
    <script>
      var options = {
        rotatable: false,
        title: false,
        scalable: false,
      };

      $(".images").viewer(options);
      
    </script>
    <footer>
      <?php
        include("inc/footer.php");
      ?>
    </footer>

  </div> <!-- End of Wrapper -->

</body>
<?php
include_once('inc/login-attempted.php');
?>
</html>