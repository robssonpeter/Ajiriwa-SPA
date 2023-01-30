<?php

error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

use App\Models\Job;

ob_start();
$isoLastModifiedSite = "";
$newLine = "\n";
$indent = " ";

if (!$rootUrl) $rootUrl = "https://www.ajiriwa.net";

$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."<!--".$_SERVER['HTTP_USER_AGENT']."-->"."$newLine";


$urlsetOpen = "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\"	
xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"	
xsi:schemaLocation=\"http://www.google.com/schemas/sitemap/0.84	
http://www.google.com/schemas/sitemap/0.84/sitemap.xsd\">$newLine";
$urlsetValue = "";
$urlsetClose = "</urlset>$newLine";


function makeUrlString ($urlString) {
    return htmlentities($urlString, ENT_QUOTES, 'UTF-8'); 
}

function makeIso8601TimeStamp ($dateTime) {
    if (!$dateTime) {
        $dateTime = date('Y-m-d H:i:s');
    }
    if (is_numeric(substr($dateTime, 11, 1))) {
        $isoTS = substr($dateTime, 0, 10) ."T" 
                 .substr($dateTime, 11, 8) ."+00:00";
    }
    else {
        $isoTS = substr($dateTime, 0, 10);
    }
    return $isoTS;
}

function makeUrlTag ($url, $modifiedDateTime, $changeFrequency, $priority) {
    GLOBAL $newLine;
    GLOBAL $indent;
    GLOBAL $isoLastModifiedSite;
    $urlOpen = "$indent<url>$newLine";
    $urlValue = "";
    $urlClose = "$indent</url>$newLine";
    $locOpen = "$indent$indent<loc>";
    $locValue = "";
    $locClose = "</loc>$newLine";
    $lastmodOpen = "$indent$indent<lastmod>";
    $lastmodValue = "";
    $lastmodClose = "</lastmod>$newLine";
    $changefreqOpen = "$indent$indent<changefreq>";
    $changefreqValue = "";
    $changefreqClose = "</changefreq>$newLine";
    $priorityOpen = "$indent$indent<priority>";
    $priorityValue = "";
    $priorityClose = "</priority>$newLine";

    $urlTag	= $urlOpen;
    $urlValue     = $locOpen .makeUrlString("$url") .$locClose;
    if ($modifiedDateTime) {
     $urlValue .= $lastmodOpen .makeIso8601TimeStamp($modifiedDateTime) .$lastmodClose; 
     if (!$isoLastModifiedSite) { // last modification of web site
         $isoLastModifiedSite = makeIso8601TimeStamp($modifiedDateTime); 
     } 
    }
    if ($changeFrequency) {
     $urlValue .= $changefreqOpen .$changeFrequency .$changefreqClose; 
    }
    if ($priority) {
     $urlValue .= $priorityOpen .$priority .$priorityClose; 
    }
    $urlTag .= $urlValue;
    $urlTag .= $urlClose;
    return $urlTag;
}

$today = date("Y-m-d");
//Getting all the jobs from the database for indexing
//$sql =  "SELECT * FROM magic_keywords ORDER BY id DESC LIMIT 5";
/* $sql =  DB::table('magic_keywords')->orderBy('id', 'DESC')->limit(5)->get();

foreach($sql as $row){
    $pageUrl = "https://www.ajiriwa.net/jobs/".$row->uri;
    $pageLastModified = '';
    $pageChangeFrequency = "daily";
    $pagePriority = 0.8;
    $urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
} */


$today = date("Y-m-d");
//Getting all the jobs from the database for indexing
$sql =  Job::where('deadline', '>=', $today)->orderBy('created_at', 'DESC')->get();
die('hello');
foreach($sql as $row){
	$pageUrl = $row->old_id?"https://www.ajiriwa.net/job-page.php?data=".$row->old_id:route('job.view', $job->slug);
	$pageLastModified = $row->updated->at;
	$pageChangeFrequency = "daily";
	$pagePriority = 0.8;
	$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
}
die('hello');


//for the index pages both english and swahili
//for english
$pageUrl =  "https://www.ajiriwa.net/";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "hourly";
$pagePriority = 1.00;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//for Swahili
$pageUrl =  "https://www.ajiriwa.net/Sw";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "hourly";
$pagePriority = 1.00;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//About US
$pageUrl =  "https://www.ajiriwa.net/About.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "Yearly";
$pagePriority = 0.90;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//Browse Jobs
$pageUrl =  "https://www.ajiriwa.net/browse-jobs.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "hourly";
$pagePriority = 0.90;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//Job Seeker Login Page
$pageUrl =  "https://www.ajiriwa.net/my-account.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "never";
$pagePriority = 0.90;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//employer Login Page
$pageUrl =  "https://www.ajiriwa.net/employer-account.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "never";
$pagePriority = 0.90;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//employer Login Page
$pageUrl =  "https://www.ajiriwa.net/blog.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "weekly	";
$pagePriority = 0.90;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//add resume
$pageUrl =  "https://www.ajiriwa.net/add-resume.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "Yearly";
$pagePriority = 0.80;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//Contact us
$pageUrl =  "https://www.ajiriwa.net/contact.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "Yearly";
$pagePriority = 0.90;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//Password Recovery
$pageUrl =  "https://www.ajiriwa.net/password-recovery.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "Yearly";
$pagePriority = 0.70;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//jobs
$pageUrl =  "https://www.ajiriwa.net/jobs.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "Hourly";
$pagePriority = 0.70;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
//jobs by company
$pageUrl =  "https://www.ajiriwa.net/company-jobs.php";
$pageLastModified = date("Y-m-d h:i:sa");
$pageChangeFrequency = "Hourly";
$pagePriority = 0.70;
$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);


$today = date("Y-m-d");
//Getting all the keywords from the database for indexing
$sql =  "SELECT * FROM keywords ORDER BY ID DESC";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$pageUrl = "https://www.ajiriwa.net/search.php?search=".$row['keyword'];
	$pageLastModified = $today;
	$pageChangeFrequency = "daily";
	$pagePriority = 0.8;
	$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
}

// Getting all the key words for companies
$sql = "SELECT keyword FROM keywords_for_companies ORDER BY ID DESC";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$sqlcomp = "SELECT Company_name FROM jobs GROUP BY Company_name ORDER BY ID DESC";
	$rescomp = $conn->query($sqlcomp);
	while($comp = $rescomp->fetch_assoc()){
		$pageUrl = "https://www.ajiriwa.net/jobs.php?keyword=".$row['keyword']."&comp=".urlencode($comp['Company_name']);	
		$pageLastModified = $today;
		$pageChangeFrequency = "daily";
		$pagePriority = 0.8;
		$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
	}
}


//Getting all the blog posts from the database for indexing
$sql =  "SELECT * FROM blog_posts ORDER BY Time DESC";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$pageUrl = "https://www.ajiriwa.net/blog-single-post.php?id=".$row['ID'];
	$pageLastModified = $row['update-date'];
	$pageChangeFrequency = "yearly";
	$pagePriority = 0.8;
	$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
}
//Getting to CVs of all people who have allowed their cv to appear on search 
$sql = "SELECT * FROM subscribers WHERE cv_show = 'YES'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$pageUrl = "https://www.ajiriwa.net/showcv.php?data=".$row['username'];
	$pageLastModified = $row['last_activity'];
	$pageChangeFrequency = "daily";
	$pagePriority = 0.7;
	$urlsetValue .= makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
}
header('Content-type: application/xml; charset="utf-8"',true);
print "$xmlHeader
$urlsetOpen
$urlsetValue
$urlsetClose
";

$site = ob_get_clean();
echo $site;
file_put_contents(public_path("sitemap.xml"), $site);
?>