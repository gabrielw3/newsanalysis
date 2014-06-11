<?php 

class UserPrivilegeModel {

	private $id;
	private $name;
	
	function UserPrivilegeModel($pid = NULL) {
		if($pid != NULL) {
			//this means we need to load its values..
			$sql = sprintf("SELECT * FROM privilege WHERE pid = %d", $pid);
			$result = DBHandler::do_query($sql);
			if($result) {
				if(mysqli_num_rows($result) > 0) {
					//read and init this obj..
					$data = mysqli_fetch_assoc($result); //just grab the single row..
					$this->id = $data['pid'];
					$this->set_name($data['name']);
				}
			}
		}
	}
	
	public function get_id() {
		return $this->id;
	}
	
	public function get_name() {
		return $this->name;
	}
	
	public function set_name($name) {
		$this->name = $name;
	}
	
	public static function get_all_privileges() {
		//returns an array of all privilege objs
		$privileges = array();
		$sql = "SELECT * FROM privilege";
		$result = DBHandler::do_query($sql);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				while($data = mysqli_fetch_assoc($result)) {
					
					//we let the init in the constructor do the work for us..quite clean actually
					$privileges[] = new UserPrivilegeModel($data['pid']);
				
				}
			}
		}
		
		return $privileges;
	}
	
	public static function get_all_role_privileges($rid) {
		//returns an array of all privileges belonging to a role
		$privileges = array();
		
		$sql = sprintf("SELECT * FROM role_privilege WHERE rid = %d", $rid);
		$result = DBHandler::do_query($sql);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				while($data = mysqli_fetch_assoc($result)) {
					
					//we let the init in the constructor do the work for us..quite clean actually
					$privileges[] = new UserPrivilegeModel($data['pid']);
				
				}
			}
		}
		
		return $privileges;
	}
	
	public function insert() {
		//we create a new privilege record based on details saved in the instance vars...
		//we canmake sure there are no duplicates as well..
		$sql = sprinf("INSERT INTO privilege (name) VALUES('%s')", $this->get_name() );
		DBHandler::do_query($sql);
		
	}
	
	public function update() {
		//we update the current privilege record...
		$sql = sprinf("UPDATE privilege SET (name='%s') WHERE pid = %d", $this->get_name(), $this->get_id() );
		DBHandler::do_query($sql);
	}
}
?>
