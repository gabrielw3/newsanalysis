<?php

class BusinessController{

function BusinessController(){

}

function create($form_values){



$business_model = new BusinessModel();
$business_model->set_bname($form_values['businessname']);
$business_model->set_baddress($form_values['streetaddress'].','.$form_values['area'].','.$form_values['county']);
$business_model->set_tel($form_values['phone']);
$business_model->set_description($form_values['description']);
$business_model->set_email($form_values['email']);
$business_model->set_fb_url($form_values['facebook']);
$business_model->set_website($form_values['website']);
//$business_model->set_photo($form_values['business_thumbnail']);

$bizObj = $business_model->insert();

if($bizObj!=false){
	header("Location:main.php");
	file_put_contents('businessinsert.txt', 'business insert successful');

}
else{
	file_put_contents('businessinsert.txt', 'business insert failed');
}







}





















}
?>