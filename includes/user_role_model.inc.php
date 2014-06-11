<?php 

class UserRoleModel {

	private $id;
	private $name;
	private $privileges;
	
	function UserRoleModel($rid = NULL) {
		//if $rid is null, then it means it's being used for creating a new role
		if($rid == NULL) {
			$privileges = array();
		} else {
			//if not, we init the RoleModel obj with details about the given role...
			$sql = sprintf("SELECT * FROM roles WHERE rid = %d", $rid);
			$result = DBHandler::do_query($sql);
			if($result) {
				if(mysqli_num_rows($result) > 0) {
					//read and init this obj..
					$data = mysqli_fetch_assoc($result); //just grab the single row..
					$this->id = $data['rid'];
					$this->set_name($data['name']);
					//here we call the UserPrivilegeModel's function to load all privileges belonging to role 
					$this->set_privileges(UserPrivilegeModel::get_all_role_privileges($this->get_id()));
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
	
	public function contains_privilege($privilege) {
		//goes thru each loaded PrivilegeModel, grabs its name and tests it against the function arg 'privilege'
		foreach($this->privileges as $privilegeModel) {
			if($privilegeModel->get_name() == $privilege) return true;
			else continue;
		}
		return false;
	}
	
	public function get_privileges() {
		return $this->privileges;
	}
	
	public function set_privileges($privileges) {
		$this->privileges = $privileges;
	}
	
	public static function get_all_roles() {
		//returns an array of all role objs
		$roles = array();
		$sql = "SELECT * FROM roles";
		$result = DBHandler::do_query($sql);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				while($data = mysqli_fetch_assoc($result)) {
					
					//we let the init in the constructor do the work for us..quite clean actually
					$roles[] = new UserRoleModel($data['rid']);
				
				}
			}
		}
		
		return $roles;
	}
	
	public static function get_all_user_roles($uid) {
		//returns an array of all role objs belonging to a specific user
		$user_roles = array();
		$sql = sprintf("SELECT * FROM user_role WHERE uid = %d", $uid);
		$result = DBHandler::do_query($sql);
		if($result) {
			if(mysqli_num_rows($result) > 0) {
				while($data = mysqli_fetch_assoc($result)) {
					
					//we let the init in the constructor do the work for us..quite clean actually
					$user_roles[] = new UserRoleModel($data['rid']);
				
				}
			}
		}
		
		return $user_roles;
	}
	
	public function insert() {
		//we create a new role record...
		//we can make sure it does not already exist as well...before we insert
		$sql = sprinf("INSERT INTO roles (name) VALUES('%s')", $this->get_name() );
		DBHandler::do_query($sql);
	}
	
	public function update() {
	
		$transaction = array();
		
		//we update the current role record...as well as any associated privileges...
		$transaction[] = sprinf("UPDATE roles SET (name='%s') WHERE rid = %d;", $this->get_name(), $this->get_id() );
		
		//we reset all role-privilege mappings that may already exist...
		$transaction[] = sprintf("DELETE FROM role_privilege WHERE rid = %d;", $this->id);
		
		//then we re insert all role-privilege mappings...based on the active privileges in obj
		foreach($this->privileges as $privilege) {
			$pid = $privilege->get_id();
			$transaction[] = sprintf("INSERT INTO role_privilege (rid,pid) VALUES (%d,%d);", $this->id, $pid);
		}
		
		//now execute the transaction
		DBHandler::do_transaction($transaction);
	}
}
?>
