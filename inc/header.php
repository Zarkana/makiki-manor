<div id="banner">
  <div class="accent left overflow"></div>

  <div id="header-inner">
  	<a href="index.php">
    	<h1>Makiki Manor</h1>
    </a>
    <?php
      if($user_logged_in && !($_GET["cms"] == "view" && $admin_logged_in)){
        ?>
        <a title="Logout" href="inc/logout.php" id="logout-link">
          <div id="residents-logout-button"></div>
        </a>
        <?php
      }
    ?>
    <div class="accent-bar">  
    
      <div class="dropdown accent left">
        <div id="about-header" class="dropdown-header"><a class="primary-link" href="about.php">ABOUT</a></div>
        <div id="about" class="dropdown-list">
          <a href="about.php"><div class="dropdown-item two-line">Learn More</div></a>              
          <a href="gallery.php"><div class="dropdown-item">Gallery</div></a>          
        </div>
      </div>

      <div class="dropdown accent middle">
        <div id="residents-header" class="dropdown-header"><a class="primary-link" href="forms.php">RESIDENTS</a></div>
        <div id="residents" class="dropdown-list">          
          <a href="forms.php"><div class="dropdown-item">Forms</div></a>
          <a href="documents.php"><div class="smaller-text dropdown-item">Documents</div></a>
          <a href="owner-rules.php"><div class="dropdown-item two-line">Owner's Rules</div></a>
          <a href="http://www.kulaaina.com" target="_blank"><div class="dropdown-item">Payment</div></a>
        </div>
      </div>

      <div class="dropdown accent right">
        <div id="contact-header" class="dropdown-header"><a class="primary-link" href="contact.php">CONTACT</a></div>
        <div id="contact" class="dropdown-list">
	        <a href="contact.php"><div class="dropdown-item two-line">Get In Touch</div></a>
	    	<a href="contact.php"><div class="dropdown-item two-line">Board Members</div></a>
        </div>
      </div>

    </div>
  </div>

  <div class="accent right overflow"></div>
</div>