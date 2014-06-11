<?php

class UserModel {
	private $id;
	private $username;
	private $firstname;
	private $lastname;
	private $email;
	private $password;
	private $confirmpassword;
	private $roles;
	private $date_created;

	function UserModel($username = NULL) {
		if($username == NULL) {
			//this means we are creating 
			//init the roles array
			$roles = array();
		} else {
			//this means we are loading from database...
			$this->username = $username;
			
			//we place a query here to init this model's values based on the username/id
			//make sure we do not load sensitive values...like password..
			$sql = sprintf("SELECT * FROM users WHERE username = '%s'", $username);
			$result = DBHandler::do_query($sql);
			if($result) {
				if(mysqli_num_rows($result) > 0) {
					//read and init this obj..
					$data = mysqli_fetch_assoc($result); //just grab the single row..
					$this->id = $data['uid'];
					$this->set_firstname($data['firstname']);
					$this->set_lastname($data['lastname']);
					$this->set_email($data['email']);
					$dtime = new DateTime($data['date_created']);
					$this->date_created = $dtime->format("jS , F Y");
					//$this->set_date($data['date_created']);
					$this->set_roles(UserRoleModel::get_all_user_roles($this->get_id()));
					//here we call the UserRoleModel's function to load all roles 
					
				}
			}
		}
		
	}
	
	public static function get_all_users() {
		$users = array();
		//returns an array of all users as user model objs
		$sql = sprintf("SELECT username FROM users");
		$result = DBHandler::do_query($sql);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				//read and user obj..
				while($data = mysqli_fetch_assoc($result)) {
					//we let the init in the constructor do the work for us..quite clean actually
					$users[] = new UserModel($data['username']);
					
				}
			}
		}
		
		return $users;
	}

	function get_id(){
		return $this->id;
	}

	function set_id($id){
		$this->id = $id;
	}

	function get_username() {
		return $this->username;
	}
	
	function set_username($username) {
		$this->username = $username;
	}

	function get_firstname(){
	return $this->firstname;
	}

	function set_firstname($firstname){
		$this->firstname = $firstname;
	}

	function get_lastname(){
	return $this->lastname;
	}

	function set_lastname($lastname){
		$this->lastname = $lastname;
	}

	function get_email(){
	return $this->email;
	}

	function set_email($email){
		$this->email = $email;
	}

	function get_password(){
	return $this->password;
	}

	function set_password($password){
		$this->password = $password;
	}

	public function get_roles() {
		return $this->roles;
	}
	
	public function set_roles($roles) {
		$this->roles = $roles;
	}

	public function get_date(){
		return $this->date_created;
	}

	public function set_date($date){
		$this->date_created = $date;
	}

public function insert() {
		//place a query here to insert.. all model values
		//first make sure no one has the same username...
		$test_user = new UserModel($this->username);
		if($test_user->get_id() != null) return false; //we have a user by this name already
		else {
			

file_put_contents('insertname.txt', 'entered info');



			$sql = sprintf("INSERT INTO users (username, password, firstname, lastname, email) VALUES ('%s', '%s', '%s', '%s', '%s')",
						$this->username,
						sha1($this->password), //never forget to encrypt the password before storing it in db...
						$this->firstname,
						$this->lastname,
						$this->email);
			
			DBHandler::do_query($sql);
			
			return new UserModel($this->username);
		}
	}



public function update() {
	
		//place a query here to update all model values as well as any associated roles..
		//we def need a transaction for this...
		
		$transaction = array();
		
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
	}

public function has_privilege($privilege) {
		//goes thru each role and respective PrivilegeModel, grabs its name and tests it against the function arg 'privilege'
		foreach($this->roles as $roleModel) {
			if($roleModel->contains_privilege($privilege)) return true;
			else continue;
		}
		return false;
	}

public static function get_username_sql($uid){
	$business = array();
	$sql = sprintf("SELECT * FROM users WHERE uid= '%s'", $uid);
	$result = DBHandler::do_query($sql);
	if($result){
		if(mysqli_num_rows($result) > 0){
$data = mysqli_fetch_assoc($result);
	
		}
	}

			return $data['username'];
}



}
?>