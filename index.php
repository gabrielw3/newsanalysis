<?php

require_once('includes/db/DBHandler.inc.php');
require_once('includes/theme_controller.php');
require_once('includes/theme.php');

//header("Location:main.php");

@$op = $_REQUEST['op'];

$theme_controller = new ThemeController();






switch ($op){
    case "add-theme":
        $form_values = $_POST;
      //  file_put_contents('result.txt', $form_values[keywords],FILE_APPEND);
        if($theme_controller->create_Theme($form_values)){
            header("Location:add-theme.php?succ=1");
        }
        else{
            header("Location:add-theme.php?err=1");
        }
    break;
    default:

}







?>