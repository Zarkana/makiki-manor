<?php 
include('functions/requirements.php');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Makiki Manor | Home</title>
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

  		<div id="main-photo">
        <?php
        try {
          //insert into database
          $stmt = $db->prepare('SELECT imageID, filename, description FROM banner WHERE imageID = :imageID');
          $stmt->execute(array(':imageID' => 1));
          $banner = $stmt->fetch();
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        ?>
        <img alt="<?php echo $banner['description'];?>" src="images/home/<?php echo $banner['filename'];?>">
      </div>
      <div class="main-content">

        <div class="tabs">
          <div class="tab" id="announcement-tab">
            <h2>Announcements</h2>
            <div class="primary"></div>
          </div>
          <div class="tab" id="calendar-tab">
            <h2>Calendar</h2>
            <div class="secondary"></div>
          </div>
        </div>

        <div class="half-content" id="announcements">
          <?php include("inc/announcements-list.php"); ?>
        </div>

        <div class="half-content" id="calendar">       
          <iframe class="iframe-calendar" src="https://calendar.google.com/calendar/embed?title=Makiki%20Manor&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=makikimanorcontact%40gmail.com&amp;color=%231B887A&amp;src=en.usa%23holiday%40group.v.calendar.google.com&amp;color=%23125A12&amp;ctz=Pacific%2FHonolulu" style="border-width:0"></iframe>          
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
<script>
 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
 })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-86412187-3', 'auto');
 ga('send', 'pageview');

</script>