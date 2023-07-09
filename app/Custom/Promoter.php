<?php
namespace App\Custom;

use App\Repositories\JobRepository;
use Illuminate\Support\Facades\DB;

class Promoter {
    public $costperapplication;
    public $costperclick;
    public $costperimpression;

	function __construct(){
		$this->costperimpression = 50;
		$this->costperclick = 150;
		$this->costperapplication = 200;
	}
	
	function callPeter(){
		return $GLOBALS['costperimpression'];
	}
	function randomProm(){ // this function will return a random promotion id which will be displayed
		//session_start();
		if(isset($_GET['data'])){
            $proms = DB::table('job_promotions')->where('Job_ID', $_GET['data'])->where('Available_balance', '>=', 100)->where('Status', 'Active')->inRandomOrder()->first();
			$proms = "SELECT PromotionId FROM job_promotions WHERE (Job_ID != ".$_GET['data']." AND Available_balance >= 100 AND Status = 'Active')";
		}else{
            $proms = DB::table('job_promotions')->where('Available_balance', '>=', 100)->where('Status', 'Active')->inRandomOrder()->first();
			//$proms = "SELECT PromotionId FROM job_promotions WHERE (Available_balance >= 100 AND Status = 'Active')";
		}
		return $proms;
	}

	//echo randomProm();
	function targetedProm(){
		//session_start();
		$viewedJobs = JobRepository::viewedJobs();
		if(count($viewedJobs)){
			//echo json_encode($_SESSION['viewedJobs']);
			$queryid = ""; // this variable will store the sql statement that will get the details of the job ids
			foreach($viewedJobs as $viewedjob){ // prepare a statement that will be used to query for all the jobs with the respective ids
				$queryid .= "jobs.id =".$viewedjob." OR ";
			}
			$titles = array(); // this will hold the job titles of jobs from the viewedJobs session variable
			$sampleCategories = array(); // this will hold categories of jobs from the viewedJobs session variable
			$queryid = substr($queryid, 0, -4); // substr removes the last OR from the for each loop
			$sqljobs = "SELECT Job_title, Category FROM jobs WHERE ".$queryid;
			$resjobs = $GLOBALS['conn']->query($sqljobs);
			while($job = $resjobs->fetch_assoc()){
				array_push($titles, $job['Job_title']);
				$cats = json_decode($job['Category']); 
				if(is_array($cats) AND count($cats)>0){
					foreach($cats as $cat){ 
						if(!is_numeric(array_search($cat, $sampleCategories))){
							array_push($sampleCategories, $cat);
						}
					}
				}
			}
			$jobnamePromote = ""; // this will be the statement that will be used to query for jobs related to names in the database
			foreach($titles as $title){
				$jobname = explode(" ", $title);
				foreach($jobname as $name){
					$prepositions = array("and", "or", "in", "at", "of");
					if(!is_numeric(array_search($name, $prepositions))){
						$jobnamePromote .= "jobs.Job_title like '%$name%' OR ";
					}
				}
			}
			$catPromote = "";
			if(is_array($sampleCategories) and count($sampleCategories)>0){
				foreach($sampleCategories as $sampleCategory){
					$catPromote .= "jobs.Category = '$sampleCategory' OR ";
				}
				$jobnamePromote = substr($jobnamePromote, 0, -4); // removes the last OR
				$catPromote = substr($catPromote, 0, -4); // removes the last OR
				$catPromote = " OR ".$catPromote;
			}
			
			if($catPromote == ""){
				$jobnamePromote = substr($jobnamePromote, 0, -4); // removes the last OR
			}
			
			// now query and get all the jobs that fit in the criteria of the variable jobnamePromote and catPromote from the database 
			// we will inner join jobs table with job_promotions table
			
			$toProm = "SELECT PromotionID, Job_ID, job_promotions.Status as status FROM job_promotions INNER JOIN jobs ON jobs.ID = job_promotions.Job_ID WHERE (".$jobnamePromote.$catPromote." AND job_promotions.Available_balance >= 100 AND job_promotions.Status = 'Active')";
			$toPromRes = $GLOBALS['conn']->query($toProm);
			/* if($toPromRes->num_rows>0){
			return $toProm;
			}else{
				return $GLOBALS['conn']->error;
			} */
			if($toPromRes->num_rows>0){
				while($promo = $toPromRes->fetch_assoc()){
					if(!isset($_GET['data']) OR (isset($_GET['data']) AND $_GET['data']!=$promo['Job_ID'])){
						if(strtolower($promo['status'])=="active"){
							array_push($GLOBALS['availableproms'], $promo['PromotionID']);
						}
					}
				}
				if(!empty($GLOBALS['availableproms'])){
                    return $GLOBALS['availableproms'][array_rand($GLOBALS['availableproms'], 1)];
                }

			}else{
				//return false;
				return $GLOBALS['conn']->error;
			}	
		}else{
			return $this->randomProm();
		}
	}
	function loggedTargetedProm(){
		//session_start();
		// for this function to run then the user has to be logged in and the username session has to be set
		if(isset($_SESSION['username'])){
			$username = $_SESSION['username'];
			$sqluser = "SELECT * FROM subscribers WHERE username = '$username'";
			$resuser = $GLOBALS['conn']->query($sqluser);
			$user = $resuser->fetch_assoc();
			$title = $user['proffesional_title'];
			$location = $user['location'];
			$experience = json_decode($user['Experience']);
			$skills = $user['skills'];
			
			if(isset($_GET['data'])){
				$proms = "SELECT job_promotions.PromotionID, job_promotions.Professional_title, job_promotions.Location AS promLocation, jobs.Location, jobs.Job_title
						  FROM job_promotions INNER JOIN jobs ON jobs.ID = job_promotions.Job_ID 
						  WHERE (job_promotions.Job_ID != ".$_GET['data']." AND job_promotions.Available_balance >= 100 AND job_promotions.Status = 'Active')";
			}else{
				$proms = "SELECT job_promotions.PromotionID, job_promotions.Professional_title, job_promotions.Location AS promLocation, jobs.Location, jobs.Job_title
						  FROM job_promotions INNER JOIN jobs ON jobs.ID = job_promotions.Job_ID 
						  WHERE (job_promotions.Available_balance >= 100 AND job_promotions.Status = 'Active')";
			}
			// conditioning the sql statement to match with the identified criteria
			$locationcond = "job_promotions.Location LIKE '%".$location."%' OR job_promotions.Location IS NULL OR jobs.Location LIKE '%".$location."%'";
			$proffessions = explode(",", $title);
			$proffcond = "";
			foreach($proffessions as $proffession){
				$prepositions = array("and", "or", "in", "at", "of", "&");
				if(!is_numeric(array_search($proffession, $prepositions))){
					$proffcond .= "job_promotions.Professional_title LIKE '%".$proffession."%' OR jobs.Job_title LIKE '%".$proffession."%'";
				}
			}
			$res = $GLOBALS['conn']->query($proms);
			$similar = "";
			while($prom = $res->fetch_assoc()){
				// find the similary of the the using the similar_text method put the returned number over the length of the first text to find how much percentage of similarity
				// if the percentage happens to be greater than 45 percent then this is probably a good match so we can show such promotion
				// we'll therefore add the promotion id to the availableproms variable so that will be returned
				
				/* creating eligibility variable which will be an array and will store the return values of similarity in terms of percentage of the original
				   We'll use this varible to if the user similarity percentage is greater than 45 to decide if the user is eligible for the respective promotion
				*/
				$eligibility = array();
				if(strlen($location)>0 AND strlen($prom['Location'])>0){ // this condition states that both variable under comparison should not be empty
					array_push($eligibility, (similar_text($location, $prom['Location']))*100/strlen($location));
				}
				if(strlen($location)>0 AND strlen($prom['promLocation'])>0){ 
					array_push($eligibility,(similar_text($location, $prom['promLocation']))*100/strlen($location));
				}
				if(strlen($title)>0 AND strlen($prom['Job_title'])>0){ 
					array_push($eligibility,(similar_text($title, $prom['Job_title']))*100/strlen($title));
				}
				if(strlen($title)>0 AND strlen($prom['Professional_title'])>0){
					array_push($eligibility,(similar_text($title, $prom['Professional_title']))*100/strlen($title));
				}
				if(is_array($experience) AND count($experience)>0){
					for($x = 1; $x<=count($experience)-4; $x+=5){
						array_push($eligibility, (similar_text($title, $experience[$x], $percent))*100/strlen($title));
					}
					//$titleExpSimilar = (similar_text($title, $experience[1], $percent))*100/strlen($title);
				}
				// if the user eligibility for the promotion is greater than 45% then add the promotion id to the availableproms variable
				if(max($eligibility)>=45){
					array_push($GLOBALS['availableproms'], $prom['PromotionID']);
				}
			}
			//return $GLOBALS['conn']->error;
			//return $similar.$location;
			//return max($eligibility).$experience[1].$title.$percent;
			return $GLOBALS['availableproms'][array_rand($GLOBALS['availableproms'], 1)];
		}
	}
	//loggedTargetedProm();
	
	function promotionFetch($promID){
        if (session_status() == PHP_SESSION_NONE){
            session_start();
        }
		if(!isset($_SESSION['prom-impressions'])){ // this will hold the ids of all promotions that have been served to the user to avoid double charging
			$_SESSION['prom-impressions'] = array();
		}
		
		$this->promID = $promID;
		$sql = "SELECT jobs.ID, jobs.Job_title, jobs.Company_name, jobs.Job_summary, jobs.Company_name, jobs.Location, job_promotions.PromotionID 
				FROM job_promotions
				INNER JOIN jobs ON jobs.ID = job_promotions.Job_ID 
				WHERE job_promotions.PromotionID = ".$promID;

		$res = $GLOBALS['conn']->query($sql);
		if($res->num_rows>0){
			//return $GLOBALS['conn']->error."some rows";
		$promo = $res->fetch_assoc();
		if(isset($_SESSION['username']) OR isset($_SESSION['company'])){
			//$link = $GLOBALS['resolver']."job-page-after-login.php?data=".$promo['ID']."&promotion=".$promo['PromotionID'];
			$link = $GLOBALS['resolver']."ads-trck.php?data=".urlencode(base64_encode($promo['ID']))."&promotion=".urlencode(base64_encode($promo['PromotionID']));
		}else{
			//	$link = $GLOBALS['resolver']."job-page.php?data=".$promo['ID']."&prom=".$promo['PromotionID'];
			$link = $GLOBALS['resolver']."ads-trck.php?data=".urlencode(base64_encode($promo['ID']))."&promotion=".urlencode(base64_encode($promo['PromotionID']));
		}	
		$details = array("Job_ID"=>$promo['ID'], "Job_Title"=>$promo['Job_title'], "Company"=>$promo['Company_name'], "PromotionID"=>$promo['PromotionID'], "Location"=>$promo['Location'], "Link"=>$link, "Summary"=>$promo['Job_summary']);
		if(!is_numeric(array_search($promID, $_SESSION['prom-impressions']))){
			// if the promotion id is not found in the impressions sessions variable then charging can be done since it will be the first time
			$charge = "UPDATE job_promotions 
					   SET Available_balance = Available_balance - ".$GLOBALS['costperimpression']."
					   WHERE PromotionID = $promID";
			$rescharge = $GLOBALS['conn']->query($charge);
			if($rescharge){
				// if the charge has successfuly been done then execute the logging function to record the transaction
				// we'll then add the promotion id into prom-impressions session variable so that the next time in this session the same promotion is served the advertiser wont be charged
				array_push($_SESSION['prom-impressions'], $promID);
				$this->promotionLogging($promID, "Impression");
			}
		}
		return $details;
		}else{
			return $GLOBALS['conn']->error;
		}
		
		//return $this->callPeter();
	}
	
	function promotionLogging($promID, $activity){
		if(strtolower($activity) == "impression"){
			$amount = $GLOBALS['costperimpression'];
		}
		if(strtolower($activity) == "view"){
			$amount = $GLOBALS['costperclick'];
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		$page =  $_SERVER['REQUEST_URI'];
		// this function has two parameters the first is the promotion id and the second is the activity type such as impression or click or application
		// the activity will be recorded in the promotion log
		session_start();
		$sql = "INSERT INTO promotion_logs (`Promotion_ID`, `Activity_type`, `Amount`, `page`, `IP_address`) VALUES ('".$promID."', '".$activity."', '".$amount."', '".$page."', '".$ip."')";
		$res = $GLOBALS['conn']->query($sql);
		if($res){
			//return true;
		}else{
			//return $GLOBALS['conn']->error;
		}
	}
	
	function viewsCounter($promID){
		if(!isset($_SESSION['viewed-promotions'])){// if the session variable for viewed promotion is not set then set it here
			$_SESSION['viewed-promotions'] = array();
		}else if(!is_numeric(array_search($promID, $_SESSION['viewed-promotions']))){
			// if the viewed promotion session variable is set but the promotion is not in the array then add the promotion into the array
			// we are also going to charge the promoter the amount as per cost per click and log the information into the database
			array_push($_SESSION['viewed-promotions'], $promID);
			$charge = "UPDATE job_promotions 
					   SET Available_balance = Available_balance - ".($GLOBALS['costperclick']-$GLOBALS['costperimpression'])."
					   WHERE PromotionID = $promID";
			$rescharge = $GLOBALS['conn']->query($charge);
			if($rescharge){
				// if the charge has successfuly been done then execute the logging function to record the transaction
				$this->promotionLogging($promID, "View");
			}else{
				return $GLOBALS['conn']->error;
			}
		}
	}
}