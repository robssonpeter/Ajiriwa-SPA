<?php

namespace App\Custom;

use App\Repositories\JobRepository;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as MessagingNotification;
use Kutia\Larafirebase\Messages\FirebaseMessage;
use PHPMailer\PHPMailer\PHPMailer;
use Request;
use Spatie\MediaLibrary\Models\Media;

class Promoter
{
	public $costperapplication;
	public $costperclick;
	public $costperimpression;

	function __construct()
	{
		$this->costperimpression = 50;
		$this->costperclick = 150;
		$this->costperapplication = 200;
	}

	function callPeter()
	{
		return $GLOBALS['costperimpression'];
	}
	function randomProm()
	{ // this function will return a random promotion id which will be displayed
		//session_start();
		if (isset($_GET['data'])) {
			$proms = DB::table('job_promotions')->where('Job_ID', $_GET['data'])->where('Available_balance', '>=', 100)->where('Status', 'Active')->inRandomOrder()->first();
			$proms = "SELECT PromotionId FROM job_promotions WHERE (Job_ID != " . $_GET['data'] . " AND Available_balance >= 100 AND Status = 'Active')";
		} else {
			$proms = DB::table('job_promotions')->where('Available_balance', '>=', 100)->where('Status', 'Active')->inRandomOrder()->first();
			//$proms = "SELECT PromotionId FROM job_promotions WHERE (Available_balance >= 100 AND Status = 'Active')";
		}
		return $proms;
	}

	//echo randomProm();
	function targetedProm()
	{
		//session_start();
		$viewedJobs = JobRepository::viewedJobs();
		if (count($viewedJobs)) {
			//echo json_encode($_SESSION['viewedJobs']);
			$queryid = ""; // this variable will store the sql statement that will get the details of the job ids
			foreach ($viewedJobs as $viewedjob) { // prepare a statement that will be used to query for all the jobs with the respective ids
				$queryid .= "jobs.id =" . $viewedjob . " OR ";
			}
			$titles = array(); // this will hold the job titles of jobs from the viewedJobs session variable
			$sampleCategories = array(); // this will hold categories of jobs from the viewedJobs session variable
			$queryid = substr($queryid, 0, -4); // substr removes the last OR from the for each loop
			$sqljobs = "SELECT Job_title, Category FROM jobs WHERE " . $queryid;
			$resjobs = $GLOBALS['conn']->query($sqljobs);
			while ($job = $resjobs->fetch_assoc()) {
				array_push($titles, $job['Job_title']);
				$cats = json_decode($job['Category']);
				if (is_array($cats) and count($cats) > 0) {
					foreach ($cats as $cat) {
						if (!is_numeric(array_search($cat, $sampleCategories))) {
							array_push($sampleCategories, $cat);
						}
					}
				}
			}
			$jobnamePromote = ""; // this will be the statement that will be used to query for jobs related to names in the database
			foreach ($titles as $title) {
				$jobname = explode(" ", $title);
				foreach ($jobname as $name) {
					$prepositions = array("and", "or", "in", "at", "of");
					if (!is_numeric(array_search($name, $prepositions))) {
						$jobnamePromote .= "jobs.Job_title like '%$name%' OR ";
					}
				}
			}
			$catPromote = "";
			if (is_array($sampleCategories) and count($sampleCategories) > 0) {
				foreach ($sampleCategories as $sampleCategory) {
					$catPromote .= "jobs.Category = '$sampleCategory' OR ";
				}
				$jobnamePromote = substr($jobnamePromote, 0, -4); // removes the last OR
				$catPromote = substr($catPromote, 0, -4); // removes the last OR
				$catPromote = " OR " . $catPromote;
			}

			if ($catPromote == "") {
				$jobnamePromote = substr($jobnamePromote, 0, -4); // removes the last OR
			}

			// now query and get all the jobs that fit in the criteria of the variable jobnamePromote and catPromote from the database 
			// we will inner join jobs table with job_promotions table

			$toProm = "SELECT PromotionID, Job_ID, job_promotions.Status as status FROM job_promotions INNER JOIN jobs ON jobs.ID = job_promotions.Job_ID WHERE (" . $jobnamePromote . $catPromote . " AND job_promotions.Available_balance >= 100 AND job_promotions.Status = 'Active')";
			$toPromRes = $GLOBALS['conn']->query($toProm);
			/* if($toPromRes->num_rows>0){
			return $toProm;
			}else{
				return $GLOBALS['conn']->error;
			} */
			if ($toPromRes->num_rows > 0) {
				while ($promo = $toPromRes->fetch_assoc()) {
					if (!isset($_GET['data']) or (isset($_GET['data']) and $_GET['data'] != $promo['Job_ID'])) {
						if (strtolower($promo['status']) == "active") {
							array_push($GLOBALS['availableproms'], $promo['PromotionID']);
						}
					}
				}
				if (!empty($GLOBALS['availableproms'])) {
					return $GLOBALS['availableproms'][array_rand($GLOBALS['availableproms'], 1)];
				}
			} else {
				//return false;
				return $GLOBALS['conn']->error;
			}
		} else {
			return $this->randomProm();
		}
	}
	function loggedTargetedProm()
	{
		//session_start();
		// for this function to run then the user has to be logged in and the username session has to be set
		if (isset($_SESSION['username'])) {
			$username = $_SESSION['username'];
			$sqluser = "SELECT * FROM subscribers WHERE username = '$username'";
			$resuser = $GLOBALS['conn']->query($sqluser);
			$user = $resuser->fetch_assoc();
			$title = $user['proffesional_title'];
			$location = $user['location'];
			$experience = json_decode($user['Experience']);
			$skills = $user['skills'];

			if (isset($_GET['data'])) {
				$proms = "SELECT job_promotions.PromotionID, job_promotions.Professional_title, job_promotions.Location AS promLocation, jobs.Location, jobs.Job_title
						  FROM job_promotions INNER JOIN jobs ON jobs.ID = job_promotions.Job_ID 
						  WHERE (job_promotions.Job_ID != " . $_GET['data'] . " AND job_promotions.Available_balance >= 100 AND job_promotions.Status = 'Active')";
			} else {
				$proms = "SELECT job_promotions.PromotionID, job_promotions.Professional_title, job_promotions.Location AS promLocation, jobs.Location, jobs.Job_title
						  FROM job_promotions INNER JOIN jobs ON jobs.ID = job_promotions.Job_ID 
						  WHERE (job_promotions.Available_balance >= 100 AND job_promotions.Status = 'Active')";
			}
			// conditioning the sql statement to match with the identified criteria
			$locationcond = "job_promotions.Location LIKE '%" . $location . "%' OR job_promotions.Location IS NULL OR jobs.Location LIKE '%" . $location . "%'";
			$proffessions = explode(",", $title);
			$proffcond = "";
			foreach ($proffessions as $proffession) {
				$prepositions = array("and", "or", "in", "at", "of", "&");
				if (!is_numeric(array_search($proffession, $prepositions))) {
					$proffcond .= "job_promotions.Professional_title LIKE '%" . $proffession . "%' OR jobs.Job_title LIKE '%" . $proffession . "%'";
				}
			}
			$res = $GLOBALS['conn']->query($proms);
			$similar = "";
			while ($prom = $res->fetch_assoc()) {
				// find the similary of the the using the similar_text method put the returned number over the length of the first text to find how much percentage of similarity
				// if the percentage happens to be greater than 45 percent then this is probably a good match so we can show such promotion
				// we'll therefore add the promotion id to the availableproms variable so that will be returned

				/* creating eligibility variable which will be an array and will store the return values of similarity in terms of percentage of the original
				   We'll use this varible to if the user similarity percentage is greater than 45 to decide if the user is eligible for the respective promotion
				*/
				$eligibility = array();
				if (strlen($location) > 0 and strlen($prom['Location']) > 0) { // this condition states that both variable under comparison should not be empty
					array_push($eligibility, (similar_text($location, $prom['Location'])) * 100 / strlen($location));
				}
				if (strlen($location) > 0 and strlen($prom['promLocation']) > 0) {
					array_push($eligibility, (similar_text($location, $prom['promLocation'])) * 100 / strlen($location));
				}
				if (strlen($title) > 0 and strlen($prom['Job_title']) > 0) {
					array_push($eligibility, (similar_text($title, $prom['Job_title'])) * 100 / strlen($title));
				}
				if (strlen($title) > 0 and strlen($prom['Professional_title']) > 0) {
					array_push($eligibility, (similar_text($title, $prom['Professional_title'])) * 100 / strlen($title));
				}
				if (is_array($experience) and count($experience) > 0) {
					for ($x = 1; $x <= count($experience) - 4; $x += 5) {
						array_push($eligibility, (similar_text($title, $experience[$x], $percent)) * 100 / strlen($title));
					}
					//$titleExpSimilar = (similar_text($title, $experience[1], $percent))*100/strlen($title);
				}
				// if the user eligibility for the promotion is greater than 45% then add the promotion id to the availableproms variable
				if (max($eligibility) >= 45) {
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

	function promotionFetch($promID)
	{

		if (!session()->has("prom-impressions")) { // this will hold the ids of all promotions that have been served to the user to avoid double charging
			session()->put('prom-impressions', array());
		}

		$this->promID = $promID;
		$sql = "SELECT jobs.ID, jobs.Job_title, jobs.Company_name, jobs.Job_summary, jobs.Company_name, jobs.Location, job_promotions.PromotionID 
				FROM job_promotions
				INNER JOIN jobs ON jobs.ID = job_promotions.Job_ID

				WHERE job_promotions.PromotionID = " . $promID;
		$selection = [
			'jobs.id',
			'jobs.title',
			'companies.name as company_name',
			'jobs.location',
			'jobs.description',
			'job_promotions.PromotionID',
			'companies.logo'
		];

		$res = DB::table('job_promotions')
			->where('job_promotions.PromotionID', $promID)
			->join('jobs', 'jobs.id', 'job_promotions.Job_ID')
			->join('companies', 'companies.id', 'jobs.company_id')
			->select($selection)
			->first();
		$session = session()->get('prom-impressions');
		// get the logo of the company
		//dd($res->logo);
		if (strlen($res->logo)) {
			$logo_media = Media::find($res->logo);
		}
		if ($res) {
			//return $GLOBALS['conn']->error."some rows";
			$promo = $res;
			//	$link = $GLOBALS['resolver']."job-page.php?data=".$promo['ID']."&prom=".$promo['PromotionID'];
			$link = env('APP_URL') . "/ads-trck.php?data=" . urlencode(base64_encode($promo->id)) . "&promotion=" . urlencode(base64_encode($promo->PromotionID));
			$details = array("Job_ID" => $promo->id, "Job_Title" => $promo->title, "Company" => $promo->company_name, "PromotionID" => $promo->PromotionID, "Location" => $promo->location, "Link" => $link, "Summary" => $promo->description);
			if (!is_numeric(array_search($promID, $session))) {
				// if the promotion id is not found in the impressions sessions variable then charging can be done since it will be the first time
				$charge = DB::table('job_promotions')
					->where('PromotionID', $promID)
					->decrement('Available_balance', $this->costperimpression);

				if ($charge) {
					// if the charge has successfuly been done then execute the logging function to record the transaction
					// we'll then add the promotion id into prom-impressions session variable so that the next time in this session the same promotion is served the advertiser wont be charged
					array_push($session, $promID);
					session()->put('prom-impressions', $session);
					$this->promotionLogging($promID, "Impression");
				}
			}
			if (isset($logo_media) && $logo_media) {
				$details['Logo'] = $logo_media->getUrl();
			}
			return $details;
		} else {
			return $GLOBALS['conn']->error;
		}

		//return $this->callPeter();
	}

	function promotionLogging($promID, $activity)
	{
		if (strtolower($activity) == "impression") {
			$amount = $this->costperimpression;
		}
		if (strtolower($activity) == "view") {
			$amount = $this->costperclick;
		}
		if (strtolower($activity) == "application") {
			$amount = $this->costperapplication;
		}
		$ip = Request::server('REMOTE_ADDR');
		$page = Request::server('REQUEST_URI');
		// this function has two parameters the first is the promotion id and the second is the activity type such as impression or click or application
		// the activity will be recorded in the promotion log
		session_start();
		$sql = "INSERT INTO promotion_logs (`Promotion_ID`, `Activity_type`, `Amount`, `page`, `IP_address`) VALUES ('" . $promID . "', '" . $activity . "', '" . $amount . "', '" . $page . "', '" . $ip . "')";
		$data = [
			'Promotion_ID' => $promID,
			'Activity_type' => $activity,
			'Amount' => $amount,
			'page' => $page,
			'IP_address' => $ip,
			'audience' => ''
		];
		$queried = DB::table('promotion_logs')
			->insert($data);
		if ($queried) {
			//return true;
		} else {
			//return $GLOBALS['conn']->error;
		}
	}

	function viewsCounter($promID)
	{

		if (!session()->has('viewed-promotions')) { // if the session variable for viewed promotion is not set then set it here
			session()->put('viewed-promotions', array());
		} else if (!is_numeric(array_search($promID, session()->get('viewed-promotions')))) {
			// if the viewed promotion session variable is set but the promotion is not in the array then add the promotion into the array
			// we are also going to charge the promoter the amount as per cost per click and log the information into the database
			$session = session()->get('viewed-promotions');
			array_push($session, $promID);

			$charge = DB::table('job_promotions')
				->where('PromotionID', $promID)
				->decrement('Available_balance', ($this->costperclick - $this->costperimpression));
			if ($charge) {
				// if the charge has successfuly been done then execute the logging function to record the transaction
				$this->promotionLogging($promID, "View");
			} else {
				return  $GLOBALS['conn']->error;
			}
		}
	}

	public static function promotionStatistics($promotion_id)
	{
		$data = [];
		$impressions = DB::table('promotion_logs')
			->where('Promotion_ID', $promotion_id)
			->where('Activity_type', 'Impression')
			->orderBy('id', 'DESC')
			->get();
		$labels = [];
		$impression_data = [
			'label' => 'Impressions',
			'backgroundColor' => '#4ade80',
			'borderColor' => '#4ade80',
			'data' => []
		];
		foreach ($impressions as $impression) {
			$date = Carbon::parse($impression->Time)->format('Y-m-d');
			if (!in_array($date, $labels)) {
				$labels[] = $date;
			}
			$index = array_search($date, $labels);
			if (!isset($impression_data['data'][$index])) {
				$impression_data['data'][] = 1;
			} else {
				$impression['data'][$index] += 1;
			}
		}
		return [
			'labels' => $labels,
			'impressions' => $impression_data
		];
	}

	public static function getChartData($promotion_id)
	{
		$distinctDates = DB::table('promotion_logs')
        ->select(DB::raw("DATE_FORMAT(`Time`, '%Y-%m-%d') as date"))
		->where('Promotion_ID', $promotion_id)
        ->distinct()
        ->pluck('date')
        ->toArray();

		$data = DB::table('promotion_logs')
			->select(DB::raw("DATE_FORMAT(`Time`, '%Y-%m-%d') as date"), 'Activity_type', DB::raw('count(*) as count'))
			->whereIn('Activity_type', ['Impression', 'View', 'Application'])
			->where('Promotion_ID', $promotion_id)
			->groupBy('date', 'Activity_type')
			->get();
		//return $data;
		$labels = [];
		$datasets = [
			['label' => 'Impressions', 'backgroundColor' => '#4ade80', 'borderColor' => '#4ade80', 'data' => array_fill(0, count($distinctDates), 0)],
			['label' => 'Views', 'backgroundColor' => '#f43f5e', 'borderColor' => '#f43f5e', 'data' => array_fill(0, count($distinctDates), 0)],
			['label' => 'Applications', 'backgroundColor' => '#020617', 'borderColor' => '#020617', 'data' => array_fill(0, count($distinctDates), 0)],
		];
		//return $datasets;
		foreach ($data as $entry) {
			// Extract date and activity type
			$date = $entry->date;
			$activityType = $entry->Activity_type;
			$count = $entry->count;

			// Add date to labels if not already present
			if (!in_array($date, $labels)) {
				$labels[] = $date;
			}

			$label_index = array_search($date, $labels);
			if(strtolower($activityType) == "impression"){
				$datasets[0]['data'][$label_index] = $count;
			}else if(strtolower($activityType) == "view"){
				$datasets[1]['data'][$label_index] = $count;
			}else if (strtolower($activityType) == "application"){
				$datasets[2]['data'][$label_index] = $count;
			}
		}

		return [
			'labels' => $labels,
			'datasets' => $datasets,
		];
	}

	public static function sendNotificationsToDevices(array $tokens, string $title, string $message, string $actionUrl, string $actionLabel)
	{
		$notifications = [];

		foreach ($tokens as $token) {
			$notification = \Kreait\Firebase\Messaging\Notification::create($title, $message)
				->withImageUrl("https://beta.ajiriwa.net/images/ajiriwa-new-logo.png");

			$notifications[] = CloudMessage::withTarget('token', $token)
				->withNotification($notification)->withFcmOptions([
					'link' => 'https://www.ajiriwa.net',
				]);
		}

		$messaging = app('firebase.messaging');
		$messaging->sendAll($notifications);
	}


	public static function pushNotification($token)
	{
		//$token = 'cdoaDfWFPuNL9lv6g5MUwT:APA91bF6Sp6yvmRXXLW27PvqDOXcdd8OOwQFH1EZl58rUU6YZrbi0kob8wswOI00AwnmHZrRD-UcFX099eYvfeXHswXLvzB4ZEnqYIxzj7QAP2bNAeZr0bD5XNPfyOgaCf8LnMWCVRUA';
		$notification = \Kreait\Firebase\Messaging\Notification::create('Testing', "Here is your test message");

		$message = CloudMessage::withTarget('token', $token)
			->withNotification($notification) // optional
			/* ->withData($data) */ // optional
		;


		$messaging = app('firebase.messaging');
		return $messaging->send($message);
		//return $message;
		/*$message = CloudMessage::withTarget('topic', 'a-topic')
            ->withNotification(Notification::create('Title', 'Body'))
            ->withData(['key' => '117362381735']);
        $messaging = app('firebase.messaging');
        return $messaging->send($message);*/
		/*$messaging = app('firebase.messaging');
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(Notification::create('Test', 'Hello Peter Congratulations on this my friend you did it')) // optional
            //->withData($data) // optional
        ;
        return $messaging->send($message);*/
		$messaging = app('firebase.messaging');
		$deviceTokens = $token;
		/*$message = CloudMessage::new();
        $message->withChangedTarget('token', $token)->withNotification(Notification::create('Test', 'Hello Peter Congratulations on this my friend you did it'));*/
		return $messaging->send($message);
		$sendReport = $messaging->sendMulticast($message, [$deviceTokens]);
		return response()->json([
			'Successful' => $sendReport->successes()->count(),
			'Failed' => $sendReport->failures()->count()
		]);
	}

	/**
	 * Send Mail used to send email to specified recepient using PHPMailer
	 * @param mixed $recipient
	 * @param mixed $subject
	 * @param string $body
	 * @param array $from - from email including title in format ['email' => '', 'title' => '']
	 * @param array $attachments - contains the links to attachments in format of [['name' => '', 'link'=>'']]
	 * @param array $cc - an array of emails
	 * @param array $reply_to - email address that will receive replies for the email with format like $from
	 * @return void
	 */
	public static function sendMail($recipient, $subject, $body, $from, $attachments = [], array $cc = [], $reply_to = [])
	{
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = 'smtp.1and1.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'info@ajiriwa.net'; //'accounts@ajiriwa.net';
		$mail->Password = '07570237Robsson!'; //'07570237';
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;
		$mail->setFrom($from['email'], $from['title'] ?? '');
		$mail->addAddress($recipient);
		if ($cc != []) {
			foreach ($cc as $cc_email) {
				$mail->addCC($cc_email);
			}
		}
		if ($reply_to)
			$mail->addReplyTo($reply_to['email'], $reply_to['title'] ?? '');

		$mail->isHTML(true);
		$mail->Subject = $subject;
		foreach ($attachments as $attachment) {
			$mail->AddAttachment(public_path($attachment['link']), $attachment['name']);
		}
		$mail->Body = $body;
		return $mail->send();
	}
}
