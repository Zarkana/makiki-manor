<?php
$confidential = true;
include('functions/requirements.php');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Makiki Manor | Forms</title>
  <?php
  include("inc/head.php");
  ?>
  <script>
  $(function() {
     $("#accordion").accordion({
        header: 'h2',
        active: false,
        collapsible: true
     });

     //capture the click on the a tag
     $("#accordion h2 a").click(function() {
        window.location = $(this).attr('href');
        return false;
     });
  });
  </script>
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
    <main id="content" class="accordian-content">

      <?php
      try {

        $stmt = $db->prepare('SELECT sectionID, sectionHeader, sectionContent FROM sections WHERE sectionID = :sectionID');
        $stmt->execute(array(':sectionID' => 6));
        $row = $stmt->fetch(); 

      } catch(PDOException $e) {
          echo $e->getMessage();
      }
      ?>
      <h2 class="section-header file-header"><?php echo $row['sectionHeader']; ?></h2>
      <div id="forms-about" class="section">        
        <div id="forms-about-paragraph" class="paragraph">
          <?php echo $row['sectionContent']; ?>
        </div>
      </div>
      <div style="position: relative;">
        <div id="faux-target"></div>
        <div id="accordion">
          <?php

          if(isset($_GET['delfile'])){
            try{

              $stmt = $db->prepare('SELECT filename FROM files WHERE fileID = :fileID');
              $stmt->bindParam(':fileID', $_GET['delfile']);
              $stmt->execute();
              $file = $stmt->fetch();

              if(file_exists("files/forms/" . $file['filename'])){
                unlink("files/forms/" . $file['filename']);
              }

              $stmt = $db->prepare('DELETE FROM files WHERE fileID = :fileID') ;
              $stmt->execute(array(':fileID' => $_GET['delfile']));

              header('Location: ' . $page . '?cms=view');
              exit;
            } catch(PDOException $e) {
              echo $e->getMessage();
            }
          }
          try{
            $stmt = $db->query('SELECT fileID, filename, title, type FROM files ORDER BY fileID ASC');
            while($file = $stmt->fetch()){
              if($file['type'] == 'form'){
                ?>
                <h2>
                <span style="position: relative">
                <?php echo $file['title'];
                if($admin_query){
                  if($admin_logged_in){
                  ?>
                  <a class="ignore-target" href="javascript:delfile('<?php echo $file['fileID'];?>','<?php echo($file['title']);?>')">
                    <div id="<?php echo($file["fileID"]);?>" class="delete-file"></div>
                  </a>
                  <?php
                  }
                }
                ?>
                </span>
                </h2>
                <div>
                  <div class="content-step content-step-1">
                    <h3>Step 1</h3>
                    <p>Edit form in a PDF editor</p>
                    <a class="ignore-target" href="files/forms/<?php echo $file['filename']; ?>" download="<?php echo $file['title']; ?>"><div class="download"></div></a>
                  </div>
                  <div class="content-step content-step-2">
                    <h3>Step 2</h3>
                    <p>Upload & mail form here</p>
                    <div class="mail" data-form="add-filled-pdf"></div>
                  </div>
                </div>
                <?php
              }
            }
            
          } catch(PDOException $e) {
              echo $e->getMessage();
          }
          ?>

        </div>
      </div>
    </main>

    <footer>
      <?php
        include("inc/footer.php");
      ?>
    </footer>

  </div><!-- End of Wrapper -->
</body>
<?php
include_once('inc/login-attempted.php');
?>
</html>