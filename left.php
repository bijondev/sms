      <div class="span3 bs-docs-sidebar">
        <ul class="nav nav-list bs-docs-sidenav">
        	<?php
        	if($_SESSION['usertype']=="A"){
        	?>
          <li><a href="?q=all-user"><i class="icon-chevron-right"></i>Admin</a></li>
          <li><a href="?q=sms_report"><i class="icon-chevron-right"></i> SMS Report</a></li>
          <?php
      }
      if($_SESSION['usertype']=="A" or $_SESSION['usertype']=="U"){
      	?>
          <li><a href="?q=my-balance-history"><i class="icon-chevron-right"></i>Balance History</a></li>
          <li><a href="?q=my-sms"><i class="icon-chevron-right"></i>SMS</a></li>
          <li><a href="?q=change_pass_word"><i class="icon-chevron-right"></i>Change Password</a></li>
          <?php
      }
      ?>
        </ul>
      </div>