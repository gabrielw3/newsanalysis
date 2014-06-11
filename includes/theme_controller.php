<?php

class ThemeController{
	
	function ThemeController(){
	//blank
	}

	function create_Theme($form_values){

$theme_model = new Theme();
//$theme_model->set_theme_id($form_values['theme_id']);
$theme_model->set_name($form_values['theme_name']);
$keys = Array();



$themeObj = $theme_model->insert();




//$theme_model->add_keyword_to_theme($form_values['theme_name'],$form_values['keyword1']);
//$theme_model->add_keyword_to_theme($form_values['theme_name'],$form_values['keyword2']);
//$theme_model->add_keyword_to_theme($form_values['theme_name'],$form_values['keyword3']);

        $keys = preg_split("/[\s,]+/",$form_values['keyword']);

        file_put_contents('LIVERIGHT.txt', ($keys));
        $theme_model->add_keyword_to_theme($form_values['theme_name'],$keys);
        $theme_model->find_articles_with_keywords_present($form_values['theme_name'], $theme_model->get_keywords_relating_to_theme($form_values['theme_name']));



if($themeObj!=false){
	return true;
}
else{
	return false;
}



	}
}

?>