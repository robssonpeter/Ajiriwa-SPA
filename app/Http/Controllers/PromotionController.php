<?php

namespace App\Http\Controllers;

use App\Custom\Promoter;
use App\Models\Job;
use App\Models\JobPromotion;
use Auth;
use DB;
use Illuminate\Http\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class PromotionController extends Controller
{
    public function adTrack()
    {
        $crawler_detect = new CrawlerDetect();
        //dd(request()->data);
        //dd($crawler_detect->isCrawler());
        /* if(!isset($resolver)){
            $resolver = "";
        }
        if(!isset($_SESSION['username']) AND !isset($_SESSION['company'])){
            include $resolver."cookie-manager.php";
        }  */
        //include $resolver."tools/bot-test.php";
        if (!$crawler_detect->isCrawler()) {
            if (request()->data) {
                $jobid = base64_decode(urldecode(request()->data));
                if (request()->promotion) {
                    $promID = base64_decode(urldecode(request()->promotion));
                    $promo = new Promoter;
                    $job = Job::where('id', $jobid)->select('slug')->first();

                    $promo->viewsCounter($promID);

                    //dd($promo);

                    $link = route('job.view', $job->slug) . "?promotion=" . urlencode(base64_encode($promID));
                    return redirect($link);
                }
            }
        }
    }

    public function promotionInsight()
    {
        $promotion_id = request()->promotion_id;
        $promotion = JobPromotion::where('PromotionID', $promotion_id)->first();
        $used = $promotion->Budget - $promotion->Available_balance;
        $budget = [
            'budget' => number_format($promotion->Budget),
            'balance' => number_format($promotion->Available_balance),
            'used' => number_format($used),
            'used_percent' => (int) round(($used * 100) / $promotion->Budget),
            'bal' => (int) $promotion->Available_balance,
            'ajiriwa_balance' => Auth::user()->ajiriwa_balance
        ];
        $impressions = DB::table('promotion_logs')
            ->where('Promotion_ID', $promotion_id)
            ->where('Activity_type', 'Impression')
            ->count();
        $views = DB::table('promotion_logs')
            ->where('Promotion_ID', $promotion_id)
            ->where('Activity_type', 'View')
            ->count();
        $applications = DB::table('promotion_logs')
            ->where('Promotion_ID', $promotion_id)
            ->where('Activity_type', 'Application')
            ->count();
        $statistics = Promoter::getChartData($promotion_id);
        return compact('impressions', 'views', 'applications', 'budget', 'statistics');
    }

    public function changeStatus()
    {
        if(request()->job_id){
            $promotion = DB::table('job_promotions')->where('Job_ID', request()->job_id)->first();
            $promotion_id = $promotion->PromotionID;
        }else{
            $promotion_id = request()->promotion_id;   
        }
        $status = request()->status;
        return DB::table('job_promotions')->where('PromotionID', $promotion_id)->update(['Status' => $status]);
    }

    public function changeBudget()
    {
        $promotion_id = request()->promotion_id;
        $type = request()->type;
        $amount = request()->amount;

        if (strtolower($type) == 'increase') {
            $changed = DB::table('job_promotions')->where('PromotionID', $promotion_id)->increment('Budget', $amount);
            $changed = DB::table('job_promotions')->where('PromotionID', $promotion_id)->increment('Available_balance', $amount);
        } else if (strtolower($type) == 'decrease') {
            $changed = DB::table('job_promotions')->where('PromotionID', $promotion_id)->decrement('Budget', $amount);
            $changed = DB::table('job_promotions')->where('PromotionID', $promotion_id)->decrement('Available_balance', $amount);
        }


        // change the ajiriwa balance of that user
        $sign = strtolower($type) == 'increase' ? '-' : '+'; // inverse relationship
        chargeAjiriwaBalance($amount, $sign, Auth::user()->id);
        return $changed;
    }
}
