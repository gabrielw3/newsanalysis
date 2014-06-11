
<div class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">rEv IT!</a>
        </div>
       


        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active">
              <a href="index.php">Home</a>
            </li>
             <li>
              <a href="getlisted.php">Add a Company</a>
            </li>
            <li>
              <a href="account.php">My Account</a>
            </li>
           
            <li>
              <a href="review.php">Write a Review</a>
            </li>
            
           
            <li>
              <a href="#manage">Manage</a>
            </li>

          </ul>
          <form class="navbar-form navbar-left">
            <div class="form-group"></div>
          </form>
          <div class="col-md-3 col-md-4 pull-right">
            <form class="navbar-form" role="search">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
<?php if(!isset($_SESSION['user'])) {
echo '<a href="login.php">Login</a>';



}
//else echo '<a href="index.php?op=logout">'. $user->get_username(),',   Logout' .'</a>' 

else echo '<div class="btn-group">'.
          '<button class="btn dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="false">'.$user->get_username(). '<b class="caret"></b></button>'.
          '<ul class="dropdown-menu">'.
            '<li><a tabindex="-1" href="account.php">My Account</a></li>'.
            '<li class="divider"></li>'.
            '<li><a tabindex="-1" href="#">Change Email</a></li>'.
            '<li><a tabindex="-1" href="#">Change Password</a></li>'.
            '<li class="divider"></li>'.
            '<li><a tabindex="-1" href="index.php?op=logout">Logout</a></li>'.
          '</ul>'.
        '</div>'




  ?> 
                 
                 <!-- <a href="login.php">Login</a> -->
                </div>
              </div>
            </form>
          </div>
        </div>
        <!--/.navbar-collapse -->
        <div class="row"></div>
      </div>
    </div>
  </div>
  