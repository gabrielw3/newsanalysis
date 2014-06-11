
<?php
$categorymodel_path = '..\categorymodel.inc.php';

include_once('../categorymodel.inc.php');


foreach(CategoryModel::get_all_categories() as $category){
  echo $category->get_name();


}
?>

