
<?php

  echo  '<div class="container">
        <h1>Revved yet?</h1>
        <p>Reviewing a business is the best way to let someone else know how the business made 

you feel.</p>
        <div>Were they kind or courteous? or did their lack of proffesionalism annoy you. Let 

us know.
        </div>
        <p></p>';
?>
<?php
if(isset($_SESSION['user']))   {
  echo '<p><a class="btn btn-primary btn-lg" href="review.php">Write a Review

</a></p>';  
}else{
echo '<p><a class="btn btn-primary btn-lg" href="newuser.php">Create your Free Account 

</a></p>';
} ?>

      </div>
    </div>