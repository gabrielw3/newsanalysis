<?php

class UserController {

   function UserController() // constructor
   {
    //constructor is empty for now
   }

   function manage_users() {
		//here is where we trigger and output the view to manage users
		header("Location:manage-users.php");
   }
   
   function manage_roles() {
		//here is where we trigger and output the view to manage roles
		header("Location:manage-roles.php");
   }
   
   function manage_privileges() {
		//here is where we trigger and output the view to manage privileges
		header("Location:manage-privileges.php");
   }
   
 function get_user() {
	//gets the active user object from the session ...if any
	session_start();
	if(isset($_SESSION['user'])) return $_SESSION['user'];
	else return null;
   }

   function create($form_values)
   {
      // creates user in the db

   	$errors = $this->create_validate($form_values);

		if(!empty($errors)) {
			session_start();
			
			//we have detected errors and send them back to the user's signup form through the session...
			$_SESSION['signup_errors'] = $errors;
			//we also send any pre-entered form values back as well...
			//execpt the password...
			unset($form_values['password']);
			$_SESSION['signup_values'] = $form_values;
			header("Location:newuser.php");
		}

		else {
			
		
			//we have no errors...we proceed with creation
			//we use the model to do the actual creation...
			$user_model = new UserModel();
			$user_model->set_username($form_values['username']);
			$user_model->set_firstname($form_values['firstname']);
			$user_model->set_lastname($form_values['lastname']);
			$user_model->set_email($form_values['email']);
			$user_model->set_password($form_values['password']);

			$userObj = $user_model->insert(); //this does the SQL insert...

			if($userObj != false) {
				//once created, log them in...
				$this->login($form_values['username'], $form_values['password']);
				header("Location:main.php");
   			}else{
   				//we had a sign-up error...diagnose
				unset($form_values['password']);
				$_SESSION['signup_values'] = $form_values;
				header("Location:main.php");
   			}
   		}
   	}






   function login($username, $password)
   {
      // checks against db, does login procedures
	  if($this->authenticate($username, $password)) {
		//start the session for the user...
		session_start();
		//instantiate the UserModel object
		$user = new UserModel($username);
		//set the user object to the session...
		$_SESSION['user'] = $user;
		//we tell the system that we authenticated the user
		return true;
	  } else {
		//we tell the system that we could not..
		return false;
	  }
   }
   static function authenticate($u, $p) {
	  $authentic = false;
	  // check against db
	//  if($u == 'admin' && $p == 'admin') $authentic = true;
	//  return $authentic;

	  $query = sprintf("SELECT password FROM users WHERE username = '%s'", $u);
	  $result = DBHandler::do_query($query);

	  if($result->num_rows == 0){
	  	//User not found
	  	
	  }

	  $userData = mysqli_fetch_array($result, MYSQL_ASSOC);

	  $hash = sha1($p);

	  if($hash != $userData['password'])//incorrect password, redirect to login form
	  {
	  	$authentic = false;
	  	return $authentic;
	  }else{
	  	$authentic = true;
	  	return $authentic;
	  }


}

function create_validate($form_values){
	$firstname = trim($_REQUEST['firstname']);
$lastname = trim($_REQUEST['lastname']);
$email = trim($_REQUEST['email']);
$password = $_REQUEST['password'];
$confirmpassword = $_REQUEST['confirmpassword'];
$username = trim($_REQUEST['username']);


$errors = array();

if($firstname) {
    if(!preg_match("/[a-zA-Z]+/",$firstname)) $errors['firstname'] = "You must enter a valid first name";
  } else {
    $errors['firstname'] = "You must enter your first name";
  }

if($lastname) {
    if(!preg_match("/[a-zA-Z]+/",$lastname)) $errors['lname'] = "You must enter a valid last name";
  } else {
    $errors['lname'] = "You must enter your last name";
  }
  
if($email) {
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/",$email)) {
      $errors['email'] = "You must enter a valid email address";
    }
  } else {
    $errors['email'] = "You must enter your email address";
  }
  
if(!$password) $errors['password'] = "You must enter a password";
if($password != $confirmpassword) $errors['password'] = "Your password doesn't match. Please enter it again";

return $errors;

}
   function logout()
   {
      // does logout procedures
	  session_start();
	  session_destroy();
   }
}
?>