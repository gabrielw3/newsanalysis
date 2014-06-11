<?php

class BusinessModel{
	private $id;
	private $bname;
	private $baddress;
	private $tel;
	private $website;
	private $fb_url;
	private $categories;
	private $description;
	private $email;







function BusinessModel($bname = NULL){
	if($bname == NULL){

	}else{
		$this->bname = $bname;
	}
	$sql = sprintf("SELECT * FROM business WHERE bname = '%s'", $bname);
	$result = DBHandler::do_query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			$data = mysqli_fetch_assoc($result);
			$this->id = $data['bid'];
			$this->set_bname($data['bname']);
			$this->set_baddress($data['baddress']);
			$this->set_tel($data['tel1']);
			$this->set_website($data['website']);
			$this->set_fb_url($data['fb_url']);
			//$this->set_categories($data['']);
			$this->set_email($data['email']);

		}
	}
}



public static function get_all_businesses(){
	$businesses = array();

	$sql = sprintf("SELECT bname FROM business");
	$result = DBHandler::do_query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
			while($data = mysqli_fetch_assoc($result)){
				$businesses[] = new BusinessModel($data['bname']);
			}
		}
	}
	return $businesses;
}

public static function get_bname_sql($bid){
	$business = array();
	$sql = sprintf("SELECT * FROM business WHERE bid= '%s'", $bid);
	$result = DBHandler::do_query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
$data = mysqli_fetch_assoc($result);
	file_put_contents('bnamecontents.txt', $data['bname']);
		}
	}

			return $data['bname'];
}




public function insert(){
	$test_business = new BusinessModel($this->bname);
	if($test_business->get_id() != null) return false;
	else{
		file_put_contents('business.txt', 'business info');
		$sql = sprintf("INSERT INTO business (bname, baddress, tel1, email, website, fb_url, description) VALUES ('%s', '%s', '%s','%s', '%s', '%s', '%s')", 
			$this->bname,
			$this->baddress,
			 $this->tel, 
			 $this->email, 
			 $this->website, 
			 $this->fb_url, 
			 $this->description);

	DBHandler::do_query($sql);
			
			//return new BusinessModel($this->get_bname());
	return true;

	}
}


public function update(){

/*
$transaction[] = sprintf("UPDATE user SET (first_name='%s', last_name='%s', email='%s') WHERE uid = %d;",
						$this->first_name,
						$this->last_name,
						$this->email,
						$this->id);
						
		//now proceed to associated role updates..we reset all mappings to update
		$transaction[] = sprintf("DELETE FROM user_role WHERE uid = %d;", $this->id);
		
		//then we re insert all user-role mappings...based on the active user roles in obj
		foreach($this->roles as $role) {
			$role_id = $role->get_id();
			$transaction[] = sprintf("INSERT INTO user_role (uid,rid) VALUES (%d,%d);", $this->id, $role_id);
		}
		
		//now execute the transaction
		DBHandler::do_transaction($transaction);

*/

}







function get_id(){
	return $this->id;
}


function set_id($id){
	$this->id = $id;
}

function get_bname(){
	return $this->bname;
}


function set_bname($bname){
	$this->bname= $bname;
}

function get_baddress(){
	return $this->baddress;
}


function set_baddress($baddress){
	$this->baddress = $baddress;
}

function get_tel(){
	return $this->tel;
}


function set_tel($tel){
	$this->tel = $tel;
}

function get_website(){
	return $this->website;
}


function set_website($website){
	$this->website = $website;
}

function get_fb_url(){
	return $this->fb_url;
}


function set_fb_url($fb_url){
	$this->fb_url = $fb_url;
}

function get_categories(){
	return $this->categories;
}


function set_categories($categories){
	$this->categories = $categories;
}


function get_description(){
	return $this->description;
}


function set_description($description){
	$this->description = $description;
}


function get_email(){
	return $this->email;
}


function set_email($email){
	$this->email = $email;
}
















}
?>