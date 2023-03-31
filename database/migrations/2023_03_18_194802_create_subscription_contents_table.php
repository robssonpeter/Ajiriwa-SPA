<?php

use App\Models\SubscriptionContent;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

const DEFAULT_PLANS = [
    [
        "name" => "Free Tier",
        "level" => 1,
        "user_type" => "employer",
        "price" => 0,
        "content" => [
            [
                "name" => "allowed_active_jobs",
                "label" => "Up to :val active job(s) at a time",
                "value" => 1,
            ]
        ]
    ],
    [
        "name" => "Mid Tier",
        "level" => 2,
        "user_type" => "employer",
        "price" => 40000,
        "content" => [
            [
                "name" => "allowed_active_jobs",
                "label" => " Up to :val active job(s) at a time",
                "value" => 5,
            ],
            [
                "name" => "job_screening",
                'label' => "Create job screening questions",
                'value' => true
            ]
        ]
    ]
];

class CreateSubscriptionContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('subscription_contents'))
            Schema::create('subscription_contents', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('value');
                $table->string('label');
                $table->unsignedInteger('plan_id', false);
                $table->timestamps();

            });

            foreach (DEFAULT_PLANS as $plan){
                // create the plan
                $saved = SubscriptionPlan::create($plan);
                // create the plan contents
                foreach($plan['content'] as $plan_content){
                    $plan_content['plan_id'] = $saved->id;
                    SubscriptionContent::create($plan_content);
                }
            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_contents');
    }
}
