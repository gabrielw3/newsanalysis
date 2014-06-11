<?php

class ReviewModel{
private $userid;
private $rev_id;
private $summary;
private $content;
private $bname;
private $businessid;
private $rating;
private $date_posted;
public  $bid;

/*
function ReviewModel($businessname = NULL, $summary=NULL) {
			if($businessname == NULL && $summary == NULL){
//means we are creating
			} else{
				$this->bname = $bname
				

				$sql = sprintf("SELECT id FROM `business` WHERE `bname`= %s" LIMIT 1, $bname);
				$result = DBHandler::do_query($sql);

				if($result){
					if(mysqli_num_rows($result)>0){
						$bid = mysqli_fetch_assoc($result);//Grab ID of Business
						$businessid = set_businessid($bid['bid']);
							if(!isempty($businessid)){
								$sql = "SELECT * FROM `reviews` WHERE 'bid' = %s AND `summary` = %s "), $businessid, $summary;
								$result1 = DBHandler::do_query($sql);
									if($result1){
										if(mysqli_num_rows($result1) >0){
											$data = mysqli_fetch_assoc($result1);
											$this_rev_id = $data['uid'];
											$this->set_rating($data['rating']);
											$this->set_content($data['content']);
										}
									}
							}
					}
				}

			}

	}
*/

static function mysqli_result_made($res, $row, $field=0){
		$res-> data_seek($row);
		$datarow = $res->fetch_array();
		return $datarow[$field];
	}

function ReviewModel($rev_id = NULL){
	if ($rev_id == NULL){
		///we are creating
	}else{
		$this->rev_id = $rev_id;
		/*
		$sql = sprintf("SELECT * FROM business WHERE bname = '%s' LIMIT 1", $bname);
		$result = DBHandler::do_query($sql);
		$businessid = mysqli_fetch_assoc($result);//Grab ID of Business
		$this->bid = $businessid['bid']; */
		//$this->set_businessid($temp);
		//$temp2 = $this->get_businessid();
		//file_put_contents('temp.txt', $temp2);
		
	//	if($this->bid !=NULL){
			
			$sql = sprintf("SELECT * FROM reviews WHERE cid = '%s'", $this->rev_id);
				$result = DBHandler::do_query($sql);
					if($result){
						if(mysqli_num_rows($result)>0){
							$data = mysqli_fetch_assoc($result);
							$this->userid = $data['uid'];
							$this->bid = $data['bid'];
							$this->rev_id = $data['cid'];
							$dtime = new DateTime($data['date_posted']);

							$this->date_posted = $dtime->format("jS, F Y @ g:i a.");
							$this->content = $data['content'];
							$this->summary = $data['summary'];
							$this->rating = $data['rating'];
						}
					}
		//}
	}
}




/*
$tag_id_value = DBHandler::do_query($current_tag_id_sql);
	
$thought_id_value_result = mysqli_result_made($thought_id_value, 0);


*/

	 public static function get_all_reviews(){
	 	$reviews = array();
		$sql = sprintf("SELECT * from reviews");
	 	$result = DBHandler::do_query($sql);
	 	if($result){
			if(mysqli_num_rows($result)>0){
				while($data = mysqli_fetch_assoc($result)){
					$reviews[] = new ReviewModel($data['cid']);
	 			}
	 		}
		}
	 	return $reviews;
	 }
	
	function set_bid($bid){
		$this->bid = $bid;
	}

	function get_bid(){
		return $this->bid;
	}

	function set_userid($userid){
		$this->userid = $userid;
	}

	function get_userid(){
		return $this->userid;
	}

	function get_content() {
		return $this->content;
	}

	function set_content($content){
		$this->content = $content;
	}
	

	function set_summary($summary) {
		$this->summary = $summary;
	}

	function get_summary() {
		return $this->summary;
	}	

	function get_rev_id(){
		return $this->rev_id;
	}

	function set_bname($bname){
		$this->bname = $bname;
	}

	function get_bname(){
		return $this->bname;
	}

	function set_rating($rating){
		$this->rating = $rating;
	}

	function get_rating(){
		return $this->rating;
	}

	function set_date($date_posted){
		$this->date_posted = $date_posted;
	}

	function get_date(){
		return $this->date_posted;
	}

public function insert(){
//	$test_review = new ReviewModel($this->bname);
	
	if($this->get_rev_id() != null) return false;
	else{
		
		$time_posted = time();

		$sql = sprintf("INSERT INTO reviews (uid, bid,  content, summary, rating) VALUES ('%s', '%s',  '%s', '%s', '%s')", 
			$this->get_userid(),
			$this->get_bid(),
			 $this->get_content(), 
			 $this->get_summary(), 
			 $this->get_rating());

	DBHandler::do_query($sql);
			
			
	return true;

	}
}



public static function get_all_reviews_by_business($bname){

$reviews = array();
$sql = sprintf("SELECT rv.uid, rv.bid, rv.cid, rv.date_posted, rv.content, rv.summary, rv.rating
FROM users usr, reviews rv
WHERE usr.username =  'gabrielw3'
AND rv.uid = usr.uid
ORDER BY date_posted desc", $bname);
	 	$result = DBHandler::do_query($sql);
	 	if($result){
			if(mysqli_num_rows($result)>0){
				while($data = mysqli_fetch_assoc($result)){
					$reviews[] = new ReviewModel($data['cid']);
	 			}
	 		}
		}
	 	return $reviews;

}


public static function get_all_reviews_by_user($username){

$reviews = array();
$sql = sprintf("SELECT rv.uid, rv.bid, rv.cid, rv.date_posted, rv.content, rv.summary, rv.rating
FROM users usr, reviews rv
WHERE usr.username =  '%s'
AND rv.uid = usr.uid
ORDER BY date_posted desc ", $username);
	 	$result = DBHandler::do_query($sql);
	 	if($result){
			if(mysqli_num_rows($result)>0){
				while($data = mysqli_fetch_assoc($result)){
					$reviews[] = new ReviewModel($data['cid']);
	 			}
	 		}
		}
	 	return $reviews;

}


public static function get_all_reviews_by_user_count($username){

$reviews = array();
$sql = sprintf("SELECT rv.uid, rv.bid, rv.cid, rv.date_posted, rv.content, rv.summary, rv.rating
FROM users usr, reviews rv
WHERE usr.username =  '%s'
AND rv.uid = usr.uid
ORDER BY date_posted desc ", $username);
	 	$result = DBHandler::do_query($sql);
	 	if($result){
			if(mysqli_num_rows($result)>0){
				$num_of_reviews = mysqli_num_rows($result);
				return $num_of_reviews;
	 			}
	 		}
		}
	 	





public static function get_random_review(){
	$reviews = array();
	$sql = sprintf("SELECT * 
FROM reviews
ORDER BY RAND( ) 
LIMIT 0 , 1");
	 	$result = DBHandler::do_query($sql);
	 	if($result){
			if(mysqli_num_rows($result)>0){
				while($data = mysqli_fetch_assoc($result)){
					$reviews[] = new ReviewModel($data['cid']);
	 			}
	 		}
		}
	 	return $reviews;

}

public static function get_review($bid, $summary){
	$reviews = array();
	$sql = sprintf("SELECT * 
FROM reviews
WHERE bid='%s' AND summary='%s'
LIMIT 0 , 1", $bid, $summary);
	 	$result = DBHandler::do_query($sql);
	 	if($result){
			if(mysqli_num_rows($result)>0){
				while($data = mysqli_fetch_assoc($result)){
					$reviews[] = new ReviewModel($data['cid']);
	 			}
	 		}
		}
	 	return $reviews;

}


}

?>
