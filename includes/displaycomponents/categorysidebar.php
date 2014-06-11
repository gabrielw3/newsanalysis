
<div class="well sidebar-nav">
	<ul class="nav nav-pills nav-stacked">
		<li><h2>Categories</h2></li>





<?php

/*Including categorymodel.inc.php was a little fishy, when I included the relative path to the file it didn't work.
Tips online showed that if I echo getcwd() I would see the current position of the file, so I did and noticed that this file (categorysidebar.php) showed up in the root directory(weird..!)it wasn't where it should've been.
That caused me to include from the main path*/

//echo getcwd();
include_once('includes\categorymodel.inc.php');

$categorymodel = new CategoryModel();
foreach(CategoryModel::get_all_categories() as $category){
  echo '<li>' . '<a href="#">' .$category->get_name() . '</a></li>' ;
 
  
 //echo $category->get_name();


}
?>
 </ul>
          </div> 
