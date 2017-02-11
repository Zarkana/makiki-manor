<?php
$confidential = true;
include('functions/requirements.php');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Makiki Manor | Contact</title>
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
      <div id="contact-sections" class="main-content">
        <div id="contact-us" class="section">
          <h2 class="section-header">Email Us</h2>
          <?php
          if(isset($_POST['contact_us_submit'])){
            /*
            WARNING: The following code is dangerous, changing it may result in the server
            sending infinite emails to all residentss! Please, dear God in heaven, don't mess with it or
            a thousand ghosts of server admins will seek your demise. Thank You.
            */

            //collect form data
            extract($_POST);

            //very basic validation
            if($your_email ==''){
              $error[] = 'Please enter an email for correspondence.';
            }

            if($email_body ==''){
              $error[] = 'Please type a message to send.';
            }
           
            if(!isset($error)){

              try {
                $stmt = $db->prepare('SELECT memberID, first, last, email FROM users WHERE email = :email');
                $stmt->execute(array(':email' => $_SESSION['user-email']));
                $residents = $stmt->fetch();      
              } catch(PDOException $e) {
                echo $e->getMessage();
              }

              require("functions/PHPMailer/class.phpmailer.php"); // path to the PHPMailerAutoload.php file.
              require("functions/PHPMailer/class.smtp.php");

              define('GUSER', 'makikimanorcontact@gmail.com'); // GMail username
              define('GPWD', 'Makikimanor01'); // GMail password
            
              /*smtpmailer(GUSER, GUSER, $residents['first'] + " " + $residents['last'], "Site: Inquiry", $email_body, null, $residents['email']);*/
              smtpmailer("residentmanager@makikimanor.com", $your_email, $residents['first'] + " " + $residents['last'], "Site: Filled Form", $email_body, null, $your_email);
              header('Location: ' . $current_url . '?inquiry_sent_confirmation=view');
            }
          }
          ?>

          <form class="email-us" id="contact_form" method="POST">  
            <input id="email" class="input" name="your_email" type="text" value='<?php if(isset($error)){ echo $_POST['your_email'];}else{echo $_SESSION['user-email'];}?>' placeholder="Your Email" size="32"/><br />
            <textarea id="message" class="input" name="email_body" cols="43" rows="5"><?php if(isset($error)){ echo $_POST['email_body'];}?></textarea><br />
            <input id="contact-us-submit" class="submit-button" name="contact_us_submit" type="submit" value="Email" />
          </form>
          <?php
          //check for any errors
          if(isset($error)){
            foreach($error as $error){
              echo '<p class="error">'.$error.'</p>';
            }
          }
          ?>
        </div>
        <div class="section" id="get-in-touch">
          <?php
          try {

            $stmt = $db->prepare('SELECT sectionID, sectionHeader, sectionContent FROM sections WHERE sectionID = :section_ID');
            $stmt->execute(array(':section_ID' => 5));
            $row = $stmt->fetch();

          } catch(PDOException $e) {
            echo $e->getMessage();
          }
          ?>
          <h2 class="section-header"><?php echo $row['sectionHeader']; ?></h2>
          <div id="get-in-touch-paragraph" class="paragraph">
            <?php echo $row['sectionContent']; ?>
          </div>
        </div>

        <div class="section" id="board">
          <?php
          try {
            $stmt = $db->prepare('SELECT sectionID, sectionHeader, sectionContent FROM sections WHERE sectionID = :section_ID');
            $stmt->execute(array(':section_ID' => 4));
            $row = $stmt->fetch();

          } catch(PDOException $e) {
            echo $e->getMessage();
          }
          ?>
          <h2 class="section-header"><?php echo $row['sectionHeader']; ?></h2>
          <div id="board-paragraph" class="paragraph">
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