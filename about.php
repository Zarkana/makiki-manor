<?php
include('functions/requirements.php');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Makiki Manor | About</title>
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
    <main id="content">

      <div id="about-sections" class="main-content">
        <?php
        try {

          $stmt = $db->prepare('SELECT sectionID, sectionHeader, sectionContent FROM sections WHERE sectionID = :sectionID');
          $stmt->execute(array(':sectionID' => 1));
          $row = $stmt->fetch(); 

        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        ?>
    		<div class="section" id="learn">
    			<h2 class="section-header"><?php echo $row['sectionHeader']; ?></h2>
    			<div id="learn-paragraph" class="paragraph">
    				<?php echo $row['sectionContent']; ?>
    			</div>
    		</div>
        <?php
        try {

          $stmt = $db->prepare('SELECT sectionID, sectionHeader, sectionContent FROM sections WHERE sectionID = :sectionID');
          $stmt->execute(array(':sectionID' => 2));
          $row = $stmt->fetch(); 

        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        ?>
    		<div id="location" class="section">
    			<h2 class="section-header"><?php echo $row['sectionHeader']; ?></h2>
    			<div class="map">
    				<div class="overlay" onClick="style.pointerEvents='none'"></div>
    				<iframe style="border:0" src="https://www.google.com/maps/embed/v1/place?q=1130%20Wilder%20Avenue%2C%20Honolulu%2C%20HI%2C%20United%20States&key=AIzaSyAEzaBILX0BysTT1gC6RlzoYQWiwtQ10Xk" allowfullscreen></iframe>
    			</div>
    			<div id="location-paragraph" class="paragraph">
    				<?php echo $row['sectionContent']; ?>
    			</div>
    		</div>

        <?php
        try {
          $stmt = $db->prepare('SELECT sectionID, sectionHeader, sectionContent FROM sections WHERE sectionID = :sectionID');
          $stmt->execute(array(':sectionID' => 3));
          $row = $stmt->fetch(); 
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        ?>
    		<div class="section" id="parking">
    			<h2 class="section-header"><?php echo $row['sectionHeader']; ?></h2>
    			<div id="parking-paragraph" class="paragraph">
    				<?php echo $row['sectionContent']; ?>
    			</div>
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