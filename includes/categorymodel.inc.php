<?php
require_once('db/DBHandler.inc.php');
class CategoryModel{

private $id;
private $name;


public function CategoryModel($id = NULL){
	if($id == NULL){

	}else{
		$sql = sprintf("SELECT * FROM categories WHERE catid = %d", $id);
		$result = DBHandler::do_query($sql);
		if($result){
			if(mysqli_num_rows($result) > 0){
				$data = mysqli_fetch_assoc($result);
				$this->set_id($data['catid']);
				$this->set_name($data['name']);
			}
		}

	}
}


public function get_id(){
	return $this->id;
}

public function set_id($id){
	$this->id = $id;
}

public function get_name(){
	return $this->name;
}

public function set_name($name){
	$this->name = $name;
}

public static function get_all_categories(){
	$categories = array();
	$sql = "SELECT * FROM categories";
	$result = DBHandler::do_query($sql);
	if($result){
	if(mysqli_num_rows($result) > 0){
	while($data = mysqli_fetch_assoc($result)){
	$categories[] = new CategoryModel($data['catid']);
	}
	}
	}


return $categories;

}


public function insert() {
		//place a query here to insert.. all model values
		//first make sure no one has the same username...
		$test_category = new CategoryModel($this->id);
		if($test_category->get_name() != null) return false; //This category is already in our database
		else {
			

file_put_contents('category_inserted.txt', $test_category->get_name());  //for debugging



			$sql = sprintf("INSERT INTO categories (name) VALUES ('%s')",
						$this->get_name());
						
			DBHandler::do_query($sql);
			
			return new CategoryModel($this->get_id());
		}
	}








}
?>