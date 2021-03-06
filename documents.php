<?php
$confidential = true;
include('functions/requirements.php');
?>

<!DOCTYPE HTML>
<html lang="en">
  <head>
    <title>Makiki Manor | Documents</title>
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
        $stmt->execute(array(':sectionID' => 7));
        $row = $stmt->fetch(); 

      } catch(PDOException $e) {
          echo $e->getMessage();
      }
      ?>    
      <h2 class="section-header file-header"><?php echo $row['sectionHeader']; ?></h2>
      <div id="documents-about" class="section">        
        <div id="documents-about-paragraph" class="paragraph">
          <?php echo $row['sectionContent']; ?>
        </div>
      </div>
      <div id="documents" style="position: relative;">
        <div id="faux-target"></div>
        <div id="accordion">
          <?php

          if(isset($_GET['delfile'])){
            try{
              
              $stmt = $db->prepare('SELECT filename FROM files WHERE fileID = :fileID');
              $stmt->bindParam(':fileID', $_GET['delfile']);
              $stmt->execute();
              $file = $stmt->fetch();

              if(file_exists("files/documents/" . $file['filename'])){
                unlink("files/documents/" . $file['filename']);
              }

              $stmt = $db->prepare('DELETE FROM files WHERE fileID = :fileID');
              $stmt->execute(array(':fileID' => $_GET['delfile']));

              header('Location: ' . $page . '?cms=view');
              exit;
            } catch(PDOException $e){
              echo $e->getMessage();
            }
          }
          try{
              $stmt = $db->query('SELECT fileID, filename, title, type FROM files ORDER BY fileID ASC');
              while($file = $stmt->fetch()){
                if($file['type'] == 'document'){
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
                    <div class="content-doc">
                      <object type="application/pdf" data="files/documents/<?php echo($file["filename"]);?>" width="100%" height="100%">
                        <p>It appears you don't have a PDF plugin for this browser.
                        No biggie... you can <a href="files/documents/<?php echo($file["filename"]);?>">click here to
                        download the PDF file.</a>
                        </p>
                      </object>
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