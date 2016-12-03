    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand label label-warning" href="logout.php">Logout</a>
          
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active">
                <a href="./index.php">Home</a>
              </li>
              <li class="">
                <a href="./index.php">Welcome, <?php echo  $_SESSION['uesr_name']; ?></a>
              </li>
              <li>
                <?php
          if($_SESSION['usertype']=="A" or $_SESSION['usertype']=="C"){
          ?>
          <a target="_blank" href="sendsmsconsol.php">Run SMS Consol</a>
          <?php } ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>