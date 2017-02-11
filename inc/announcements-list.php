<?php
    try {
        $stmt = $db->query('SELECT postID, postTitle, postPublished, postCont, postDate FROM announcements ORDER BY postID DESC');
        while($row = $stmt->fetch()){
            $date = date('jS M Y', strtotime($row['postDate']));

            $month = date('F', strtotime($row['postDate']));
            if($month == "January" || $month == "February" || $month == "August" || $month == "September" || $month == "November"  || $month == "December"){
                $month = date('M', strtotime($row['postDate']));
            }

            $day = date('j', strtotime($row['postDate']));  
            $suffix = ordinal_suffix($day);
            $time = date('g:ia', strtotime($row['postDate']));
            /*echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';*/
            if(($admin_query && $admin_logged_in) || $row['postPublished'] == "true"){
                if($row['postPublished'] != "true"){
                    $notPublished = 'not-published';
                }else{
                    $notPublished ='';
                }                

            ?>

          <div class="announcement <?php echo($notPublished); ?>">
            <div class="announcement-header">
              <div class="date">
                <span class="date-character primary"><?php echo($day); ?></span>
                <span class="date-character secondary"><?php echo($suffix); ?></span>
                <span class="date-character month"><?php echo($month); ?></span>
              </div>
              <div class="announcement-title">
                <h3><?php echo($row['postTitle']); ?></h3>
                <div class="cap"><span class="bar">|</span><span class="timestamp"><?php if($row['postPublished'] != "true"){echo("NOT PUBLISHED");}else{echo($time);} ?></span></div>
                <?php
                    if($admin_query && $admin_logged_in){
                    ?>
                    <a href="index.php?cms=view&amp;edit_ann=<?php echo($row['postID'])?>">
                        <div data-location="#announcement-<?php echo($row['postID'])?>" class="announcement-edit-button"></div>                    
                    </a>
                    <?php
                    }
                ?>
              </div>
            </div>
            <div id="announcement-<?php echo($row['postID'])?>" class="paragraph">
                <?php echo($row['postCont']); ?>
            </div>
            <div class="background top"></div><div class="background bottom"></div>
          </div>

        <?php 
            }
        }

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
?>