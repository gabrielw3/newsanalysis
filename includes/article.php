<?php

class Article{
	private $id;
	private $pub_date;
	private $link;
	private $title;
	private $website_name;
	private $description;
	private $content;


function Article($id = NULL){
	if ($id == NULL){
		//do nothing . We are creating (although we never create a news article through the web interface)

	}else {
		$this->id = $id;
	}

	$sql = sprintf("SELECT * FROM entries WHERE ID  = '%s'", $this->get_id());
	$result = DBHandler::do_query($sql);
	if($result){

if(mysqli_num_rows($result)>0){
		$data = mysqli_fetch_assoc($result);
		$this->set_id($data['ID']);
		$this->set_pub_date($data['pub_date']);
		$this->set_title($data['title']);
		$this->set_link($data['link']);
		$this->set_website_name($data['website_name']);
		$this->set_description($data['description']);
		$this->set_content($data['content']);

							}


	}
	

}



public static function get_all_articles(){
$articles = array();
$sql = sprintf("SELECT * from entries");
$result = DBHandler::do_query($sql);
if($result){
	if (mysqli_num_rows($result)>0){
		while($data = mysqli_fetch_assoc($result)){
			$articles[] = new Article($data['ID']);
		}
	}
}


return $articles;

}





function get_keywords(){
	return $this->keywords;
}



function set_id($string){
	$this->id = $string;
}

function get_id(){
	return $this->id;
}

function set_pub_date($string){
	$this->pub_date = $string;
}

function get_pub_date(){
	return $this->pub_date;
}

function set_link($string){
	$this->link = $string;
}

function get_link(){
	return $this->link;
}


function get_content(){
	return $this->content;
}


function get_description(){
	return $this->description;
}


function get_website_name(){
	return $this->website_name;
}


function set_content($string){
	$this->content = $string;
}

function set_description($string){
	$this->description = $string;
}

function set_website_name($string){
	$this->website_name = $string;
}

function set_title($string){
	$this->title = $string;
}

function get_title(){
	return $this->title;
}


function search_article_contents($string){

//if article has content section, search it for words from keyword list. Return all results to a resultset. 
 //if it doesn't have a content section, use the summary section instead. 



}


}


?>

