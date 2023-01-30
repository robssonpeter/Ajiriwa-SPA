<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Custom\SEOTools;
use Illuminate\Support\Facades\DB;

class SEOController extends Controller
{
    public function sitemap(){
        ob_start();
        $isoLastModifiedSite = "";
        $newLine = "\n";
        $indent = " ";

        $rootUrl = env('APP_URL');

        $xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."<!--".$_SERVER['HTTP_USER_AGENT']."-->"."$newLine";


        $urlsetOpen = "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\"	
        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"	
        xsi:schemaLocation=\"http://www.google.com/schemas/sitemap/0.84	
        http://www.google.com/schemas/sitemap/0.84/sitemap.xsd\">$newLine";
        $urlsetValue = "";
        $urlsetClose = "</urlset>$newLine";
        
        $today = date("Y-m-d");
        $sql =  Job::where('deadline', '>=', $today)->orderBy('created_at', 'DESC')->get();
    
        foreach($sql as $row){
            $pageUrl = $row->old_id?"https://www.ajiriwa.net/job-page.php?data=".$row->old_id:route('job.view', $row->slug);
            $pageLastModified = $row->updated_at;
            $pageChangeFrequency = "daily";
            $pagePriority = 0.8;
            $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
        }

        //Home page
        $pageUrl =  route('root');
        $pageLastModified = date("Y-m-d h:i:sa");
        $pageChangeFrequency = "hourly";
        $pagePriority = 1.00;
        $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);

        //About US
        $pageUrl =  "https://www.ajiriwa.net/about-us";
        $pageLastModified = date("Y-m-d h:i:sa");
        $pageChangeFrequency = "Yearly";
        $pagePriority = 0.90;
        $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);

        //Browse Jobs
        $pageUrl =  route('jobs.browse.ext');
        $pageLastModified = date("Y-m-d h:i:sa");
        $pageChangeFrequency = "hourly";
        $pagePriority = 0.90;
        $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
        
        // Login Page
        $pageUrl =  route('login');
        $pageLastModified = date("Y-m-d h:i:sa");
        $pageChangeFrequency = "never";
        $pagePriority = 0.90;
        $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);

        // Blog
        $pageUrl =  route('blog.index');
        $pageLastModified = date("Y-m-d h:i:sa");
        $pageChangeFrequency = "weekly";
        $pagePriority = 0.90;
        $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);

        // Contact
        $pageUrl =  route('contact');
        $pageLastModified = date("Y-m-d h:i:sa");
        $pageChangeFrequency = "weekly";
        $pagePriority = 0.90;
        $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);
        
        // password recovery
        $pageUrl =  route('root')."/forgot-password";
        $pageLastModified = date("Y-m-d h:i:sa");
        $pageChangeFrequency = "weekly";
        $pagePriority = 0.90;
        $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);


        //jobs
        $pageUrl =  route('root')."/jobs.php";
        $pageLastModified = date("Y-m-d h:i:sa");
        $pageChangeFrequency = "Hourly";
        $pagePriority = 0.70;
        $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority);

        //Getting all the keywords from the database for indexing
        $sql =  DB::table('keywords')->orderBy('ID', 'DESC')->get();
        
        foreach($sql as $row){
            $pageUrl = route('root')."/search.php?search=".urlencode($row->keyword);
            $pageLastModified = $today;
            $pageChangeFrequency = "daily";
            $pagePriority = 0.8;
            $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority).'\n';
        }

        // Getting all the key words for companies
        $sql =  DB::table('keywords_for_companies')->orderBy('ID', 'DESC')->get();

        foreach($sql as $row){
            $sqlcomp = DB::table('companies')->orderBy('ID', 'DESC')->where('name', '!=', '')->select('name')->get();
            foreach($sqlcomp as $company){
                $pageUrl = route('root')."/jobs.php?keyword=".urlencode($row->keyword)."&comp=".urlencode($company->name);	
                $pageLastModified = $today;
                $pageChangeFrequency = "daily";
                $pagePriority = 0.8;
                $urlsetValue .= SEOTools::makeUrlTag ($pageUrl, $pageLastModified, $pageChangeFrequency, $pagePriority).'\n';
            }
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
    }
}
