<?php


class ReviewController{
	

function ReviewController(){
	//blank for now
}

function createReview($form_values){
	//creates a review

$review_model = new ReviewModel();
$review_model->set_bid($form_values['bid']);
$review_model->set_userid(trim($form_values['uid']));
$review_model->set_bname(trim($form_values['businessname']));
$review_model->set_summary(trim($form_values['summary']));
$review_model->set_content(trim($form_values['content']));
$review_model->set_rating(trim($form_values['rating-radios']));
$review_model->set_date($form_values['date_posted']);

file_put_contents('DATEHERE!!!!!!!!!!.txt', $review_model->get_date());


$revObj = $review_model->insert();

if($revObj!=false){
	//header("Location:main.php");
	file_put_contents('reviewinserthere.txt', $revObj);

	file_put_contents('THEREVIEWBNAME.txt', $review_model->get_bname());

}
else{
	file_put_contents('reviewinserthere.txt', 'review insert failed');
}




}

}
?>